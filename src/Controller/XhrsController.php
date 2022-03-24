<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\Post;
use App\Model\Entity\User;
use App\Utility\AjaxMaskedRoutes;
use App\Utility\CustomString;
use App\Utility\RandomString;
use App\Utility\ServiceMessages;
use Cake\Collection\Collection;
use Cake\Controller\Component;
use Cake\Controller\Exception\MissingActionException;
use Cake\Core\Configure;
use Cake\Event\EventInterface;
use Cake\Http\Client\Response;
use Cake\Http\Exception\BadRequestException;
use Cake\Http\Exception\NotFoundException;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Http\Exception\ForbiddenException;
use Cake\Controller\Exception\MissingComponentException;
use Cake\Http\Exception\InternalErrorException;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Event\Event;
use Cake\Event\EventManager;
use Cake\Utility\Inflector;
use Cake\Utility\Security;
use Cake\Validation\Validation;
use Cake\View\Exception\MissingTemplateException;
use Cake\Routing\Router;
use Cake\View\CellTrait;

/**
 * XMLHttpRequests Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @property \App\Model\Table\BkpEventsTable $Events
 * @property \App\Controller\Component\UserActivitiesComponent $UserActivities
 *
 * @method \App\Model\Entity\Post[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class XhrsController extends AppController
{
    use CellTrait;
    const UPLOAD_DIR = WWW_ROOT . 'public-files/';

    public function initialize(): void
    {
        parent::initialize();
        $this->Auth->allow();

        $this->viewBuilder()->setLayout('ajax');
        $this->disableAutoRender();
    }

    public function beforeRender(EventInterface $event)
    {
        parent::beforeRender($event);

    }

    private function __getRoute(string $route)
    {
        return self::MASKED_ROUTES[$route] ?? $route;
    }

    /**
     * Handles asynchronous page load requests by matching each request to a
     * corresponding controller component. If a matching component was not
     * found, this method will search within the controller for a matching
     * method and execute it. Otherwise, an error will be raised depending
     * on different reasons.
     *
     * <b>Please Note:</b> the target component must implement a request
     * parameter hook method, which will be used internally to read and
     * validate requests according to its need and purpose. And must be
     * called on initiallisation.
     * For example: the ProfileComponent implements a hook method called
     * <b>_queryParamsHook()</b>.
     * The target action/method must also return the result back to this
     * method. But where necessary, template can be defined from the
     * component action, which will override anyone defined in this
     * method.
     *
     * @param array $path
     * @throws MissingComponentException
     * @throws NotFoundException
     * @throws \Exception
     */
    public function ajaxify(...$path): void
    {
        $request = $this->getRequest();
        $response = $this->getResponse();
        if (!$request->is('ajax')) {
            throw new ForbiddenException('');
        }
        if (!count($path)) {
            throw new BadRequestException();
        }

        // Prevent illegal dots in the path
        if (
            in_array('..', $path, true) ||
            in_array('.', $path, true)) {
            throw new ForbiddenException();
        }
        if ($this->isAutoRenderEnabled()) {
            $this->disableAutoRender();
        }
        $queryParams = $request->getQueryParams();
        $token = [
            'resource_handle' => 'result',
            'resource_path' => 'ajaxify',
        ];
        if (isset($queryParams['token'])) {
            $requestToken = base64_decode($queryParams['token']);
            $token = array_merge($token, json_decode(
                unserialize($requestToken),
                true
                )
            );
            unset($queryParams['token']);
        }

        $route = AjaxMaskedRoutes::getRoute($path[0]);

        array_shift($path);
        $queryParams = array_filter($queryParams);

        try {
            $componentName = ucfirst($route);
            if (!property_exists($this, $componentName)) {
                $this->loadComponent($componentName, [
                    'user' => $this->getActiveUser(),
                ]);
            }
            if (!$this->{$componentName}->getConfig('user')) {
                $this->{$componentName}->setConfig('user', $this->getActiveUser());
            }
        } catch (\Throwable $componentException) {
            // If no matching component was found, we check whether this controller
            // has any method by that name and execute it.
            $action = Inflector::camelize($route,'_');
            $action = Inflector::camelize($action,'-');
            $action = lcfirst($action);
            try {
                $result = $this->{$action}($queryParams, $path);
            } catch (\Throwable $exception) {
                if (Configure::read('debug')) {
                    throw $exception;
                }
                throw new NotFoundException(
                    ServiceMessages::getMissingPageMessage()
                );
            }
        }

        // This block should only be executed if the component is loaded
        if (!isset($result)) {
            try {
                $endpoint = 'handle';
                if (count($path)) {
                    $endpoint = lcfirst(Inflector::camelize($path[0]));
                    array_shift($path);
                }
                $result = $this->{$componentName}->{$endpoint}($queryParams, $path);
            } catch (\Throwable $componentActionError) {
                if (Configure::read('debug')) {
                    throw $componentActionError;
                }
                throw new NotFoundException(
                    ServiceMessages::getMissingPageMessage()
                );
            }
        }

        // Templates are expected to be defined in the action that is being
        // executed. But where there is none defined, we define one at this level
        if (null === $this->viewBuilder()->getTemplate()) {
            $resourcePath = explode('/',  $token['resource_path']);
            $resourcePath[0] = Inflector::camelize($resourcePath[0], '-');
            $template = implode('/', $resourcePath);
            if (strlen($template) < 1) {
                $template = 'ajaxify';
            }
            if (substr($template, 0, 1) !== '/') {
                $template = '/' . $template;
            }
            $this->viewBuilder()->setTemplate($template);
        }

        $resourceHandle = $token['resource_handle'];
        $content = $token['content'] ?? 'content';

        $$resourceHandle = $result;

        $this->set(compact("$resourceHandle", 'content'));
        $this->render();
    }


