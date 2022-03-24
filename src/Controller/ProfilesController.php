<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Controller\Component\CustomStringComponent;
use App\Utility\CustomString;
use Cake\Core\Configure;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Event\Event;
use Cake\Event\EventInterface;
use Cake\Http\Exception\NotFoundException;
use Cake\ORM\Locator\TableLocator;
use Cake\Routing\Router;
use Cake\Utility\Text;
use Cake\Utility\Inflector;
use Cake\Collection\Collection;
use Cake\View\Exception\MissingTemplateException;
use Cake\View\CellTrait;

/**
 * Profiles Controller
 *
 *
 * @property CustomStringComponent $CustomString
 * @method \App\Model\Entity\Profile[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProfilesController extends AppController
{
    use CellTrait;

    /**
     *
     * @var \App\Model\Entity\User
     */
    protected $_account;

    public function initialize(): void
    {
        parent::initialize();

        $this->Auth->allow();
        $this->loadComponent('CustomString');
//        $this->loadComponent('User');
//        $this->loadModel('s');
        $this->viewBuilder()->setLayout('profile');
//        $this->enableSidebar(false);
//        $this->collapseOffCanvas(true);
    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        $username = $this->getRequest()->getParam('username');
        $username = CustomString::sanitize($username);
        try {
            $options = [
                'Connections',
                'Followers',
                'Followings',
                'Profiles' => [
                    'Roles',
                    'Industries',
                    'Genres',
                    'Languages'
                ]
            ];
            $account = $this->Users->getUser($username, $options);
        } catch (RecordNotFoundException $e) {
            if (Configure::read('debug')) {
                throw $e;
            }

            $this->unknownUser($username);
        }
        if (isset($account)) {
            // Let's save this profile's account details in a special cookie
            // called 'profile_views'. This will enable to determine users'
            // behavior while and after viewing a user's profile.
            $this->_account = $account;
            $this->set('account', $account);
        }
    }

    public function beforeRender(EventInterface $event) {
        parent::beforeRender($event);
    }


    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
