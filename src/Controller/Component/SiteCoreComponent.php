<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Detection\MobileDetect;

/**
 * SiteCore component
 */
class SiteCoreComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public $components = ['UserActivities','UserProfiler','FileManager','UrlShortener','Status','AccountUpdater'];






    public function getActiveUser()
    {
        return $this->_activeUser;
    }


    /**
     *
     * @param string $credential
     * @return \App\Model\Entity\User | false
     */
    public function getUserObject($credential)
    {
//        $user = false;
//        $UsersTbl = $this->_tableLocator->get('Users');
//        $query = $UsersTbl->find('all')->where(['OR' => [
//            ['refid' => $credential],
//            ['username' => $credential],
//            ['email' => $credential],
//            ['phone' => $credential]
//        ]])->limit(1);
//
//        if ($query->count() >= 1) {
//            $user = $query->first();
//        }
        $UsersTbl = $this->getTableLocator()->get('Users');
        $user = $UsersTbl->getUser($credential);

        return $user;
    }

    /**
     * Fetch a user's data as an associative array
     *
     * @param string $credential
     * @return array Array representation of the user entity
     */
    public function getUserArray($credential)
    {
        $UsersTbl = $this->getTableLocator()->get('Users');
        $user = $UsersTbl->getUser($credential);
        $userArray = (array)$user->toArray();

        return $userArray;
    }

    public function buildUsersProfiles(array $users)
    {
        array_walk($users, function(&$user, $index) {
            $user = $this->buildUserProfile($user);
        });

        return $users;
    }

    /**
     * User Profiler method
     *
     * @param array|object App\Model\Entity\User $account
     * @return \stdClass object $account
     */
    public function buildUserProfile( \App\Model\Entity\User $account )
    {
        $fullname = $account->firstname . ' ' . $account->othernames;
        $fullname = rtrim($fullname, ' ');
        $fullname .= ' ' . $account->lastname;

        $account->fullname = $fullname; // $account->firstname . ' ' . $account->othernames . ' ' . $account->lastname;
        $account->hasPersonality = false;
        $account->acceptsFollowers = false;
        $account->canFollowOthers = true;
        $account->canFollowAnonymously = false;
        $account->canAddOwnMedia = false; // By default no one is allowed to upload anything except the one is musician
        $account->allowsViewersSeePlaylists = false;
        $account->personality = null;
        $account->genre = null;
//        $account->followers = [];
//        $account->followings = [];
        $account->similarAccounts = [];

        if ($account->personality_id) {
            $account->personality = (string) ucwords($this->getPersonality($account->personality_id));
            $account->hasPersonality = true;
            unset($account->personality_id);
        }

        // User can only accept followers or follow other users anonymously
        // if he has personality, i.e he is a singer and not a regular user;
//        if ($account->hasPersonality) {
//            $account->acceptsFollowers = true;
//            $account->canFollowAnonymously = true;
//        }
//
        if ($account->genre_refid) {
            $account->genre = strtoupper($this->getGenre($account->genre_refid));
        }
//        if ($account->acceptsFollowers) {
//            $account->followers = $this->getFollowers($account->refid);
//        }
//        $account->followings = $this->getFollowings($account->refid);
//        $account->totalFollowers = count($account->followers);
//        $account->totalFollowings = count($account->followings);
//        // Set empty variables for user's content
//        $account->gallery = $account->songs = $account->videos = $account->playlists = $account->albums = $account->feed = [];

        // Getting user's promoted media
        // $account->ads = (array) $this->getAds( $account->refid );
        return $account;
    }



    protected function _applyFiltering( \Cake\ORM\Table $table )
    {
        $request = $this->getRequest();
        $filterParams = $request->getQueryParams();
        $query = $table->find('all');
        if (isset($filterParams['cat']) && $table->hasField('category_refid'))
        {
            $query = $query->where(['category_refid' => $this->CustomString->sanitize($filterParams['cat'])]);
        }
        if (isset($filterParams['genre']) && $table->hasField('genre_refid'))
        {
            $query = $query->where(['genre_refid' => $this->CustomString->sanitize($filterParams['genre'])]);
        }
        if (isset($filterParams['album']) && $table->hasField('album_refid'))
        {
            $query = $query->where(['album_refid' => $this->CustomString->sanitize($filterParams['album'])]);
        }
        if (isset($filterParams['privacy']) && $table->hasField('privacy'))
        {
            $query = $query->where(['privacy' => $this->CustomString->sanitize($filterParams['privacy'])]);
        }
        if (isset($filterParams['keyword']) && ($table->hasField('title') || $table->hasField('description')))
        {
            $query = $query->where(['OR' => [
                'title LIKE' => '%'.$this->CustomString->sanitize($filterParams['keyword']).'%',
                'description LIKE' => '%'.$this->CustomString->sanitize($filterParams['keyword']).'%'
                ]
            ]);
        }

        return $query; // Return the query object instead of result set, makes it possible to be manipulated further
    }

    public function applySorting( \Cake\ORM\Table $table )
    {
        return $this->paginate()->sortBy($callback, $dir);
    }

    public function detectRequestOrigin()
    {
        $request = $this->getRequest();
        $requestOrigin = $request->getQuery('request_origin');
        $xForceFullRendering = (int) $request->getQuery('xffr');
        $xRequestedWith = $request->getQuery('xrw');

        if ($requestOrigin === 'iframe' && $xForceFullRendering === 0)
        {
            $this->viewBuilder()->setLayout('blank');
        }
        elseif ($request->is('ajax'))
        {
            $this->viewBuilder()->setLayout('ajax');
        }
    }



    /**
     *
     * @param array $widgets List of widgets required on the current page
     * @return $this
     */
    protected function _setPageRequiredWidgets(array $widgetsGroups, \App\Model\Entity\User $actor)
    {
        foreach ($widgetsGroups as $column => $widgets) {
            foreach ($widgets as $widget) {
                $fetcher = 'get' . Inflector::camelize($widget);
                // Skip any element if no coresponding method was found in the
                // UserActivities class
                if (!method_exists($this->UserActivities, $fetcher))
                    continue;
                $widg = (array)$this->UserActivities->{$fetcher}($actor);
//                if (count($widg)) {
                    $widgetsGroups[$column][$widget] = (array)$widg;
        //Example: $usefullWidgets['leftCol]['people_you_may_know'] = (arra)$widg;
//                }
            }
        }

        $this->_pageWidgets = $widgetsGroups;
        $this->set('widgets', $this->_pageWidgets);

        return $this;
    }

    /**
     *
     * @return string json encoded version of the page widgets
     */
    protected function _getPageRequiredWidgets()
    {
        $widgets = $this->_pageWidgets;
        return $widgets;
    }

    public function setNextPaginationOffset(int $num)
    {
        $request = $this->getRequest();
        $response = $this->getResponse();
        $cookie = new Cookie('DatabaseResultSet.pagination_offset');
        $cookie = $cookie->withValue($num)
                ->withNeverExpire()
                ->withPath('/')
                //->withDomain('')
                ->withSecure(false)
                ->withHttpOnly(true);

        $response = $response->withCookie($cookie);
        $this->setResponse($response);
    }

    public function getPaginationOffset()
    {
        $page = 1;
        $offset = 0; // By default the offset is 0;
        $limit = $this->getPaginationLimit();

        if ($this->Cookie->check('DatabaseResultSet.pagination_offset')) {
            $offset = (int)$this->Cookie->read('DatabaseResultSet.pagination_offset');
        }
        $queryParams = $this->getRequest()->getQueryParams();
        if (isset($queryParams['p'])) {
            $page = (int)$queryParams['p'];
        }

        // When the page is above 1, then the offset will be the product of
        // the result limit and the page number, then minus 1, given that counting
        // begins at 0
        if ($page > 1) {
            $offset = ($limit * $page) - 1;
        }
        else if ($page <= 1) {
            $page = 1;
            $offset = 0;
        }

        return $offset;
    }

    public function getPaginationLimit()
    {
        $limit = (int)$this->Cookie->read('DatabaseResultSet.pagination_limit');
        if ($limit < 1) {
            $limit = (int)Configure::read('DatabaseResultSet.pagination_limit');
        }
        if ($limit < 1) {
            $limit = 20;
        }

        return $limit;
    }

    /**
     * Methods below are under testing
     */

    /**
     *
     * @param string $author_refid
     * @param boolean $include_comments
     * @param string $filter
     * @return \Cake\ORM\Query
     */
    protected function _getNewsfeed(\App\Model\Entity\User $actor = null, $include_comments = true, $filter = 'any', $offset = 0, $limit = 20)
    {
        if (is_null($actor)) {
            if ($this->user)
                $actor = $this->user;
        }

        $sources = $this->_getSources($actor->get('refid'));
        $Posts = $this->getTableLocator()->get('Posts');
        $query = $Posts->find('all');
        $query = $Posts->applyDateFormatting($query, 'Posts.created');

        $query = $query->where([
            'OR' => [
                'Posts.author_refid' => $actor->get('refid')
            ]
        ]);
//        print_r($query);
//        exit;
        array_walk($sources, function (&$source, $index) use (&$query) {
            $query = $query
                    ->orWhere([
                        'OR' => [
                            'Posts.author_refid' => $source['refid']
                        ],
                        'Posts.created >=' => $source['date_connected']
                    ]);
        });
//        $pagination_limit = $this->Cookie->check('UserPreferences.paged_result_limit')?
//                $this->Cookie->read('UserPreferences.paged_result_limit') : 20;

        $query = $query
                ->contain([
                    'Users',
                    'Comments' => [
                        'Users',
                        /*'Replies'*/
                    ]
                ])
                ->orderDesc('Posts.id')
                ->offset($offset)
                ->limit($limit);

        $items = $query->all()->toArray();
        $groupedByYear = $this->addBatchPostProperties($items)->groupBy('year_published');
        $feedItems = $groupedByYear->toArray();
        arsort($feedItems);

        return $feedItems;
    }




    /**
     *
     * @param \Cake\ORM\Query $query
     * @return \Cake\ORM\Query $query
     */
    public function applyFormatting(\Cake\ORM\Query $query)
    {
//        $query = $query
//                ->map(function($posts) {
//                    $posts = array_map($this->addPostProperties, $posts);
//                    return $posts;
//                });

        return $query;
    }


    protected function _getPost($refid)
    {
        $PostsTbl = $this->getTableLocator()->get('Posts');

        $post = $PostsTbl->get($refid, [
            'contain' => [
                'Users' => 'author',
                'Comments' => [
                    'Users',
                    'Replies'
                ]
            ]
        ]);
//        $result = $query->all()->toArray();
//        if (count($result)) {
//            $post = $result[0];
//            $post->author = $post->user;
//            unset($post->user);
//        }

        return $post;
    }


    protected function _getSources($refid = null, $include_followed_feeds = false)
    {
        if (is_null($refid)) {
            if ($this->user)
                $refid = $this->user->refid;
        }

        $sources = [];
        $UsersTbl = $this->_tableLocator->get('Users');

        // Get user connections
        $cQuery = $this->UserProfiler->getConnections($refid);
        $connections = $cQuery->toArray();
        if (count($connections)) {
            foreach ( $connections as $connection ) {
                $sources[] = [
                    'refid' => $connection->person->refid,
                    'date_connected' => $connection->created
                ];
            }
        }
//        if ($include_followed_feeds) {
//            // IDs of users timeline the user is subscribed to
//            $sources += (array) $this->getFollowedFeeds($refid);
//        }

        // Removing duplicate entries
//        $sources = array_unique($sources);

        return $sources;
    }

    protected function _getFollowedFeeds($refid = null)
    {
        $followedFeeds = [];

        if (is_null($refid)) {
            if ($this->user)
                $refid = $this->user->refid;
        }

        $ff = $this->_tableLocator->get('FollowedFeeds');
        $query = $ff->find()
                ->select(['followee_id'])
                ->where(['follower_id =' => $refid]);
        $query = $ff->applyDateFormatting($query);
        if ($query->count() > 0) {
            $followedFeeds = $query->toArray();
        }

        return $followedFeeds;
    }

    /**
     *
     * @param mixed $post
     * @return mixed Description
     */
    protected function _addPostProperties($post)
    {
        $post->author = $post->user;
        $post->likesCount =
        $post->sharesCount =
        $post->repliesCount =
        $post->commentsCount = 0;

        if (isset($post->comments)) {
            $post->commentsCount =  count($post->comments);
            $post->comments = $this->addBatchPostProperties($post->comments, true);
            // By setting the second parameter above, the method returns array
            // instead of a collection object
        }
//        if (property_exists($post, 'author'))
        if (isset($post->likes)) {
            $post->likesCount = count($post->likes);
        }
        if (isset($post->shares)) {
            $post->shares->count = count($post->shares);
        }
        if ($post->hasAttachment()) {
            $attachments = Inflector::pluralize($post->get('type'));
            $post->$attachments = (array)$this->getAttachmentsByRefkey($attachments, $post->get('attachment_refkey'));
        }
        unset($post->user);

        return $post;
    }

    /**
     *
     * @param array $items
     * @return \Cake\Collection\Collection | array
     */
    protected function addBatchPostProperties(array $items, $preferArr = false)
    {
        $items = (new Collection($items))
                ->map(function ($item) {
                    $item = $this->addPostProperties($item);

                    return $item;
                });
        if ($preferArr) {
            $items = $items->toArray();
        }

        return $items;
    }

    protected function _getFeedSources($refid = null, $include_followed_feeds = false)
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

    protected function _getSuggestion($what, $actor, $filter = false)
    {
        $inflector = new Inflector();
        $action = lcfirst($inflector->camelize($what));

        return $this->{$action}($actor, $filter);
    }

    protected function _getPeopleToMeet(\App\Model\Entity\User $user, $filter = false)
    {
        if ($filter === false) {
            $filter = 'same_residence_and_niche';
        }

        $activeUser = $this->getController()->getActiveUser();
        $UsersTbl = $this->_tableLocator->get('Users');
        $ConxTbl = $this->_tableLocator->get('Connections');


        $users = $UsersTbl->getUnconnectedTo( $user->refid );
        $peopleToMeet = [];

        if ($activeUser) {
            $users = $users->where(['refid !=' => $activeUser->refid]);
        }
        $result = null;
        switch ($filter)
        {
            case 'all':
                $result = $users;
                break;
            case 'same_niche':
                $result = $users->where(['niche' => $user->niche]);
                break;
            case 'country_people':
                $result = $users->where(['country_of_origin' => $user->country_of_origin]);
                break;
            case 'country_people_same_niche':
                $result = $users->where([
                    'country_of_origin' => $user->country_of_origin,
                    'niche' => $user->niche
                    ]);
                break;
            case 'same_residence':
                $result = $users->where(['country_of_residence' => $user->country_of_residence]);
                break;
            case 'same_residence_and_niche':
                $result = $users->where([
                    'country_of_residence' => $user->country_of_residence,
                    'niche' => $user->niche
                    ]);
                break;
            default:
                $result = $users;
        }

        $peopleToMeet = $result->toArray();
//        if (count($peopleToMeet)) {
//            array_walk($peopleToMeet, function (&$v, $k) {
//                $UsersTbl->addFullname($v);
//            });
//        }
        return $peopleToMeet;
    }

    /**
     * Fetches a list of people who the use might know.
     *
     * @param \App\Model\Entity\User $user The user to make suggestions for
     * @return array A list of matched users
     */
    protected function _getPeopleYouMayKnow(\App\Model\Entity\User $user)
    {
        $Users = $this->_tableLocator->get('Users');
        $Connections = $this->_tableLocator->get('Connections');
        $connections = $Connections->getUserConnections($user->refid); // find('forUser', ['user' => $user->refid]);
        $peopleYouMayKnow = [];
        $connectionsOfConnections = [];

        if (count($connections))
        {
            foreach ($connections as $connection) {
                $except = ['user' => $user->refid];
                $cOfc = (array)$Connections->getUserConnections($connection->refid, $except);
                $connectionsOfConnections += $cOfc;
            }
        }
        if (count($connectionsOfConnections)) {
            foreach ($connectionsOfConnections as $cOfc) {
                $peopleYouMayKnow[] = $Users->getUser($cOfc->refid);
            }
        }

        return $peopleYouMayKnow;
    }

    protected function _getUserEngagements($param)
    {

    }

    /**
     * Retrieves all events either created by the user, or to which the user
     * is invited, which are 10 days or less closer to the start date
     *
     * @param \App\Model\Entity\User $actor
     */
    protected function _getDueEvents(\App\Model\Entity\User $actor)
    {
//        $Guests = $this->_tableLocator->get('EventInvitees');
//        $query = $Guests->find('all');
//        $_7daysInFuture = new \DateTime('7 days');
//        $now = new \DateTime('NOW');
//        print_r($now);
//        exit;
//        $query = $query->contain('Events', function (Query $q) {
//                    return $q->where([
//                        'start_date <=' => new \DateTime('7 days')
//                    ]);
//                })
//                ->where(['invitee_refid' => $actor->refid]);
//                print_r($query);
//                exit;
    }

    protected function _getUserInteractions($param)
    {

    }



    /**
     *
     * @param string $actor
     * @param array $object
     */
    protected function _getUserLikes(\App\Model\Entity\User $actor, array $object = null)
    {
        $Likes = $this->getTableLocator()->get('Likes');
        $items = $Likes->find()
                ->where([
                    'actor' => $actor->get('refid')
                ]);
        if (!is_null($object)) {
            $items = $items->where([
                'object_name' => $object['name'],
                'object_refid' => $object['refid']
            ]);
        }
        $items = $items->all()->toArray();

        if (! $object) {
            $items = (new Collection($items))
                ->map(function ($item) {
                    $obj = Inflector::pluralize(ucfirst($item->object_name));
                    $objId = $item->object_refid;
                    $object = $this->_tableLocator->get($obj)
                            ->find()
                            ->where(['refid' => $objId])
                            ->limit(1)
                            ->first();
                    $item->object = $object;

                    return $item;
                });
        }

        if (! is_array($items)) {
            $items = $items->toArray();
        }

        return $items;
    }

    public function getAttachmentsByRefkey($attachments, $refkey)
    {
        $attachments = Inflector::camelize($attachments);
        $results = [];
//        if ($this->_tableLocator->exists($attachments)) {
            $attachmentsTable = $this->_tableLocator->get($attachments);
            $query = $attachmentsTable->find()->where(['refkey' => $refkey]);
            $results = $query->all()->toArray();
//        }

        return $results;
    }

    public function getUserMedias($actor, $filter = 'all')
    {
        $medias = $this->_tableLocator->get('Medias');
        $medias = $medias->find($filter)
                ->where(['user_refid' => $actor]);
        if ($filter === 'all') {
            $medias = $medias->contain(['Users','Videos','Audios']);
        }

        return $medias;
    }
    protected function _fetchInterests($actor = null)
    {
        return false;
        $likes = $this->UserActivities->getUserLikes($actor->refid);
        $this->set('likes', $likes);
    }

    public function activities($actor = null)
    {

    }

    public function engagements($actor = null)
    {
        $engagements = $this->UserActivities->getUserEngagements($actor->refid);

        $this->set(compact('engagements'));
    }

    public function dueEvents($actor = null)
    {
        $dueEvents = $this->UserActivities->getDueEvents($actor->refid);

        $this->set(compact('dueEvents'));
    }

    public function interactions($actor = null)
    {
        $interactions = $this->UserActivities->getUserInteractions($actor->refid);

        $this->set(compact('interactions'));
    }

    public function suggestedConnections($actor = null)
    {
        $peopleToMeet = (array)$this->UserActivities->peopleToMeet($actor, 'all');

        $this->set('peopleToMeet', $peopleToMeet);
    }

    public function familierUsers($actor = null)
    {
        $peopleYouMayKnow = (array)$this->UserActivities->getPeopleYouMayKnow($actor, 'all');

        $this->set(compact('peopleYouMayKnow'));
    }

    public function getPromotedContents($status = 'active')
    {
        /* $acotr \App\Model\Entity\User */
        $actor = $this->getActiveUser();
        $visitor = $this->getVisitor();

        $adsTbl = $this->getTableLocator()->get('PromotedContents');
        $ads = $adsTbl->find()->where([
            'status' => $status
        ]);
        if ($actor) {
            $ads = $ads->where([
                'audience_min_age <=' => $actor->getAge(),
                'audience_max_age >=' => $actor->getAge(),
                'audience_location LIKE' => '%'.$actor->getCountryOfResidence().'%'
            ]);
        } else {
            $ads = $ads->where([
                'audience_min_age <=' => 18,
                'audience_max_age >=' => 65,
                'audience_location LIKE' => '%'.$visitor->getLocation().'%'
            ]);
        }

        return $ads;
    }

    public function getPromotedContentProperties()
    {

    }


    public function ads($actor = null)
    {

    }

    public function trends($actor = null)
    {

    }

    public function boxOffice($actor = null)
    {

    }

    public function billboard($actor = null)
    {

    }

    public function topProducers($actor = null)
    {

    }

    public function topDirectors($actor = null)
    {

    }

    public function topMarketers($actor = null)
    {

    }

    public function lipSync($actor = null)
    {

    }
}