//    public function ajaxify(...$path)
//    {
//        if (!count($path)) {
//            throw new BadRequestException();
//        }
//        // Prevent illegal dots in the path
//        if (in_array('..', $path, true) || in_array('.', $path, true)) {
//            throw new ForbiddenException();
//        }
//        if ($this->isAutoRenderEnabled()) {
//            $this->disableAutoRender();
//        }
//
//        // Pass the request to an appropriate component to handle it
//        $component = Inflector::camelize($path[0]);
//
//        try {
//            $this->loadComponent($component);
//        } catch (MissingComponentException $componentExc) {
//            if (Configure::read('debug')) {
//                throw $componentExc;
//            }
//            throw new NotFoundException('Oops! Looks like the link was broken or the page does not exist.');
//        } catch (\Exception $componentExc2) {
//            if (Configure::read('debug')) {
//                throw $componentExc2;
//            }
//            throw new InternalErrorException('We\'re sorry, but we\'re having problem loading that page. Please try refreshing the web page and then try again.');
//        }
//
//        if (isset($path[1])) {
//            $action = Inflector::camelize($path[1],'_');
//            $action = lcfirst(Inflector::camelize($action,'-'));
//        }
//        if (!isset($action)) {
//            throw new BadRequestException();
//        }
//        if (!method_exists($this->$component, $action)) {
//            throw new NotFoundException('Oops! Looks like the link was broken or the page does not exist.');
//        }
//        // Please Note: Defining the template here makes it possible for the
//        // component to define an overriding template in the called action
//        $template = implode(DS, $path);
//        $this->viewBuilder()->setTemplate($template);
//
//        $$action = $this->{$component}->{$action}($path);
//
//        $this->set(compact("$action"));
//        $this->render();
//    }


    public function requestConfirmation()
    {
        $httpR = $this->getRequest();
        $httpR->allowMethod(['ajax', 'post']);
        if (! $httpR->is(['ajax', 'post'])) {
            return 'error';
        }
        $this->viewBuilder()->setLayout('ajax');
        $this->autoRender = false;
        $responses = [
            'accept' => 'accepted',
            'decline' => 'declined'
        ];
        $requestId = $httpR->getData('request_id');
        $requestType = $httpR->getData('request_type');
        $response = $httpR->getData('response_action');
        $afterConfirmMsg = $httpR->getData('action_feedback_msg');
        $RequestTable = $this->getTableLocator()->get('Requests');
        $request = $RequestTable->find('byRefid', ['refid' => $requestId])->first();

        if (!$request) {
            $msg = ['status' => 'error', 'message' => 'Record Not Found'];
        } else {
            $ConnectionsTbl = $this->getTableLocator()->get('Connections');
            $connection = $ConnectionsTbl->newEntity($data);

            if ($RequestTable->delete($request)) {
                $msg = ['status' => 'success', 'message' => $afterConfirmMsg];
                $event = new Event('Model.Request.afterConfirmation', $RequestTable, [
                    'request' => $request
                ]);

                $this->getEventManager()->dispatch($event);
            } else {
                $msg = ['status' => 'error', 'message' => 'Unable to complete your request at the moment...'];
            }
        }

        $msg['ua'] = $response;
        $msg['requestType'] = $requestType;
        $msg['sender'] = $this->getUserArray($request->sender_refid);
        $msg['user'] = $this->getUserArray($request->target_refid);

        return $this->getResponse()->withType('json')->withStringBody(json_encode($msg));
    }