//    public function index($username)
//    {
//        $request = $this->getRequest();
//        $isAjax = $request->is('ajax');
//
//        if ($isAjax) {
//            $this->viewBuilder()->setLayout('ajax');
//        }
//
//        // Prevent illegal dots in the path
//        if (in_array('..', $path, true) || in_array('.', $path, true)) {
//            throw new ForbiddenException();
//        }
//
//        // Find the user by the given username
//        if (! $this->Users->exists(['username' => $username])) {
//            return $this->setAction('unknownUser');
//        }
////        $profile = $account = $this->Users->getUser($username, [
////            'Followers',
////            'Followings',
////            'Connections',
////            'Posts'
////        ], false);
//        $profile = $account = $this->Users->getUser($username, [], true);
//
//        pr($profile);
//        exit;
//        $this->_account = $account;
//        $page = $subpage = null;
//
//        if (!empty($path[0])) {
//            $page = $path[0];
//        }
//        if (!empty($path[1])) {
//            $subpage = $path[1];
//        }
//
//        $pageTitle = $subpage ? ucfirst($subpage) : ucfirst($page);
//
//        $this->set(compact('page','subpage','pageTitle','profile', 'path','account'));
//        $this->set('_serialize', 'account');
//
//        if (count($path)) {
//            try {
//                $this->viewBuilder()->setTemplate(implode(DS, $path));
//            } catch (\Exception $exception) {
//                if (Configure::read('debug')) {
//                    throw $exception;
//                }
//                throw new NotFoundException();
//            }
//        }
//
//        array_shift($path);
//        if ($this->hasAction($page)) {
//            return $this->{$page}($path);
//        }
//
////        $suggestedUsers = [
//            // Accounts that may be familier to the currently logged in user (if any);
//            // This method will return null if there is no logged in user
////            'familier_accounts' => $this->UserActivities->getFamiliarUsers($this->__getAccount()),
//
//            // A list of accounts that are similar to the one being viewed
////            'similar_accounts' => $this->UserProfiler->getSimilarAccounts($this->__getAccount()),
//
//            // A list of randomly selected users which you might be interested in
//            // This suggestion is based on the viewer's previous activities
//            // and users viewed or followed in recent times
////            'people_to_meet' => $this->UserActivities->findPotentialConnections($this->__getAccount()),
//
//            // Returns a list of users viewed by others after the current one
////            'alternative_views' => $this->UserActivities->getPopularViews($this->__getAccount())
////        ];
//
//        // List of articles written about the selected user, or even mentioning their name
////        $articlesAboutUser = (array) $this->getUserRelatedArticles($this->__getAccount(), 0, 5);
//
//        // List of people who have said something or are currently discussing the user
////        $peopleTalkingAboutUser = (array) $this->getPeopleTalkingAboutUser($this->__getAccount(), 0, 5, 'total');
//
////        $this->set(compact('profile'));
//
//    }

    public function index($username)
    {
        
    }

    public function display(...$path)
    {
        array_shift($path);
        parent::display(...$path);
    }

    public function view(...$path)
    {
        $request = $this->getRequest();
        $isAjax = $request->is('ajax');
        if ($isAjax) {
            $this->viewBuilder()->setLayout('ajax');
        }
//        if (count($path)) {
//            $username = $path[0];
//            array_shift($path);
//        }
        $page = 'profile';
        if (count($path)) {
            $page = $path[0];
        }

        // Find the user by the given username
        $Users = $this->getTableLocator()->get('Users');
        $profile = $Users->getUser($username);
        if (!$profile) {
            return $this->setAction('unknownUser');
        }
//        $profile = $this->UserProfiler->addProperties($profile);
        $this->_account = $profile;
        $isAccountOwner = $this->UserProfiler->isAccountOwner($profile);

        // Define the widgets required on this page
        $this->_setPageRequiredWidgets([
                'leftCol' => [
                    'user_likes',
                    'user_activity',
                    'due_events'
                ],
                'centerCol' => ['newsfeed'],

                'rightCol' => [
                    'people_to_meet',
                    'people_you_may_know',
                    'ads',
                ]
            ], $profile);

        $suggestedUsers = [
            // Accounts that may be familier to the currently logged in user (if any);
            // This method will return null if there is no logged in user
            'familier_accounts' => $this->UserActivities->getFamiliarUsers($this->__getAccount()),

            // A list of accounts that are similar to the one being viewed
            'similar_accounts' => $this->UserProfiler->getSimilarAccounts($this->__getAccount()),

            // A list of randomly selected users which you might be interested in
            // This suggestion is based on the viewer's previous activities
            // and users viewed or followed in recent times
            'people_to_meet' => $this->UserActivities->findPotentialConnections($this->__getAccount()),

            // Returns a list of users viewed by others after the current one
//            'alternative_views' => $this->UserActivities->getPopularViews($this->__getAccount())
        ];

        // List of articles written about the selected user, or even mentioning their name
        $articlesAboutUser = (array) $this->UserActivities
                ->getUserRelatedArticles($this->__getAccount(), 0, 5);

        // List of people who have said something or are currently discussing the user
        $peopleTalkingAboutUser = (array) $this->UserActivities
                ->getPeopleTalkingAboutUser($this->__getAccount(), 0, 5, 'total');

        $pageTitle = ucfirst($page);
        $this->set(compact('profile','page','pageTitle','suggestedUsers', 'articlesAboutUser','peopleTalkingAboutUser'));
        $action = lcfirst(Inflector::camelize($page));

        return $this->setAction($action, $path);
    }


