<?php
declare(strict_types=1);

namespace App\Controller\Component;

use App\Model\Entity\Post;
use App\Model\Entity\User;
use App\Utility\CustomString;
use Cake\Controller\Component;
use Cake\Collection\Collection;
use Cake\Controller\Exception\MissingActionException;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Http\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;
use Cake\ORM\Query;
use Cake\Validation\Validation;

/**
 * Newsfeed component
 *
 * @property \App\Controller\Component\UserComponent $UserProfiler
 * @property \Cake\Controller\Component\PaginatorComponent $Paginator
 * @property \App\Model\Table\UsersTable $Users
 * @property \App\Model\Table\ConnectionsTable $Connections
 * @property \App\Model\Table\FollowsTable $Follows
 * @property \App\Model\Table\PostsTable $Posts
 * @property \App\Model\Table\Activities $Activities
 * @property \Cake\Controller\Component\FlashComponent $Flash
 *
 */
class NewsfeedComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    public $components = ['CustomString', 'Paginator', 'User','UserProfiler','Flash'];

    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->_tableLocator = TableRegistry::getTableLocator();
        $this->Users = $this->_tableLocator->get('Users');
        $this->Posts = $this->_tableLocator->get('Posts');
        $this->Connections = $this->_tableLocator->get('Connections');
        $this->Follows = $this->_tableLocator->get('Follows');
        $this->NewsFeeds = $this->_tableLocator->get('NewsFeeds');
        $this->Activities = $this->_tableLocator->get('Activities');
    }

    /**
     * @param array $params
     * @param array $path
     * @return mixed
     * @throws MissingActionException
     */
    public function handle(array $params = [], array $path = [])
    {
        if (count($path) > 0) {
            $key = array_keys($path)[0];
            $subHandler = Inflector::camelize($path[$key]);
            $subHandler = lcfirst($subHandler);
            array_shift($path);
            return $this->{$subHandler}($params, $path);
        }

//        $token = $params[0];
//        $readToken = base64_decode($token);
//        $options = (array) unserialize($readToken);
//        $what = $options['what'];
//        $suggestWhat = 'suggest' . Inflector::camelize($what);
//        array_shift($options);
//        return $this->{$suggestWhat}($options);
    }



    /**
     * @param array $path
     * @param array $queryParams
     * @return array|\Cake\Http\Response
     */
    public function threads(array $params)
    {
        $response = $this->getController()->getResponse();
        $actor = $this->getConfig('user');
        $filter = 'allForUser';

        if (isset($params['cw_aid'])) {
            $actor = $this->Users->get($params['cw_aid']);
        }
        if (isset($params['cw_ftr'])) {
            $filter = lcfirst(
                Inflector::camelize($params['cw_ftr'])
            );
        }

        if (!$actor instanceof User) {
            return $response->withStatus(500)->withStringBody('Sorry, unkown user');
        }
        $threads = $this->Posts->find($filter, ['actor' => $actor]);
        $threads = $threads->orderDesc('Posts.id');
        $arrayTimeline = $threads->toArray();
        $collection = collection($arrayTimeline);

        $threadedPosts = $collection->each(
            function (Post $post) {
                $post->set(
                    'comments',
                    $this->Posts->getDescendants($post->refid)
                );
                return $post;
            }
        );

        $groupedTimeline = $threadedPosts->groupBy(function ($post) {
            return $post->year;
        })->toArray();

        $this->getController()->set('account', $actor);
        $this->getController()->viewBuilder()->setTemplatePath('Posts');

        return $groupedTimeline;
    }

    public function posts(array $params)
    {
        if (isset($params['cw_aid'])) {
            $cwAid = CustomString::sanitize($params['cw_aid']);
            $author = $this->Users->get($cwAid);
            if (!$author instanceof User) {
                throw new NotFoundException();
            }
        }
        if (isset($params['cw_uid'])) {
            $cwUid = CustomString::sanitize($params['cw_uid']);
            $user = $this->Users->get($cwUid);
            if (!$user instanceof User) {
                throw new NotFoundException();
            }
        }
        $finder = 'all';
        $filter = null;
        if (isset($params['cw_fdr'])) {
            $finder = CustomString::sanitize($params['cw_fdr']);
            $finder = lcfirst(Inflector::camelize($finder));
        }
        if (isset($params['cw_ftr'])) {
            $filter = CustomString::sanitize($params['cw_ftr']);
            $filter = lcfirst(Inflector::camelize($filter));
        }
        $options = [];
        if (isset($author)) {
            $options['author'] = $author;
        }
        if (isset($user)) {
            $options['user'] = $user;
        }
        
        $posts = $this->Posts->find($finder, $options);
//        debug($posts);
//        exit;
        if (!is_null($filter)) {
            $applyFilter = 'filterBy' . ucfirst($filter);
            $posts = $this->Posts->{$applyFilter}($posts, $options);
        }
        if (!count($posts->getContain())) {
            $associations = $this->Posts->associations()->keys();
            $posts = $posts->contain($associations);
        }
        
//        $posts = $this->Posts->findThreaded($posts, [
//            'keyField' => 'id',
//            'parentField' => 'ancestor_id',
//            'nestingKey' => 'children'
//        ]);
        if (isset($params['cw_p_y']) && Validation::date($params['cw_p_y'], 'Y')) {
            $year = $params['cw_p_y'];
            $posts = $this->Posts->findByYear($posts, ['year' => $year]);
        }

        $orderBy = 'id';
        $dir = 'DESC';
        $sortBy = '';
        if (isset($params['cw_odr'])) {
            $orderBy = CustomString::sanitize($params['cw_odr']);
        }
        if (isset($params['dir'])) {
            $dir = CustomString::sanitize($params['dir']);
        }
        if (isset($params['sort'])) {
            $sortBy = CustomString::sanitize($params['sort']);
        }

        $posts = $posts->order(["Posts.$orderBy" => $dir]);
        if (!empty($sortBy)) {
            $posts = $posts->sortBy(function ($post) use($sortBy) {
                return $post[$sortBy];
            }, $dir);
        }

//        if (isset($posts['cw_post_grp'])) {
//            $posts = $posts->groupBy(function ($post) {
//                return $post->year;
//            })->toArray();
//        }

//        $posts = (new Paginator())->paginate($posts)->toArray();

        return $posts->all();
    }

    public function feeds()
    {
        $request = $this->getRequest();
        $response = $this->getResponse();
        $actor = $this->getActiveUser();
        if ($request->getQuery('src')) {
            $src = $request->getQuery('src');
            $srcArr = explode('/', $src);
            if (count($srcArr) > 1) {
                $uid = $srcArr[1];
                $actor = $this->Users->get($uid);
            }
        }
        if (!$actor instanceof User) {
            return $response->withStatus(500)->withStringBody('Sorry, unkown user');
        }
        $timeline = $this->Newsfeed->fetchAllFor($actor);

        $timeline = $timeline->orderAsc('Posts.id');
        $timeline = $this->paginate($timeline);
        $arrayTimeline = $timeline->toArray();
        $collection = new Collection($arrayTimeline);
        $threadedPosts = $collection->each(
            function (Post $post) {
                $post->set(
                    'comments',
                    $this->Posts->getDescendants($post->refid)
                );
                return $post;
            }
        );

        $newTimeline = $threadedPosts->groupBy(function ($post) {
            return $post->year;
        })->toArray();

        $this->viewBuilder()->setTemplatePath('Posts');
        $this->set(['timeline' => $newTimeline, '_serialize' => 'timeline']);
        $this->render('timeline');
    }

    public function getFeedSources($refid = null, $include_followed_feeds = false)
    {
        if (is_null($refid)) {
            if ($this->user)
                $refid = $this->user->refid;
        }
        // The primary source is the user
        $sources = [$refid];

        // Get IDs of user's connections
        $sources += (array) $this->getConnectionsIds($refid);

        if ($include_followed_feeds) {
            // IDs of users to which timeline the use is subscribed
            $sources += (array) $this->getFollowedFeeds($refid);
        }

        return $sources;
    }

    /**
     *
     * @param array $resultSet
     * @param string $field
     */
    public function extractSingleFieldFromEachArrayItem(array $resultSet, string $field) {
        $IDs = [];
        if (strpos($field, '.'))
            $field = str_replace('.', '->', $field);
        (new Collection($resultSet))->each(function($item) use (&$IDs, $field) {
            $IDs[] = $item->$field;
        });

        return $IDs;
    }

    /**
     *
     * @param string $actor_refid
     * @return array
     */
    public function getNewsSources($actor_refid)
    {
        $connectionsIDs = $feeds = [];
        $connections = (array) $this->User->connections($actor_refid)->toArray();
        $connectionsIDs = (new Collection($connections))->map(
            function ($item) {
                return $item->refid;
            }
        )->toArray();

        $followings = $this->User->getFollowings($actor_refid);
        // $this->Follows->find('followings', ['user' => $actor_refid]);
        $followingsIDs = $followings->map(function ($item) {
            return $item->followee_refid;
        })->toArray();

        $sources = array_merge($connectionsIDs, $followingsIDs);

        return $sources;
    }


    /**
     *
     * @param string $refid The primaryKey of the post
     * @return \App\Model\Entity\Post
     */
    public function getPost($refid, $conditions = [])
    {
        $options = [
            'conditions' => ['Posts.refid' => $refid],
            'contain' => [
                'Authors' => ['Profiles'], // Each post contains details of the author and their profile
                'OriginalAuthors' => ['Profiles'], // Each post (where available) contains information about the original author
                'OriginalPosts' => ['Authors' => ['Profiles']],
                'Reactions' => ['Reactors' => ['Profiles']],
                'Attachments'
            ]
        ];
        if (!empty($conditions)) {
            $options['conditions'] += $conditions;
        }

        $query = $this->Posts->find('all', $options);
        if (!$query || $query->isEmpty()) {
            return false;
        }
        $query = $this->Posts->dateFormat($query, 'Posts.date_published');
        $post = $query->first();
        $comments = $this->Posts->getThread(['Posts.replying_to' => $post->refid]);
        $comments = $this->Posts->dateFormat($comments, 'Posts.date_published')
            ->orderAsc('Posts.id');
        $comments = $comments->all()->toArray();
        $post->set('comments', $comments);

        return $post;
    }

    /**
     * @param User|null $actor
     * @return array|Query
     */
    public function fetchAllFor(
            User $actor = null,
            $filter = null,
            $filterVal = null
    ) {
        if (is_null($actor)) {
            $actor = $this->getController()->getActiveUser();
        }

        if (!$actor instanceof User) {
//            $this->getController()->shutdownProcess();
        }

        $newsSources = $this->getNewsSources($actor->get('refid'));
        // All posts are ordered in the order by which they are posted,
        // irrespective of the authors' position in the sources list above

        $Posts = $this->Posts;
        // This is where the magic happens
        $timelineResults = $Posts->getAll(['Posts.status' => 'published']);

        if (is_null($filter)) {
            $filter = 'by_author';
        }
        if (is_null($filterVal)) {
            $filterVal = 'anyone';
        }

// Applying filters
        $filterMethod = 'filter' . Inflector::camelize($filter);
        if (method_exists($Posts, $filterMethod)) {
            $timelineResults = $Posts->{$filterMethod}(
                    $actor, $timelineResults, $filterVal, $newsSources
            );
        }

//        Injecting ads
//        $timelineResults = $this->injectAdsToFeed($timelineResults);

        return $timelineResults;
    }

    /**
     * Post decorator method
     *  Use this method to apply any necessary modification you want on each
     *  post
     *
     * @param array $row
     * @return array
     */
    public function postDecorator(array $row)
    {
        if (array_key_exists('Posts__post_text', $row)) {
//            if (in_array($row['Posts__type'], ['comment','reply'])) {
            try {
                $children = $this->getPostChildren($row['Posts__refid'], ['Posts.status' => 'published']);
//                $children->decorateResults($this, 'postDecorator');
//                pr($children->all()->toArray());
                if (!$children->isEmpty()) {
                    $row[Inflector::pluralize($row['Posts__type'])] = $children->all();
                }
            } catch (RecordNotFoundException $exc) {

            }
//            } else {
//                $children = $this->getPostChildren($row['Posts__refid'], 'comment', ['Posts.status' => 'published']);
//                $children->decorateResults($this, 'postDecorator');
////                pr($children->all());
//                if (!$children->isEmpty()) {
//                    $row['Posts__comments'] = $children->all();
//                }
//            }
        }

        return $row;
    }

    /**
     *
     * @param string $post
     * @param string $type
     * @param array $options
     * @return \Cake\ORM\Query
     */
    public function getPostChildren($post, $options = null)
    {

        $conditions = [
            'Posts.replying_to' => $post
        ];
        $children = $this->Posts->find()
            ->contain([
                'Authors' => ['Profiles'],
                'OriginalAuthors' => ['Profiles'],
                'OriginalPosts' => ['Authors' => ['Profiles']],
                'Reactions' => ['Reactors' => ['Profiles']],
                'Attachments'
            ]);

        if ($options) {
            $conditions += $options;
        }

        $children->where($conditions);

        return $children;
    }

    /**
     *
     * @param string $author_refid
     * @param boolean $include_comments
     * @param string $filter
     * @return \Cake\ORM\Query
     */
    public function bkp_getTimeline(User $actor = null, $include_comments = true, $filter = 'any', $offset = 0, $limit = 12)
    {
        if (is_null($actor)) {
            if ($this->user)
                $actor = $this->user;
        }

//        $sources = $this->getSources($actor->get('refid'));
        $newsfeeds = $this->getNewsSources($actor->get('refid'))->toArray();

        $Posts = $this->getController()->getTableLocator()->get('Posts');
        $Connections = $this->getController()->getTableLocator()->get('Connections');
        $query = $Posts->find();
        $query = $Posts->applyDateFormatting($query, 'Posts.date_published');

        $query = $query->where([
            'Posts.author_refid' => $actor->get('refid')
        ]);

//        array_walk($sources, function (&$source, $index) use (&$query) {
//            $query = $query
//                    ->orWhere([
//                        'OR' => [
//                            'Posts.author_refid' => $source['refid']
//                        ],
//                        'Posts.created >=' => $source['date_connected']
//                    ]);
//        });
        $arrObj = new \ArrayObject($newsfeeds);
        $arrIterator = $arrObj->getIterator();
        while ($arrIterator->valid()) {
            $row = $arrIterator->current();
            $query = $query
                ->orWhere([
                    'OR' => [
                        'Posts.author_refid' => $row->feed_refid
                    ],
                    'Posts.date_published >=' => $row->created
                ]);
            $arrIterator->next();
        };
//        print_r($query);
//        exit;
////        array_map(function ($source) use (&$query) {
////             $query = $query
////                    ->orWhere([
////                        'OR' => [
////                            'Posts.author_refid' => $source
////                        ],
////                        'Posts.created >=' => $Connections->getConnectionDate($source, $refid)
////                    ]);
////        }, $sources);
//        if ($this->Cookie->check('UserPreferences.paged_result_limit'))
//            $pagination_limit = $this->Cookie->read('UserPreferences.paged_result_limit');
//        else
//            $pagination_limit = 12;

        $query = $query->orderDesc('Posts.id');
//
        $items = $query->all()->toArray();
        $items = $this->addBatchPostProperties($items);
        $items = $items->groupBy('year_published');
//        $feedItems = $groupedByYear->toArray();
//        arsort($feedItems);

        return $items;
    }

    /**
     *
     * @param Query $feedQuery
     * @return Query
     */
    public function injectAdsToFeed(Query $feedQuery)
    {
        $ads = $this->getController()->getPromotedContents();
        $feedWithAds = $feedQuery->union($ads);

        return $feedWithAds;
    }
}