//
//
//    public function post(array $path)
//    {
//        $this->enableAutoRender();
//
//        if (!count($path)) {
//            throw new BadRequestException();
//        }
//        // Prevent illegal dots in the path
//        if (in_array('..', $path, true) || in_array('.', $path, true)) {
//            throw new ForbiddenException();
//        }
//        $postID = $path[0];
//        try {
//            $post = $this->Posts->getByRefid($postID);
//        } catch (RecordNotFoundException $exc) {
//            if (Configure::read('debug')) {
//                throw $exc;
//            }
//            throw new NotFoundException();
//        }
//
//        $this->set(compact('post'));
//    }
//
//    private function postsByUser(array $params, array $path)
//    {
//        $response = $this->getResponse();
//        $account = $this->getActiveUser();
//        if (array_key_exists('tbuid', $params)) {
//            $account = $this->Users->get($params['tbuid']);
//        }
//        $postsLayout = isset($params['layout']) ? $params['layout'] : null;
//        if (is_null($postsLayout)) {
//            $postsLayout = 'stack';
//        }
//
//        if (!$account instanceof User) {
//            throw new BadRequestException();
//        }
//        $posts = $this->Newsfeed->fetchAllFor($account, 'byAuthor', $account->refid);
//
//        $posts = $posts->orderAsc('Posts.id');
//        $posts = $this->paginate($posts);
//        $arrayPosts = $posts->toArray();
//        $collection = collection($arrayPosts);
//
//        $groupedPosts = $collection->groupBy(function ($post) {
//            return $post->year;
//        })->toArray();
//
//        $this->set(compact('account', 'postsLayout'));
//
//        return $groupedPosts;
//    }

    public function connections(array $params, array $path)
    {
        $this->enableAutoRender();
        if (!count($path)) {
            throw new NotFoundException();
        }
        $username = CustomString::sanitize($path[0]);
        $account = $this->Users->getUser($username);

        $this->loadModel('Connections');
        $connections = $this->Connections->find('forUser', ['user' => $account->refid])
            ->extract('correspondent')
            ->toArray();

        return $connections;
    }
    public function connection($userID)
    {
        $this->enableAutoRender();
        try {
            $connection = $this->Users->get($userID, ['contain' => ['Profiles', 'Followers','Followings']]);
        } catch (RecordNotFoundException $exc) {
            if (Configure::read('debug')) {
                throw $exc;
            }
            return $this->unknownUser($userID);
        }

        $this->set(compact('connection'));
    }

    public function event($eventID)
    {
        $this->enableAutoRender();
        try {
            $event = $this->Events->get($eventID);
        } catch (RecordNotFoundException $exc) {
            echo $exc->getTraceAsString();
        }
        $eventVenues = $this->EventVenues->find()->where([
            'event_refid' => $event->get('refid')
        ])->all()->toArray();
        $eventGeuests = $this->EventGuests->find()->where([
            'event_refid' => $event->get('refid')
        ])->all()->toArray();

        $event->set([
            'guests' => $eventGeuests,
            'venues' => $eventVenues
        ]);

        $this->set(compact('event'));
    }