//    public function events(string $username, $path = null)
//    {
//        $account = $this->__getAccount();
//        $query = $this->Events->find('byUser', ['user' => $account->get('refid')]);
//        $filter = 'active';
//        if ($path !== null && !empty($path)) {
//            if (is_array($path)) {
//                $filter = $path[0];
//            } elseif(is_string($path)) {
//                $filter = $path;
//            }
//        }
//        if ($this->Events->hasFinder($filter)) {
//            $query = $query->find($filter);
//        }
//        $events = $this->paginate($query);
//
//        $this->set(compact('events'));
//    }
//
//    /**
//     *
//     * @param string $path
//     */
//    public function photos()
//    {
//        
//        $this->loadModel('Albums');
//        $this->loadModel('Photos');
//
//        $account = $this->_getAccount();
//        $query = $this->Albums->find('byMediaType', ['media_type' => 'photo']);
//        $query = $this->Albums->findByOwner($query, ['owner' => $account->get('refid')]);
//
//// Access level control
//// By default, only albums and photos user makes public will be shown to the viewer
//        $accessLevel = ['public'];
//        $loggedUser = $this->getActiveUser();
//        if ($loggedUser) {
//            if ($loggedUser->isSameAs($account)) {
//                $accessLevel += ['private','connections','mutual_connections'];
//            } elseif ($loggedUser->isConnectedTo($account)) {
//                $accessLevel[] = 'connections';
//            } elseif ($loggedUser->isMutualConnectionOf($account)) {
//                $accessLevel[] = 'mutual_connections';
//            }
//        }
//
//        $query = $this->Albums->findByPrivacy($query, ['privacy' => $accessLevel]);
//
//        $query->contain(['Photos','Owners'])
//                ->matching('Photos', function ($q) use ($accessLevel) {
//                    $q = $this->Photos->findByPrivacy($q, ['privacy' => $accessLevel])->orderDesc('id');
//                    return $q;
//                })
//                ->orderDesc('Albums.id');
//        $result = $this->paginate($query);
//
//        $this->set('photos', $result);
//    }
//
//    public function videos($path = null)
//    {
//        $request = $this->getRequest();
//        $requestParams = (array)$request->getQueryParams();
//        $paginationOffset = $this->getPaginationOffset();
//        $paginationLimit = $this->getPaginationLimit(); // \Cake\Core\Configure::read('ResultSet.pagination_limit');
//        $Videos = $this->getTableLocator()->get('Videos');
//        $query = $Videos->find()
//                ->where(['author_refid' => $this->__getAccount()->get('refid')])
//                ->orderDesc('id')
//                ->offset($paginationOffset)
//                ->limit($paginationLimit);
//        $videos = $Videos->applyDateFormatting($query);
//        $totalVideos = $videos->count();
//
//        // Set the id of the last item as the next result offset
//        if ($totalVideos > 0) {
//            $this->setNextPaginationOffset((int)$videos->last()->get('id'));
//        }
//        $videos = $videos->groupBy('year')->toArray();
//
//        $this->set(compact('videos','totalVideos'));
//    }
//
//    public function movies($path = null)
//    {
//        if ($this->__getAccount()->getNiche() != 'movie') {
//            $this->Flash->warning(__('Sorry, but {0} is not an actor/actress', $this->__getAccount()->getFullname()));
//            return $this->redirect(['action' => 'videos']);
//        }
//    }
//    public function songs($path = null)
//    {
//        if ($this->__getAccount()->getNiche() != 'music') {
//            $this->Flash->warning(__('Sorry, but {0} is not a musician', $this->__getAccount()->getFullname()));
//            return $this->redirect(['action' => 'audios']);
//        }
//        $request = $this->getRequest();
//        $requestParams = (array)$request->getQueryParams();
//        $paginationOffset = $this->getPaginationOffset();
//        $paginationLimit = $this->getPaginationLimit(); // \Cake\Core\Configure::read('ResultSet.pagination_limit');
//        $Audios = $this->getTableLocator()->get('Audios');
//        $query = $Audios->find('music')
//                ->where(['author_refid' => $this->__getAccount()->get('refid')])
//                ->orderDesc('id')
//                ->offset($paginationOffset)
//                ->limit($paginationLimit);
//        $query = $Audios->applyDateFormatting($query);
//        $resultsCount = $query->count();
//        $songs = $query->groupBy('year')->toArray();
//
//        // Set the id of the last item as the next result offset
//        if ($resultsCount > 0) {
//            $this->setNextPaginationOffset((int)$query->last()->get('id'));
//        }
//
//        $this->set(compact('videos'));
//    }
//
//    public function song($id) {
//
//    }
//
//
//    protected function _includeAlbumData(Collection $photos)
//    {
//        $photosArr = $photos->toArray();
//        $newCollection = [];
//        $this->loadModel('Albums');
//        foreach ($photosArr as $albumId => $photos) {
//            if (!empty($albumId)) {
//                $album = $this->Albums->get($albumId);
//                $newCollection[$albumId] = [$album, $photos];
//            }
//        }
//
//        return $newCollection;
//    }
//
//    public function albums($subpage = null)
//    {
//        $this->loadModel('Albums');
//        $this->loadModel('Photos');
//
//        $account = $this->__getAccount();
//        $query = $this->Albums->find('byOwner', ['owner' => $account->get('refid')]);
//
//// Access level control
//// By default, only albums and photos user makes public will be shown to the viewer
//        $accessLevel = ['public'];
//
//        if ($this->getActiveUser()) {
//            $activeUser = $this->getActiveUser();
//            if ($activeUser->isSameAs($account)) {
//                $accessLevel = ['private','connections','mutual_connections','public'];
//            } elseif ($activeUser->isConnectedTo($account)) {
//                $accessLevel = ['connections','public'];
//            } elseif ($activeUser->isMutualConnectionOf($account)) {
//                $accessLevel = ['mutual_connections','public'];
//            }
//        }
//
//        $query = $this->Albums->findByPrivacy($query, ['privacy' => $accessLevel]);
//
//        $query->contain(['Owners'])->orderDesc('Albums.id');
//        $albums = $this->paginate($query);
//        $albumGroups = $albums->groupBy('media_type')->toArray();
//
//        $this->set(compact('albumGroups'));
//    }
//
//    public function posts()
//    {
//
//        $this->Auth->allow();
//        echo 'Hello';
//        exit;
//        $account = $this->_account;
//        /* @var $posts \Cake\ORM\ResultSet */
//        $posts = $this->Posts->find('byAuthor', ['author' => $account->get('refid')]);
//        $posts->sortBy(function ($row) {
//            return $row->id;
//        }, 'DESC');
//        $this->set(compact('posts'));
//    }
//
//    public function post(...$args)
//    {
//        $username = array_shift($args);
//        $postID = array_shift($args);
//        $post = $this->Posts->get($postID, [
//            'contain' => [
//                'Authors' => ['Profiles'],
//                'Comments' => [
//                    'Authors' => ['Profiles'],
//                    'Replies' => ['Authors' => 'Profiles'],
//                    'Reactions' => ['Reactors' => ['Profiles']]
//                ],
//                'Reactions' => ['Reactors' => ['Profiles']]
//            ]
//        ]);
//
////        Text::
//
//        $this->set(['post' => $post, '_serialize' => 'post']);
//    }



    /**
     *
     * @return \App\Model\Entity\User
     */
    protected function _getAccount()
    {
        return $this->_account;
    }

    /**
     * Searches for articles where a user's name, username, or stage name, have been
     * mentioned on the site
     *
     * @param \App\Model\Entity\User $user
     * @param int $limit
     * @return  array|null
     */
    protected function _getUserRelatedArticles(User $user, $offset = 0, $limit = 5)
    {
        $newsTbl = $this->loadModel('ENews');
        $postsTbl = $this->loadModel('Posts');
//        $commentsTbl = $this->loadModel('Comments');
        $conn = $newsTbl->getConnection();
        $query = $newsTbl->find();

        $posts = $postsTbl->find()
            ->select(['refid'])
            ->where([
                'OR' => [
                    ['MATCH(post_text) AGAINST(\'"' . $user->getFullname() . '"\' IN BOOLEAN MODE)'],
                    ['MATCH(post_text) AGAINST(\'"' . $user->getFirstName() . ' ' . $user->getLastName() . '"\' IN BOOLEAN MODE)'],
                    ['MATCH(post_text) AGAINST(\'"@' . $user->getUsername() . '"\' IN BOOLEAN MODE)']
                ]
            ])
            ->andWhere([
                'privacy !=' => 'private',
                'status' => 'published',
            ]);

//        $comments = $commentsTbl->find()//(new DBQuery($conn))
//                ->select(['refid'])
////                ->from(['Comments' => 'comments'])
//                ->where([
//                    'MATCH(text) AGAINST(\'"'.$user->getFullname().'"\' IN BOOLEAN MODE)',
//                ])
//                ->orWhere([
//                    'MATCH(text) AGAINST(\'"'.$user->getFirstName() . ' ' . $user->getLastName().'"\' IN BOOLEAN MODE)',
//                ])
//                ->andWhere([
//                    'status' => 'published',
//                ]);

        $query = $query
            ->select(['refid'])
//                ->from(['ENews' => 'e_news'])
            ->where([
                'OR' => [
                    ['MATCH(title, body) AGAINST(\'"' . $user->getFullname() . '"\' IN BOOLEAN MODE)'],
                    ['MATCH(title, body) AGAINST(\'"' . $user->getFirstName() . ' ' . $user->getLastName() . '"\' IN BOOLEAN MODE)'],
                    ['MATCH(title, body) AGAINST(\'"@' . $user->get('username') . '"\' IN BOOLEAN MODE)']
                ]
            ])
            ->andWhere([
                'privacy !=' => 'private',
                'status' => 'published',
            ])
            ->unionAll($posts)
//                ->unionAll($comments)
            ->offset($offset)
            ->limit($limit);

        $matches = [];
        $query->each(function ($row) use ($postsTbl, /*$commentsTbl,*/ $newsTbl, &$matches) {
            $item = null;
            if ($postsTbl->exists(['refid' => $row->refid])) {
                $item = $postsTbl->get($row->refid);
            }
//            elseif ($commentsTbl->exists(['refid' => $row->refid])) {
//                $item = $commentsTbl->get($row->refid);
//            }
            elseif ($newsTbl->exists(['refid' => $row->refid])) {
                $item = $newsTbl->get($row->refid);
            }
            $matches[] = $item;
        });

        return $matches;
    }

    public function getPeopleTalkingAboutUser(\App\Model\Entity\User $user, $offset = 0, $limit = 5)
    {
        $articlesAboutUser = (array) $this->getUserRelatedArticles($user, $offset, $limit);

        $peopleTalkingAboutUser = [];
        if (count($articlesAboutUser)) {
            $Users = (new TableLocator)->get('Users');
            foreach ($articlesAboutUser as $article) {
                $peopleTalkingAboutUser[] = $Users->get($article->author_refid);
            }
        }

        return $peopleTalkingAboutUser;
    }
}
