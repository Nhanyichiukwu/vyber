<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use App\Model\Entity\User;
use App\Utility\Folder;
use Cake\Controller\Controller;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\Event\EventInterface;
use Cake\Event\EventManager;
use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\I18n\Date;
use Cake\Routing\Router;
use Cake\Utility\Inflector;
use Cake\Utility\Text;
use Cake\I18n\Time;
use Cake\Http\Cookie\Cookie;
use App\Utility\RandomString;
use Cake\Validation\Validation;
use Cake\View\Exception\MissingTemplateException;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 *
 * @property \Cake\Controller\Component\RequestHandlerComponent $RequestHandler Instance of the RequestHandler component
 * @property \Cake\Controller\Component\Flash $Flash Instance of the Flash component
 * @property \Cake\Controller\Component\AuthComponent $Auth Instance of the Auth component
 * @property \Cake\Controller\Component\CookieComponent $Cookie Instance of the Cookie component
 * @property \App\Controller\Component\SiteCoreComponent $SiteCore
 * @property \App\Controller\Component\GuestsManagerComponent $GuestsManager
 * @property \App\Controller\Component\NotifierComponent $Notifier Instance of the Notifier component
 * @property \App\Controller\Component\UserActivitiesComponent $UserActivities Instance of the UserActivities Component
 * @property \App\Controller\Component\NewsfeedComponent $Newsfeed Instance of the Newsfeed Component
 * @property \App\Controller\Component\EEventListenerComponent $EEventListener Instance of the EEventListener Component
 * @property \App\Controller\Component\UserComponent $User Instance of the User Component
 * @property \App\Controller\Component\AuthServiceProviderComponent $AuthServiceProvider
 * @property \App\Model\Table\BkpCategoriesTable $Categories
 * @property \App\Model\Table\GenresTable $Genres
 * @property \App\Model\Table\UsersTable $Users
 * @property \App\Model\Table\BkpEventsTable $Events
 * @property \App\Model\Table\BkpEventsGuestsTable $EventManager
 * @property \App\Model\Table\BkpEventsVenuesTable $EventVenues
 * @property \App\Model\Table\VideosTable $Videos
 * @property \App\Model\Table\AudiosTable $Audios
 * @property \App\Model\Table\RolesTable $Roles
 * @property \App\Model\Table\PostsTable $Posts
 * @property \App\Model\Table\PostReactionsTable $PostReactions
 * @property \App\Model\Table\NotificationsTable $Notifications
 * @property \App\Model\Table\NewsfeedsTable $Newsfeeds
 * @property \App\Model\Table\PromotedContentsTable $PromotedContents
 * @property \App\Model\Table\GuestsTable $Visitors
 * @property \App\Model\Table\AwardsTable $Awards
 * @property \App\Model\Table\AchievementsTable $Achievements
 * @property \App\Model\Table\NominationsTable $Nominations
 * @property \App\Model\Table\CausesTable $Causes
 * @property \App\Model\Table\ConnectionsTable $Connections
 * @property \App\Model\Table\RequestsTable $Requests
 */
class AppController extends Controller
{
    private const USER_UPLOAD_DIR = WWW_ROOT . DS . 'public-files';
    protected $_theme = 'Modern';
    public $userPlatform = 'desktop';

    /**
     *
     * @var \App\Model\Entity\User
     */
    protected $_activeUser = null;
    protected $_visitor;
    protected $_pageWidgets;

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     * @throws \Exception
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('SiteCore');
        $this->loadComponent('GuestsManager');
        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);

        $this->loadComponent('Flash');
//        $this->loadComponent('CustomString');
        $this->loadComponent('EEventListener');
        EventManager::instance()->on($this->EEventListener);

        /*
         * Enable the following component for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
//        $this->loadComponent('Security');
        $this->loadComponent('FormProtection');

        $this->loadComponent('Auth', [
            'loginAction' => [
                'controller' => 'login',
                'action' => 'index'
            ],
            'loginRedirect' => [
                'controller' => 'feeds',
                'action' => 'index'
            ],
            'logoutRedirect' => [
                'controller' => 'login',
                'action' => 'index'
            ],
            'unauthorizedRedirect' => [
                'controller' => 'login',
                'action' => 'index'
            ]
//            'authError' => 'You must be logged in to access this page!'
        ]);

        $this->loadComponent('AuthServiceProvider', [
            'segmented' => ['signup'],
            'signup' => [
                //'requiredFields' => ['firstname','lastname','username','contact','password','confirm_password',
                //'accept_terms']
            ],
            'login' => [
                'requiredFields' => ['username','email','password']
            ],
            'passwordFormat' => null,
            'passwordFormatHint' => sprintf("Password must not be less than %s "
                . "characters, and must contain at least %s lowercase "
                . "letters, %s uppercase letters, %s numbers, %s "
                . "special characters and no white spaces", 8, 2, 2, 2, 2),
            'noValidate' => ['remember_me'], // List of fields that should pass without validation
            'ignore' => [], // List of fields that should not be included at all
            'supportedLoginMethods' => ['email','phone','username'],
            'definedDataTypes' => ['email','phone','username']
        ]);

        $this->loadComponent('Notifier');
//        $this->loadComponent('Cookie');
        $this->loadComponent('UserActivities');
        $this->loadComponent('Newsfeed');
        $this->loadComponent('User');
        $this->loadComponent('VerificationServiceProvider');

        /**
         * -------------------------------------
         * Loading Models Classes
         * -------------------------------------
         */

        $this->Users = $this->getTableLocator()->get('Users');