//    /**
//     * @param array $path
//     * @param array $queryParams
//     * @return array|\Cake\Http\Response
//     */
//    private function timeline(array $queryParams = [])
//    {
//        $response = $this->getResponse();
//        $actor = $this->getActiveUser();
//        if (array_key_exists('tbuid', $queryParams)) {
//            $actor = $this->Users->get($queryParams['tbuid']);
//        }
//
//        if (!$actor instanceof User) {
//            return $response->withStatus(500)->withStringBody('Sorry, unkown user');
//        }
//        $timeline = $this->Newsfeed->fetchAllFor($actor);
//        $timeline = $timeline->orderDesc('Posts.id');
//        $timeline = $this->paginate($timeline);
//        $arrayTimeline = $timeline->toArray();
//        $collection = new Collection($arrayTimeline);
//        $threadedPosts = $collection->each(
//            function (Post $post) {
//                $post->set(
//                    'comments',
//                    $this->Posts->getDescendants($post->refid)
//                );
//                return $post;
//            }
//        );
//
//        $groupedTimeline = $threadedPosts->groupBy(function ($post) {
//            return $post->year;
//        })->toArray();
//
//        $this->set('account', $actor);
//        $this->viewBuilder()->setTemplatePath('Posts');
//        return $groupedTimeline;
//    }

    public function interests($actor = null)
    {
        $likes = $this->UserActivities->getUserInterests($actor);
        $this->set('likes', $likes);
    }

    public function activities($actor = null)
    {
        $query = $this->UserActivities->getActivities($this->getActiveUser()->get('refid'))
                ->contain(['Actors' => ['Profiles']])
                ->orderDesc('Activities.created');
        $activities = $this->paginate($query);

        $this->set(compact('activities'));
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

    public function suggestedConnections() {
        $request = $this->getRequest();
        $placement = $request->getQuery('placement');
        $profile = ($request->getQuery('account') ?
                $this->Users->get(
                        $this->CustomString->sanitize($request->getQuery('account')
                    )
                ) : null);
        if ($placement === 'db') {
            $bases = ['recent_connections','personality'];
        } else {
            $bases = ['similar_users','profile_connections'];
        }

        $suggestions = $this->Users->suggestPossibleConnections($bases, $this->getActiveUser() ?? null, $profile);

        $this->set(compact('suggestions'));
        $this->render();
    }

    public function videos($type = null)
    {
        $token = $this->getRequest()->getQuery('token');
        $actor = base64_decode($token);

        if (!$type) {
            $type = 'all';
        }
        $this->loadModel('Videos');
        $query = $this->Videos->find($type);
        $query = $query->find('byAuthor', ['author' => $actor]);

        // Top 24 newly released videos
        $newlyReleasedVideos = $query->find('newReleases')->take(24);

        // Top 5 trending videos
        $trendingVideos = $query->find('trending', ['period' => '-7 days'])->take(5);

        // Top 10 best selling videos
        $bestSellingVideos = $query->find('bestSellers')->take(10);

        $this->viewBuilder()->setTemplate('/Cell/media/videos');
        $this->set(compact('newlyReleasedVideos','trendingVideos','bestSellingVideos'));
        $this->render();
    }


    public function generalSuggestions()
    {
        $request = $this->getRequest();
        $what = $request->getQuery('what') ?? 'people';
        $type = $request->getQuery('type') ?? 'any';

        $actor = $this->getActiveUser();
        $suggestions = [];
        $this->loadComponent('Suggestion');

        switch ($what)
        {
            case 'connections':
                $suggestions = $this->Suggestion->suggestPossibleConnections();
                break;
            case 'familiar_users':
                $suggestions = $this->Suggestion->suggestPossibleAcquaintances($actor);
                break;
            case 'post_starting_phrases':
                $postType = $request->getQuery('post_type');
                $suggestions = $this->Suggestion->getPostStartingPhrase($postType);
                break;
            default:

        }

        return $suggestions;

//        $this->set(['suggestions' => , '_serialize' => 'suggestions']);
//        $this->render();
    }

    public function requests()
    {
        if (!$this->getActiveUser()) {
            return null;
        }
        $httpR = $this->getRequest();
        $response = $this->getResponse();
//        if (count($path)) {
//            throw new NotFoundException();
//        }
        $type = $httpR->getQuery('type') ?? 'connection';
        $box = $httpR->getQuery('box') ?? 'received';
        $status = $httpR->getQuery('status') ?? null;
        if (
            !in_array($type, ['connection','meeting','introduction']) ||
            !in_array($box, ['received','sent'])
        ) {
            throw new BadRequestException('Oops! It seems you\'ve ' .
                'missed your way, or this request contains invalid parameters.');
        }

        $options = [
            'user' => $this->getActiveUser()->refid,
            'type' => $type
        ];
        if (!is_null($status)) {
            $options['status'] = $status;
        }
        $requests = $this->Requests->find($box, $options)
            ->contain([
                'Senders' => [
                    'Profiles' => ['Roles']
                ],
                'Recipients' => [
                    'Profiles' => ['Roles']
                ],
                'SuggestedUsers' => [
                    'Profiles' => ['Roles'],
                ]
            ])->toArray();

        return $requests;
    }

//    public function familierUsers($actor = null)
//    {
//        $peopleYouMayKnow = (array)$this->UserActivities->getPeopleYouMayKnow($actor, 'all');
//
//        $this->set(compact('peopleYouMayKnow'));
//    }
//
    public function ads($actor = null)
    {
        $settings = [];
        $settings['location'] = '';
        if ($this->getActiveUser()) {
            $settings['target_gender'] = $this->getActiveUser()->get('gender');
        }

        $req = $this->getRequest();
        $query = $this->SponsoredContents->find('latest');

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
        $req = $this->getRequest();
        $query = $this->Users->find('all')
                ->where(['Profiles.role' => 'producer'])
                ->contain(['Profiles' => ['Roles'], 'Ratings']);
        if ($query->isEmpty()) {
            return null;
        }
        $ratedProducers = [];
        $result = $query->whereInList('refid', $ratedProducers);

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

    public function media()
    {
        $queryParams = $this->getRequest()->getQueryParams();
        $filter = 'all';
        $uid = '';
        if (array_key_exists('type', $queryParams) && array_key_exists('uid', $queryParams)) {
            $filter = $queryParams['type'];
            $uid = $queryParams['uid'];
        }
        if (empty($uid)) {
            return null;
        }

        $medias = $this->UserActivities->getUserMedias($uid, $filter);
        $this->set(compact('medias'));
    }

    public function fetchPost($postID)
    {
        echo 'New Post created with ID: ' . $postID;
    }

    public function profile(array $queryParams, array $path = null)
    {
        if (!count($path)) {
            throw new BadRequestException();
        }

        $request = $this->getRequest();
        if (!$request->getQuery('token')) {
            throw new BadRequestException();
        }
        $token = $request->getQuery('token');
        $base64Decode = base64_decode($token);
        $strToArr = explode('_', $base64Decode);
        $usable = array_pop($strToArr);
        $userid = substr($usable, 0, 20);

        try {
            $account = $this->Users->get($userid);
        } catch (RecordNotFoundException $exc) {
            if (Configure::read('debug')) {
                throw $exc;
            }
            return $this->unknownUser($username);
        }

        $page = $path[0];
        $subpage = null;
        if (isset($path[1])) {
            $subpage = $path[1];
        }

        $camelCasedPage = Inflector::camelize($page);
//        $defaultContainments = [
//            'Profiles',
//            'Connections' => ['Correspondents' => ['Profiles'], 'Actors' => ['Profiles']],
//            'Followers', // => ['Correspondents'],
//            'Followings', // => ['Correspondents'],
//            'Posts' => ['Comments'],
//            'Albums' => ['Owners'],
//            'Videos' => ['Authors'],
//            'Songs' => ['Authors'],
//            'Audios' => ['Authors'],
//            'Movies' => ['Authors'],
//            'Awards' => ['Users'],
//            'Nominations' => ['Users'],
//            'Achievements' => ['Users'],
////                    'Inventories',
////                    'Collections'
//        ];
//        $account = $this->Users->getUser($username, $defaultContainments);

        // This section defines what happens when main content of a page is requested
        $requestedContent = null;
        $component = 'Profile';
        switch ($page) {
            case 'posts':
                /* @var $query Cake\ORM\ResultSet */

                break;

            default:
                $getter = 'get' . Inflector::camelize($camelCasedPage);

                if (method_exists($this->UserProfiler, $getter)) {
                    $requestedContent = $this->UserProfiler->{$getter}($account);
                }
                elseif (method_exists($this->Suggestion, $getter)) {
                    $requestedContent = $this->Suggestion->{$getter}($account);
                }
                break;
        }

//        $out = lcfirst($camelCasedPage);
        $data = $requestedContent;
        // Please note the left-hand assignment with double dollar sign above.
        // It parses the value contained in $requestedPage as the name of the
        // variable used in storing the content returned.

        // Also note that the same variable is used as string in double quotes,
        // to compact()
        $this->set(compact('account','data','path', 'page','subpage'));
        $cell = new XhrsDataCell('');
        $cell;
    }

    public function people()
    {
        $people = (object) null;
        $user = $this->getActiveUser();

        /**
         * @var \App\Model\Table\UsersTable $Users
         */
        $Users = $this->loadModel('Users');
        $users = $Users->find();
        $people->inSameRegion = $Users->findPeopleInSameCountryAs($users, ['user' => $user])
            ->contain(['Profiles'])
            ->toArray();
        $people->inSameState = $Users->findPeopleInSameProvinceAs($users, ['user' => $user])
            ->contain(['Profiles'])
            ->toArray();
        $people->inSameCity = $Users->findPeopleInSameCityAs($users, ['user' => $user])
            ->contain(['Profiles'])
            ->toArray();

        $this->set(compact('people'));
        $this->render('people');
    }

    public function users(array $queryParams, array $path = null)
    {
        $what = null;
        if (count($path)) {
//            $what = $path[0];
            throw new NotFoundException('The page does not exist.');
        }
        $users = $this->Users->fetch($queryParams);

        return $users;
    }
}