//        $this->Profiles = $this->getTableLocator()->get('Profiles');
//        $this->Connections = $this->getTableLocator()->get('Connections');
//        $this->Requests = $this->getTableLocator()->get('Requests');
//        $this->Posts = $this->getTableLocator()->get('Posts');
//        $this->ENews = $this->getTableLocator()->get('ENews');
//        $this->Notifications = $this->getTableLocator()->get('Notifications');
//        $this->Chats = $this->getTableLocator()->get('Chats');
//        $this->ChatParticipants = $this->getTableLocator()->get('ChatParticipants');
//        $this->Messages = $this->getTableLocator()->get('Messages');
//        $this->Conversations = $this->getTableLocator()->get('Conversations');
//        $this->Events = $this->getTableLocator()->get('Events');
//        $this->EventVenues = $this->getTableLocator()->get('EventVenues');
//        $this->EventGuests = $this->getTableLocator()->get('EventGuests');
//        $this->PostReactions = $this->getTableLocator()->get('PostReactions');
//        $this->Photos = $this->getTableLocator()->get('Photos');

    }


    /**
     * @return User|null
     */
    public function getActiveUser(array $additionalAssoc = []): ?User
    {
        $activeUser = null;
        if (null !== $this->Auth->user()) {
            $user = $this->Auth->user();
            $contains = [
                'Profiles' => [
                    'Languages',
                    'Educations',
                    'Industries',
                    'Roles',
                    'Genres'
                ],
                'UsersRatings',
                'SentRequests',
                'ReceivedRequests',
                'Connections' => [
                    'Correspondents' => ['Profiles']
                ],
            ];
            if (!empty($additionalAssoc)) {
                $contains = array_merge_recursive($contains, $additionalAssoc);
            }

            $activeUser = $this->Users->getUser($user['refid'], $contains);
        }

        return $activeUser;
    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $request = $this->getRequest();
        if ($request->hasHeader('X-Crowdwow-Asynchronous-Request')) {
//            $request = $request->with
        }

        // Track Site Guests (Including registered users)
        $this->GuestsManager->trackGuests();
        $userTimezone = $this->GuestsManager->getGuest()->get('timezone');
        $timezoneSplit = explode('/', $userTimezone);
        if (count($timezoneSplit) < 2) {
            $userTimezone = date_default_timezone_get();
        }
        Configure::write('App.defaultTimezone', $userTimezone);
//        $this->takeActivityLog();


        // Define the display based on user device
//        $platform = $this->viewBuilder()->getVar('platform') ?? 'desktop';
//        $this->viewBuilder()
//                ->setTemplatePath($platform . DS . $this->getName())
//                ->setLayoutPath($platform);
//        $this->viewBuilder()->setVar('title', $this->getName());
//        $this->__manageUserSession();


        // Detect the users' device
        $this->__enableUserDeviceDetector();

//        $this->getEventManager()->on('Model.Requests.afterConfirmation', function ($event) {
//            return $this->Requests->afterConfirmation($event);
//        });

        if ($this->getActiveUser()) {
            $user = $this->getActiveUser();
            $this->set('appUser', $user);
        }


//        $sidebarWidgetAccessKey = RandomString::generateString(16, 'mixed');
//        $this->getRequest()->getSession()->write('cw_sidebar_widget_accesskey', $sidebarWidgetAccessKey);

    }


    public function beforeRender(EventInterface $event)
    {
        parent::beforeRender($event);

        $this->set('platform', $this->userPlatform);
        if ($this->_theme !== null) {
            $this->viewBuilder()->setTheme($this->_theme);
//            $this->viewBuilder()
//                ->setLayoutPath($this->_theme);
//                ->setTemplatePath($this->_theme . '.templates');
        }

//        if ($this->userPlatform !== 'mobile') {
//            $this->viewBuilder()->setTheme('Mobile');
//        }

        // Setting the layout for timeline

//        $cookies = $this->getRequest()->getCookieCollection();
//        $cookieKey = $user . ".preferences.timeline_mode";
//        $feedLayout = 'stack';
//        if ($cookies->has($cookieKey)) {
//            $feedLayout = $cookies->get($cookieKey)->getScalarValue();
//        }
//
//        $this->set('feedLayout', $feedLayout);
//        if ($this->getActiveUser()) {
//            $this->set(['activeUser' => $this->getActiveUser()]);
//        }
//
//        $this->set('user_timezone', $this->GuestsManager->getGuest()->get('timezone'));
    }

    /**
     * User Profiler method
     *
     * @param array|object App\Model\Entity\User $account
     * @return \stdClass object $account
     */
    public function buildUserProfile($account)
    {
//        $fullname = $account->firstname . ' ' . $account->othernames;
//        $fullname = rtrim($fullname, ' ');
//        $fullname .= ' ' . $account->lastname;

//        $account->fullname = $fullname; // $account->firstname . ' ' . $account->othernames . ' ' . $account->lastname;
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
            $account->personality = (string)ucwords($this->getPersonality($account->personality_id));
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
        $account->set('time_zone', $this->getVisitor()->get('timezone'));
        return $account;
    }

    public function unknownUser(string $username)
    {
        $message = sprintf("Sorry, but we looked everywhere but couldn\'t find any user bearing `%s`.", $username);
        throw new NotFoundException($message);
    }

    public function __enableUserDeviceDetector()
    {
        $detector = new \Detection\MobileDetect();
        if ($detector->isMobile()) {
            $this->userPlatform = 'mobile';
        } elseif ($detector->isTablet()) {
            $this->userPlatform = 'tablet';
        }

        return $this;
    }

    public function buildUsersProfiles(array $users)
    {
        array_walk($users, function (&$user, $index) {
            $user = $this->buildUserProfile($user);
        });

        return $users;
    }

    /**
     * Checks if a class has a given method
     *
     * @param string $action Name of the method to check
     * @return boolean true if the method exists in the called class,
     * and false otherwise
     */
    public function hasAction($action)
    {
        if (method_exists(get_called_class(), $action)) {
            return true;
        }

        return false;
    }

    public function applySorting(\Cake\ORM\Table $table)
    {
        return $this->paginate()->sortBy($callback, $dir);
    }

    public function detectRequestOrigin()
    {
        $request = $this->getRequest();
        $requestOrigin = $request->getQuery('request_origin');
        $xForceFullRendering = (int)$request->getQuery('xffr');
        $xRequestedWith = $request->getQuery('xrw');

        if ($requestOrigin === 'iframe' && $xForceFullRendering === 0) {
            $this->viewBuilder()->setLayout('blank');
        } elseif ($request->is('ajax')) {
            $this->viewBuilder()->setLayout('ajax');
        }
    }

    public function getUserLocationInfo(array $info)
    {


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
        } else if ($page <= 1) {
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

    public function getUserMedias($actor, $filter = 'all')
    {
        $medias = $this->_tableLocator->get('Medias');
        $medias = $medias->find($filter)
            ->where(['user_refid' => $actor]);
        if ($filter === 'all') {
            $medias = $medias->contain(['Users', 'Videos', 'Audios']);
        }

        return $medias;
    }

    public function activities($actor = null)
    {

    }

    public function engagements($actor = null)
    {
        $engagements = $this->UserActivities->getUserEngagements($actor->refid);

        $this->set(compact('engagements'));
    }

    public function interactions($actor = null)
    {
        $interactions = $this->UserActivities->getUserInteractions($actor->refid);

        $this->set(compact('interactions'));
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
        $visitor = $this->GuestsManager->getGuest();

        $adsTbl = $this->getTableLocator()->get('PromotedContents');
        $ads = $adsTbl->find()->where([
            'status' => $status
        ]);
        if ($actor) {
            $ads = $ads->where([
                'audience_min_age <=' => $actor->getAge('y'),
                'audience_max_age >=' => $actor->getAge('y'),
                'audience_location LIKE' => '%'
                    . $actor->profile->getCountryOfResidence() . '%'
            ]);
        } else {
            $ads = $ads->where([
                'audience_min_age <=' => 18,
                'audience_max_age >=' => 65,
                'audience_location LIKE' => '%' . $visitor->getLocation() . '%'
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

    public function trends()
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

    /**
     * @return \Cake\Http\Response|void
     * @throws \Exception
     */
    public function aKJm()
    {
        $this->disableAutoRender();
//        $request->allowMethod(['post','put','patch','delete']);
        // Handle Timeline layout change request
        $this->handleTimelineLayoutToggle();
    }

    /**
     * @return \Cake\Http\Response
     * @throws \Exception
     */
    protected function handleTimelineLayoutToggle()
    {
        $request = $this->getRequest();
        $response = $this->getResponse();

        if ($request->getData('option') === 'timeline_layout_preference') {
            $mode = $request->getData('mode');
            $user = 'guest';
            if ($this->getActiveUser()) {
                $user = $this->getActiveUser()->get('refid');
            }
            $cookieKey = $user . "_preferences_timeline_mode";
            $cookiesCollection = $this->getRequest()->getCookieCollection();
            if ($cookiesCollection->has($cookieKey)) {
                $cookie = $cookiesCollection->get($cookieKey);
                $cookie = $cookie->withValue($mode);
            } else {
                $cookie = new Cookie($cookieKey, $mode);
            }
            if ($user === 'guest') {
                $cookie = $cookie->withExpiry(new \DateTime('+24 Hours'));
            } else {
                $cookie = $cookie->withNeverExpire();
            }
            $cookie = $cookie->withHttpOnly(false);
            $response = $response->withCookie($cookie);
//            $cookiesCollection = $cookiesCollection->add($cookie);
//            $cookiesCollection->addToRequest($request);
//            $request = $response->getCookieCollection()->addToRequest($request);
//            $this->setResponse($response);

//            if ($request->getQuery('referer')) {
//                $redirectUrl = urldecode($request->getQuery('referer'));
//                return $this->redirect(Router::normalize($redirectUrl));
////                $response = $response->withLocation($redirectUrl);
//            } else {
//                return $this->redirect($request->referer(true));
////                $response = $response->withLocation($request->referer());
//            }
            return $response;
        }
    }
    protected function _applyFiltering(\Cake\ORM\Table $table)
    {
        $request = $this->getRequest();
        $filterParams = $request->getQueryParams();
        $query = $table->find('all');
        if (isset($filterParams['cat']) && $table->hasField('category_refid')) {
            $query = $query->where(['category_refid' => $this->CustomString->sanitize($filterParams['cat'])]);
        }
        if (isset($filterParams['genre']) && $table->hasField('genre_refid')) {
            $query = $query->where(['genre_refid' => $this->CustomString->sanitize($filterParams['genre'])]);
        }
        if (isset($filterParams['album']) && $table->hasField('album_refid')) {
            $query = $query->where(['album_refid' => $this->CustomString->sanitize($filterParams['album'])]);
        }
        if (isset($filterParams['privacy']) && $table->hasField('privacy')) {
            $query = $query->where(['privacy' => $this->CustomString->sanitize($filterParams['privacy'])]);
        }
        if (isset($filterParams['keyword']) && ($table->hasField('title') || $table->hasField('description'))) {
            $query = $query->where(['OR' => [
                'title LIKE' => '%' . $this->CustomString->sanitize($filterParams['keyword']) . '%',
                'description LIKE' => '%' . $this->CustomString->sanitize($filterParams['keyword']) . '%'
            ]
            ]);
        }

        return $query; // Return the query object instead of result set, makes it possible to be manipulated further
    }

    protected function _callLocationServiceProvider()
    {

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
                if (!method_exists($this->UserActivities, $fetcher)){
                    continue;
                }
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

//    public function suggestedConnections($actor = null)
//    {
//        $peopleToMeet = (array)$this->UserActivities->peopleToMeet($actor, 'all');
//
//        $this->set('peopleToMeet', $peopleToMeet);
//    }

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
            if ($this->user) {
                $actor = $this->user;
            }
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

    protected function _getSources($refid = null, $include_followed_feeds = false)
    {
        if (is_null($refid)) {
            if ($this->user)
                $refid = $this->user->refid;
        }

        $sources = [];
        $UsersTbl = $this->_tableLocator->get('Users');

        // Get user connections
        $cQuery = $this->Profile->getConnections($refid);
        $connections = $cQuery->toArray();
        if (count($connections)) {
            foreach ($connections as $connection) {
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
            $post->commentsCount = count($post->comments);
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

    protected function _getFeedSources($refid = null, $include_followed_feeds = false)
    {
        if (is_null($refid)) {
            if ($this->user)
                $refid = $this->user->refid;
        }
        // The primary source is the user
        $sources = [$refid];

        // Get IDs of user's connections
        $sources += (array)$this->getConnectionsIds($refid);

        if ($include_followed_feeds) {
            // IDs of users to which timeline the use is subscribed
            $sources += (array)$this->getFollowedFeeds($refid);
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


        $users = $UsersTbl->getUnconnectedTo($user->refid);
        $peopleToMeet = [];

        if ($activeUser) {
            $users = $users->where(['refid !=' => $activeUser->refid]);
        }
        $result = null;
        switch ($filter) {
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

        if (count($connections)) {
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
//        $GuestsManager = $this->_tableLocator->get('EventInvitees');
//        $query = $GuestsManager->find('all');
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

        if (!$object) {
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

        if (!is_array($items)) {
            $items = $items->toArray();
        }

        return $items;
    }

    protected function _fetchInterests($actor = null)
    {
        return false;
        $likes = $this->UserActivities->getUserLikes($actor->refid);
        $this->set('likes', $likes);
    }

    /**
     *
     * @return \Cake\ORM\Query
     */
    protected function _getCategories()
    {
        $categories = $this->Categories->find();

        return $categories;
    }

    /**
     *
     * @return \Cake\ORM\Query
     */
    protected function _getGenres()
    {
        $genres = $this->Genres->find();

        return $genres;
    }

    /**
     *
     * @return \Cake\ORM\Query
     */
    protected function _getRoles()
    {
        $roles = $this->Roles->find();

        return $roles;
    }

    /**
     *
     * @return array List of available languages
     */
    protected function _getLanguages()
    {
        return [
            'eng-GB' => 'English',
            'eng-US' => 'English (US)',
            'igbo' => 'Igbo',
        ];
    }

    /**
     * This method uses the viewBuilder to check that a given template exists,
     * and then sets it as the template for the current action. If the template
     * was not found, an exception will be thrown
     *
     * @param string|array $path
     * @return void
     * @throws \App\Controller\MissingTemplateException
     * @throws NotFoundException
     */
    protected function setTemplate($path, $dir = null): void
    {
        if ($dir !== null) {
            $this->viewBuilder()->setTemplatePath($dir);
        }
        if (is_array($path)) {
            $path = implode(DS, $path);
        }

        try {
            $this->enableAutoRender();
            $this->viewBuilder()->setTemplate($path);
        } catch (MissingTemplateException $exc) {
            if (Configure::read('debug')) {
                echo $exc->traceAsString();
            }
            throw new NotFoundException();
        }
    }

    public function display(... $path)
    {
        // Prevent illegal dots in the path
        if (in_array('..', $path, true) || in_array('.', $path, true)) {
            throw new ForbiddenException();
        }

        $page = $path[0];
        $subpage = null;
        if (!empty($path[1])) {
            $subpage = $path[1];
        }

//        $request = $this->getRequest();
        $user = $this->getActiveUser();

        // Define the request handler based on the last path in the url
//        $lastOfPath = Inflector::underscore(end($path));

        if (Validation::numeric($page) && $this->hasAction('view')) {
            $this->viewBuilder()->setTemplate('view');
            $this->view($page, $subpage);
        } else {
            $requestHandler = lcfirst(
                Inflector::camelize((string)$page, '-')
            );

            if ($this->hasAction($requestHandler)) {
                $this->{$requestHandler}($path);
            }
        }

        $tpl = $this->viewBuilder()->getTemplate();

        if ($tpl === null || str_contains($tpl, 'display')) {
            $path = implode(DS, $path);
            $tpl = Inflector::underscore($path);
        }

        try {
            $this->viewBuilder()->setTemplate($tpl);
        } catch (MissingTemplateException $ex) {
            if (Configure::read('debug')) {
                throw $ex;
            } else {
                throw new NotFoundException();
            }
        }

        $this->set(compact('user','page','subpage','path'));
    }

    public function getCurrentDateTime(string $timezone = null)
    {
        if (is_null($timezone)) {
            $timezone = Configure::read('App.defaultTimezone');
        }
        $timezone = new \DateTimeZone($timezone);
        try {
            $datetime = new \DateTime('now', $timezone);
        } catch (\Exception $e) {
        }

        return $datetime;
    }

    public function enableSidebar(bool $option = true)
    {
        $this->set('sidebar', $option);
    }

    public function collapseOffCanvas(bool $option = false)
    {
        $offcanvasState = 'off-canvas-expanded';
        if ($option) {
            $offcanvasState = 'off-canvas-collapsed';
        }
        $this->set('offcanvas_state', $offcanvasState);
    }
}
