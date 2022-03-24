<?php
declare(strict_types=1);

namespace App\Controller\Component;

use App\Model\Entity\User;
use Cake\Collection\Collection;
use Cake\Collection\CollectionInterface;
use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Datasource\ResultSetInterface;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;
use App\Controller\AppController;
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\Network\Exception\ForbiddenException;
use Cake\Utility\Inflector;
use Cake\Validation\Validation;
use Cake\ORM\Locator\TableLocator;
use mysql_xdevapi\RowResult;

/**
 * UserProfiler component
 *
 * @property \App\Model\Table\UsersTable $Users The UsersTable Object
 * @property \App\Model\Table\GroupsTable $Groups The GroupsTable Object
 * @property \App\Model\Table\GroupMembersTable $GroupMembers The GroupMembersTable Object
 * @property \App\Model\Table\GroupInvitesTable $GroupInvites The GroupInvitesTable Object
 */
class UserComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public $components = ['Paginator', 'Cookie', 'PostsManager'];

    /**
     *
     * @var object ORM TableLocator object
     */
    private $_tableLocator;

    public $user;


    public function initialize(array $config): void
    {
        parent::initialize($config);

        $tableLocator = new TableLocator();

        $this->Users = $tableLocator->get('Users');
        $this->Playlists = $tableLocator->get('Playlists');
        $this->PlaylistsItems = $tableLocator->get('PlaylistsItems');
        $this->Albums = $tableLocator->get('Albums');
        $this->Comments = $tableLocator->get('Comments');
        $this->Follows = $tableLocator->get('Follows');
        $this->Personalities = $tableLocator->get('Personalities');
        $this->UserPhotos = $tableLocator->get('UserPhotos');
        $this->Campaigns = $tableLocator->get('Campaigns');
        $this->Engagements = $tableLocator->get('Engagements');
        $this->Notifications = $tableLocator->get('Notifications');
        $this->Categories = $tableLocator->get('Categories');
        $this->Genres = $tableLocator->get('Genres');
    }

    /**
     * isAccountOwner function
     *
     * Compares two user objects (typically the active user and the account
     * being viewed by the user) to see if they are the same
     *
     * @param User $account
     * @return boolean
     */
    public function isAccountOwner(User $account ) {
        $controller = $this->getController();
        $activeUser = $controller->getActiveUser();

        if ( !$activeUser )
            return false;

        if ( $activeUser->get('refid') === $account->get('refid') )
            return true;

        return false;
    }

    /**
     * isActivated
     *
     * Check if a given account is activated or not
     *
     * @param User $account
     * @return boolean
     */
    public function isActivated(User $account ) {
        $activated = (int) $account->activated;
        if ($activated === 1)
            return true;
        return false;
    }

    /**
     * Account Activation Requirer method
     *
     * - Checks whether a given account is activated or not.
     * - If not, redirects the user (if logged in) to account activation page
     *
     * @param $user User object | array
     * @param $resource Controller object (null);
     * @return void
     */
    public function requireAccountActivation($user, $resource = null) {
        if (null !== $user) {
            $active = 0;

            if (is_array($user))
                $active = (int) $user['active'];
            elseif (is_object($user))
                $active = (int) $user->active;

            if ($active === 0) {
                $this->Flash->warning(__('Your account is not yet activated. Please activate your account'));
                if (!$resource)
                    $resource = $this;
                return $this->redirect('/accountService/account-activation');
            }
        }
    }

    public function authenticate() {
        $controller = $this->getController();
        if ($controller->getActiveUser()) {
            return;
        }
        $cookie = $controller->getRequest()->getCookie('User');
        if ($cookie) {
            $username = $cookie->username;
            $password = $cookie->password;
            $controller->getRequest()->withData('password',$password);

            if (Validation::email($username)) {
                $controller->Auth->config('authenticate', [
                    'Form' => [
                        'fields' => ['username' => 'email']
                    ]
                ]);

                $controller->Auth->constructAuthenticate();
                $controller->request->withData('email', $username);
            } else {
                $controller->Auth->config('authenticate', [
                    'Form' => [
                        'fields' => ['username' => 'username']
                    ]
                ]);

                $controller->Auth->constructAuthenticate();
                // Re-assign the request data username to the validated and
                // sanitized username

                $controller->getRequest()->withData('username', $username);
            }

            $user = $controller->Auth->identify();

            if (is_array($user) && array_key_exists('refid', $user)) {
                $user = $this->getInfo($user['refid']);

                // Profiling the user's account
                $user = $this->getProfile($user);

                // Setting the session
                $controller->Auth->setUser($user);
                $controller->getRequest()->withoutData('username');
                $controller->getRequest()->withoutData('password');
            }
        }
    }

    public function getPersonality($personality_id) {
        $data = $this->Personalities->get($personality_id);
        // $results = $query->all();
        // $data = $results->toArray();

        return $data->personality;
    }

//    public function getFollowers($user_refid) {
//
//        $query = $this->Follows->find('all')->where(['Follows.followed =' => $user_refid]);
//        $results = $query->all()->toArray();
//        $followers = [];
//        foreach ($results as $result) {
//            $followers[] = $result['follower'];
//        }
//        return $followers;
//    }
//
//    public function getFollowings($user_refid) {
//        $query = $this->Follows->find('all')->where(['Follows.follower =' => $user_refid]);
//        $results = $query->all()->toArray();
//        $followings = [];
//        foreach ($results as $result ) {
//            $followings[] = $result['followed'];
//        }
//
//        return $followings;
//    }

    /**
     * To be re-factored
     * @param type $genre_id
     * @return type
     */
    public function getGenre($genre_id) {
        $result = $this->Genres->get($genre_id);
        $genre = $result['genre'];
        return $genre;
    }

    /**
     * @param string $refid
     * @return \Cake\Datasource\ResultSetInterface
     */
    public function getSubscriptions(string $refid, string $type = null): ResultSetInterface
    {
        $SubscriptionsTable = (new TableLocator())->get('Subscriptions');
        $subscriptions = $SubscriptionsTable->find()
            ->where([
                'subscriber_refid' => $refid
            ]);

        if ($type) {
            $subscriptions = $subscriptions->andWhere([
                'subscribed_to' => $type
            ]);
        }

        return $subscriptions->all();
    }

    /**
     * Get a user's followers
     *
     * @param string $userID
     * @return CollectionInterface|null
     */
    public function getFollowers(string $userID): ?CollectionInterface
    {
        $followsTable = (new TableLocator())->get('Follows');
        return $followsTable
            ->find('followers', ['user' => $userID])
            ->map(
            function (\App\Model\Entity\Follow $follow, $index) {
                return $follow->follower;
            }
        );
    }

    /**
     * Get all users whom the user is following
     *
     * @param string $userID
     * @return CollectionInterface|null
     */
    public function getFollowings(string $userID): ?CollectionInterface
    {
        $followsTable = (new TableLocator())->get('Follows');
        return $followsTable
            ->find('followings', ['user' => $userID])
            ->map(
                function (\App\Model\Entity\Follow $follow, $index) {
                    return $follow->following;
                }
            );
    }

//    public function getSubscription(string $user, string $type)
//    {
//        $subscriptions = $this->getSubscriptions($user)
//
//        $subscriptions = $subscriptions->filter(
//            function (Subscription $subscription, $index)
//            use ($type) {
//                return $subscription->subscribed_to === $type;
//            }
//        );
//    }

    /**
     * Fetch all the groups that a user belongs to
     *
     * @param string $userID
     * @return CollectionInterface|null
     */
    public function getGroups(string $userID)
    {
        $Groups = (new TableLocator())->get('Groups');


//        return $query;
    }


    protected function _processRequests($account, $query) {
        if ($query != null) {

            if (array_key_exists('_a', $query)) {
                // self::restrictAccessToLoggedInUsers($this);

                $action = $query['_a'];
                $user = $this->Auth->user();

                $isAccountOwner = false;

                if ($account !== null && $user !== null) {
                    if (strtolower($account->username) === strtolower($user->username)) {
                        $isAccountOwner = true;
                    }
                }
                if (in_array($action, ['ac', 'rc', 'ec'])) {
                    if (!$isAccountOwner)
                        throw new ForbiddenException('You are not allowed to access this page.');
                }

                switch ($action) {
                    case 'ac': { // Add Component
                            if (
                                    (count($query) < 2) ||
                                    (count($query) >= 3 && (!array_key_exists('window', $query) || $query['window'] !== 'frame')) ||
                                    (!array_key_exists('_c', $query) || array_search('_c', array_keys($query)) !== 1)
                            ) {
                                $this->Flash->error(__('We did not understand the request. You must have entered an invalid address.'));
                            } else {
                                $component = $query['_c'];
                                switch ($component) {
                                    case 'playlist': {
                                            $this->_createPlaylist();
                                        }
                                        break;
                                    case 'album': {
                                            $this->createAlbum();
                                        }
                                        break;
                                    default: {
                                            $this->Flash->error(__('We did not understand the request. You must have entered an invalid address.'));
                                        }
                                }
                            }
                        }
                        break;
                    case 'rc': { // Remove Component
                            if (
                                    (count($query) < 2) ||
                                    (count($query) >= 3 && (!array_key_exists('window', $query) || $query['window'] !== 'frame')) ||
                                    (!array_key_exists('_c', $query) || array_search('_c', array_keys($query)) !== 1 )
                            ) {
                                $this->Flash->error(__('We did not understand the request. You must have entered an invalid address.'));
                            } else {
                                $component = $query['_c'];
                                switch ($component) {
                                    case 'playlist': {
                                            if (!array_key_exists('_pl_id', $query) || empty($query['_pl_id'])) {
                                                $this->Flash->error(__('We did not understand the request. You must have entered an invalid address.'));
                                            } else {
                                                $plId = $query['_pl_id'];
                                                $this->deletePlaylist($plId);
                                            }
                                        }
                                        break;
                                    case 'album': {
                                            if (!array_key_exists('_abm_id', $query) || empty($query['_abm_id'])) {
                                                $this->Flash->error(__('We did not understand the request. You must have entered an invalid address.'));
                                            } else {
                                                $abm_id = $query['_abm_id'];
                                                $this->deleteAlbum($abm_id);
                                            }
                                        }
                                        break;
                                    default: {
                                            $this->Flash->error(__('We did not understand the request. You must have entered an invalid address.'));
                                        }
                                }
                            }
                        }
                        break;
                    case 'ec': { // Edit Component
                            if (
                                    (count($query) < 2) ||
                                    (count($query) >= 3 && (!array_key_exists('window', $query) || $query['window'] !== 'frame')) ||
                                    (!array_key_exists('_c', $query) || array_search('_c', array_keys($query)) !== 1)
                            ) {
                                $this->Flash->error(__('We did not understand the request. You must have entered an invalid address.'));
                            } else {
                                $component = $query['_c'];
                                switch ($component) {
                                    case 'playlist': {
                                            if (!array_key_exists('_pl_id', $query) || empty($query['_pl_id'])) {
                                                $this->Flash->error(__('We did not understand the request. You must have entered an invalid address.'));
                                            } else {
                                                $plId = $query['_pl_id'];
                                                $this->editPlaylist($plId);
                                            }
                                        }
                                        break;
                                    case 'album': {
                                            if (!array_key_exists('_abm_id', $query) || empty($query['_abm_id'])) {
                                                $this->Flash->error(__('We did not understand the request. You must have entered an invalid address.'));
                                            } else {
                                                $abm_id = $query['_abm_id'];
                                                $this->editAlbum($abm_id);
                                            }
                                        }
                                        break;
                                    default: {
                                            $this->Flash->error(__('We did not understand the request. You must have entered an invalid address.'));
                                        }
                                }
                            }
                        }
                        break;
                    case 'commit': { // Follow, Unfollow, Block
                            if ($this->request->is('ajax')) {
                                $this->viewBuilder()->setLayout('ajax');
                                $this->autoRender = false;
                            }

                            if (
                                    (count($query) < 2) ||
                                    (count($query) >= 3 && (!array_key_exists('window', $query) || $query['window'] !== 'frame')) ||
                                    (!array_key_exists('intent', $query) || array_search('intent', array_keys($query)) !== 1 )
                            ) {
                                $this->Flash->error(__('Unable to execute request. Request not understood!'));
                            }

                            // if ( ! $this->request->getData() ) {
                            // $this->Flash->error(__('Sorry, no data received.'));
                            // return;
                            // }

                            $intent = $query['intent'];
                            switch ($intent) {
                                case 'follow': {
                                        if ($this->request->is('ajax')) {
                                            echo 'Follow';
                                        }
                                    }
                                    break;
                                case 'unfollow': {

                                    }
                                    break;
                                case 'block': {

                                    }
                                    break;
                                default: {

                                    }
                            }
                        }
                        break;
                    default: {

                        }
                }
                //$MediaController->render('new/playlist');
            }
        }
    }

    private function _createPlaylist() {

        if ($this->request->is('post')) {

            $user = $this->Auth->user();

            $playlist = $this->Playlists->newEntity();
            $postData = $this->request->getData();
            $title = $postData['title'];
            $description = $postData['description'];

            if ($title == '') {
                $this->Flash->error(__('The title field is required.'));
            } else {
                $data = array(
                    'refid' => $this->RandomString->generate(16),
                    'user_refid' => $user->refid,
                    'name' => $title,
                    'description' => $description,
                    'list' => '',
                    'created' => date('Y-m-d h:i:s'),
                    'modified' => ''
                );

                $playlist = $this->Playlists->patchEntity($playlist, $data);
                if ($this->Playlists->save($playlist)) {
                    $this->Flash->success(__('Playlist created'));
                    $this->redirect('/' . $this->request->url);
                } else {
                    $this->Flash->error(__('The playlist could not be created.'));
                }
            }
        }

        //$this->viewBuilder()->setTemplate('add_component');
        $this->set('subpage', 'new_playlist');
    }

    public function createAlbum() {

        $user = $this->Auth->user();
        $album = $this->Albums->newEntity();

        if ($this->request->is('post')) {
            $postData = (array) $this->request->getData();
            $release_date = $postData['release_date']['year'] . '-' .
                    $postData['release_date']['month'] . '-' .
                    $postData['release_date']['day'];

            $album_refid = $this->RandomString->generate(16);
            $cover_photo = '';

            if (sizeof($postData['cover_photo']) > 0 && !empty($postData['cover_photo']['name']) && $postData['cover_photo']['error'] < 1) {

                // Upload the file to the server
                $destination = $user->refid . '/album-cover-photos/' . $album_refid . '_' . $postData['cover_photo']['name'];

                if ($this->FileManager->moveUploadedFile($postData['cover_photo'], $destination, false)) {
                    $cover_photo = $this->FileManager->getRecentlyUploadedFile('path');
                }
            }

            $data = array(
                'refid' => $album_refid,
                'user_refid' => $user->refid,
                'title' => $postData['title'],
                'description' => $postData['description'],
                'cover_photo' => $cover_photo,
                'release_date' => $release_date,
                'created' => date('Y-m-d h:i:s'),
                'modified' => ''
            );
            $album = $this->Albums->patchEntity($album, $data);

            if ($this->Albums->save($album)) {
                $this->Flash->default(__('Album created successfully.'));

                return $this->redirect('/' . $this->request->url . '/' . str_replace(' ', '-', $album->title));
            } else {
                // In case the database process fails, we delete the file has already been uploaded
                if ($file = $this->FileManager->getRecentlyUploadedFile('path'))
                    $this->FileManager->delete($file);

                $this->Flash->error(__('Oops! Unable to create album. Please try again.'));
            }
        }

        $this->set('subpage', 'new_album');
        $this->set('pageTitle', 'Create New Album');
        $this->set('album', $album);
        $this->set('_serialize', 'album');
    }

    public function viewAlbum($name = null, $id = null) {
        $album = null;

        if ($name) {
            $name = str_replace('-', ' ', $name);
            $album = $this->getAlbumByName($name);
            if (!$album) {
                $this->Flash->error('Album "' . $name . '" not found');
            }
        } else if ($id) {
            $album = $this->getAlbumById($id);
        }

        $MediaController = new MediaController();
        $MediaController->parseRequestResource($this->request);

        // Get items associated with this album
        $items = $MediaController->getMediaByAlbum($album->refid);

        // $this->set('title', 'Album - ' .$album->title );
        $this->set('album', $album);
        $this->set('items', $items);
        $this->set('_serialize', 'album');
        $this->set('_serialize', 'items');
        $this->set('subpage', 'view_album');
    }

    public function editAlbum($refid) {
        // print_r(get_class_methods($this));
        // exit;
        self::restrictAccessToLoggedInUsers($this);
        $user = $this->Auth->user();
        $album = $this->getAlbumByMcdId($refid);

        if (!$album) {

        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $postData = (array) $this->request->getData();

            $release_date = '';

            foreach ($postData['release_date'] as $key => $val) {
                $release_date .= $val . '-';
            }

            $release_date = trim($release_date, '-');

            $current_cover_photo = $album->cover_photo;

            $cover_photo = $current_cover_photo;


            if (sizeof($postData['cover_photo']) > 0 && !empty($postData['cover_photo']['name']) && $postData['cover_photo']['error'] < 1) {

                // Upload the file to the server
                $destination = $user->refid . '/album-cover-photos/' . $album->refid . '_' . $postData['cover_photo']['name'];

                if ($this->FileManager->moveUploadedFile($postData['cover_photo'], $destination, false)) {
                    $cover_photo = $this->FileManager->getRecentlyUploadedFile('path');
                }
            }

            $data = array(
                'title' => $postData['title'],
                'description' => $postData['description'],
                'cover_photo' => $cover_photo,
                'release_date' => $release_date,
                'modified' => date('Y-m-d h:i:s')
            );
            $album = $this->Albums->patchEntity($album, $data);

            if ($this->Albums->save($album)) {
                if ($cover_photo !== $current_cover_photo) {
                    $this->FileManager->delete($current_cover_photo);
                }

                $this->Flash->default(__('Album updated successfully'));

                return $this->redirect('/' . $this->request->url . '/' . str_replace(' ', '-', $album->title));
            } else {
                if ($file = $this->FileManager->getRecentlyUploadedFile('path'))
                    $this->FileManager->delete($file);

                $this->Flash->error(__('Oops! Could not update album. Please try again.'));
            }
        }

        $this->set('subpage', 'edit_album');
        $this->set('pageTitle', 'Edit Album - ' . $album->title);
        $this->set('album', $album);
        $this->set('_serialize', 'album');
    }

    public function deleteAlbum($refid) {
        self::restrictAccessToLoggedInUsers($this);
        //$this->request->allowMethod(['post', 'delete']);
        $record = $this->getAlbumByMcdId($refid);
        if (!$record) {
            $this->Flash->error(__('Album doesn\'t seem to exist.'));
        } else {
            if ($this->Albums->delete($record)) {
                $this->Flash->default(__('Album successfully removed.'));

                return $this->redirect('/' . $this->request->url);
            } else {
                $this->Flash->default(__('Oops! Unable to remove album due to an internal server error. Please try again.'));
                return $this->redirect('/' . $this->request->url . '/' . str_replace(' ', '-', $record->title));
            }
        }
    }

    public function addProperties(User $account)
    {
        // Get
        /* @var $userConnections \Cake\ORM\Query */
        $userConnections = $this->getConnections($account->get('refid'));
        foreach ($userConnections as $connection) {
            $account->connections[] = $connection->person->get('refid');
        }
        $account->numberOfConnections = $userConnections->count();

        // Get user awards


        return $account;
    }

    /**
     * Similar accounts retrieval method
     *
     * - compares the options with the user's personality,
     * - genre and whether or not the user isSinger
     *
     * @param $account object to match accounts with
     * @return array | null list of matching accounts
     */
    public function getSimilarAccounts($account)
    {
        /* @var $similarAccounts \Cake\ORM\Query */
        $similarAccounts = $this->Users->find('usersSimilarTo', [
            'user' => $account
        ]);

        return $similarAccounts->toArray();
    }


    protected function _getUserCurrentLocation()
    {
        return '';
    }

    protected function _getUserContentPrivacy()
    {

        return 'public';
    }



    public function isLoggedIn()
    {
        $controller = $this->getController();
        if ($controller->Auth->user() instanceof User) {
            return true;
        }
        return false;
    }

    /**
     *
     * @param User $user
     * @param type $mediaFiletype
     * @return type
     */
    public function getPlaylists(User $user = null, $mediaFiletype = null) {
        $c = $this->getController();
        if (!$user) {
            $user = $c->getActiveUser();
        }
        if (!$user) {
            return null;
        }

        $playlists = $this->Playlists->find()->where([
           'owner_refid =' => $user->refid,
            'type =' => $mediaFiletype
        ]);

        return $playlists;
    }

    public function getAlbum(User $user = null, $album_id) {
        $c = $this->getController();
        if (!$user) {
            $user = $c->getActiveUser();
        }
        if (!$user) {
            return null;
        }

        $album = $this->Albums->find()->where(['refid =' => $album_id])->limit(1)->first();

        return $album;
    }

    /**
     *
     * @param User $user
     * @param string $mediaFiletype
     * @return Query
     */
    public function getAlbums(User $user = null, $mediaFiletype = null) {
        $c = $this->getController();
        if (!$user) {
            $user = $c->getActiveUser();
        }

        $albums = $this->Albums->find()->where([
            'owner_refid =' => $user->refid
        ]);
        if ($mediaFiletype) {
            $albums->where([
                'type =' => $mediaFiletype
            ]);
        }

        return $albums;
    }

    public function getSettings() {

    }



//    public function getPosts($refid = null, $include_comments = true, $filter = 'any')
//    {
//        if (is_null($refid)) {
//            if ($this->user)
//                $refid = $this->user->refid;
//        }
//
//        $controller = $this->getController();
//        $PostsTbl = $this->_tableLocator->get('Posts');
//
//        $pagination_limit = $this->Cookie->check('UserPreferences.paged_result_limit')?
//                $this->Cookie->read('UserPreferences.paged_result_limit') : 20;
//        $comments = null;
//        if ($include_comments) {
//            $comments = 'Comments';
//        }
//        $query = $PostsTbl->find('all',
//                [
//                    'conditions' => ['Posts.author_refid' => $refid],
//                    'limit' => $pagination_limit,
//                    'contain' => ['Users', $comments]
//                ]);
//
//        $posts = $query->orderDesc('Posts.id')->all()->toArray();
//
//        // $query = $articles->find() ->where(['published' => 1]) ->limit(10) ->contain(['Users', 'Comments']);
//        if (count($posts)) {
//            array_walk_recursive($posts, function(&$post, $keyOrIndex) {
//                $post->author = $post->user;
//                unset($post->user);
//            });
//        }
//
//        return $posts;
//    }


    /**
     * @param string|object $user
     * @return \Cake\ORM\Query;
     */
    public function getConnections($user)
    {
        if (is_string($user)) {
            $userID = $user;
        } elseif ($user instanceof User) {
            $userID = $user->get('refid');
        } else {
            return null;
        }
        $Connections = (new TableLocator())->get('Connections');
        $connections = (array) $Connections->extractActualConnectionsAsArray($userID);

        return $connections;
    }

    public function getNotifications($refid = null, $type = null)
    {
        if (is_null($refid)) {
            if ($this->user)
                $refid = $this->user->refid;
        }

        $NotifsTbl = $this->_tableLocator->get('Notifications');
        $query = $NotifsTbl->find()->where(['target_id' => $refid]);
        $result = null;

        if (!is_null($type))
        {
            switch ($type)
            {
                case 'unread':
                    $query = $query->where(['read' => '0', 'trashed' => '0']);
                    break;
                case 'read':
                    $query = $query->where(['read' => '1', 'trashed' => '0']);
                    break;
                case 'trashed':
                    $query = $query->where(['trashed' => '1']);
                    break;
                case 'trashed_unread':
                    $query = $query->where(['read' => '0', 'trashed' => '1']);
                    break;
                case 'trashed_read':
                    $query = $query->where(['read' => '1', 'trashed' => '1']);
                    break;
                default:
                    ;
            }

        }

        if ($query !== false) {
            $result = $query->all()->toList();
        }

        return $result;
    }

    public function getUser($credential, $with_properties = false)
    {
        $user = $this->Users->getUser($credential);
        if (! $user) {
            throw new \Cake\Datasource\Exception\RecordNotFoundException('User not found');
        }
        if ($with_properties) {
//            $user->profile =
        }

        return $user;
    }

    /**
     *
     * @param string $awardeeId
     * @return array
     */
    public function getAwards($awardeeId)
    {
        $tbl = $this->_tableLocator->get('Awards');
        $awards = $tbl->find('all', [
                    'conditions' => [
                        'user_refid' => $awardeeId
                    ]
                ])
                ->all()
                ->toArray();

        return $awards;
    }

    public function getNominations($nomineeId)
    {
        $tbl = $this->_tableLocator->get('Nominations');
        $nominations = $tbl->find('all', [
                    'conditions' => [
                        'user_refid' => $nomineeId
                    ]
                ])
                ->all()
                ->toArray();

        return $nominations;
    }

    public function getAchievements($achieverId)
    {
        $tbl = $this->_tableLocator->get('Achievements');
        $achievements = $tbl->find('all', [
                    'conditions' => [
                        'user_refid' => $achieverId
                    ]
                ])
                ->all()
                ->toArray();

        return $achievements;
    }

    /**
     * @param User $actor
     * @param string $aspect
     * @return array
     */
    public function getUserIndustryInfo(User $actor, string $aspect)
    {
        $userIndustryInfo = [];
        $profileAspect = $actor->profile->$aspect;

        if (!is_null($profileAspect)) {
            $userIndustryInfo = collection($profileAspect)->map(
                function ($row) use($aspect) {
//                    $TableAlias = ucfirst(Inflector::camelize($aspect));
//                    $industriesTbl = (new TableLocator())->get($TableAlias);
//                    $industry = $industriesTbl->get($id);
                    return $row->name;
                }
            )->toArray(false);
        }

        return $userIndustryInfo;
    }

    public function getFoundations($userId, $status = 'published')
    {
        $tbl = $this->_tableLocator->get('Foundations');
        $foundations = $tbl->find('all', [
                    'conditions' => [
                        'user_refid' => $userId,
                        'status' => $status
                    ]
                ])
                ->all()
                ->toArray();
        return $foundations;
    }

    /**
     * @param User $user
     * @param string $status
     * @return mixed
     */
    public function getCauses(User $user, $status = 'published')
    {
        $tbl = $this->_tableLocator->get('Causes');
        $causes = $tbl->find('all', [
                    'conditions' => [
                        'user_refid' => $user->refid,
                        'status' => $status
                    ]
                ])
                ->all()
                ->toArray();
        return $causes;
    }

    public function getEvents($user, $conditions = [])
    {
        $userID = '';
        if (is_string($user) && strlen($user) === 20)
            $userID = $user;
        elseif ($user instanceof User)
            $userID = $user->get('refid');
        else
            throw new InvalidArgumentException('Parameter 1 expects either a string user refid or an object of User');

        $tableLocator = new TableLocator();
        $Events = $tableLocator->get('Events');

        if (! $conditions) {
            $conditions['status'] = 'published';
        }
        $conditions['user_refid'] = $userID;
        $events = $Events->find()
                ->where($conditions)
                ->contain([
                    'EventVenues' => ['EventInvitees'],
                    'EventInvitees' => ['Invitees']
                ]);

        if ($events->count() > 0) {
            $events = $events->toArray();
        }

        return $events;
    }

    public function getIDsOfConnections($user, $query = null)
    {
        $IDs = [];
        if (!$query) {
            $query = $this->find('forUser', ['user' => $user]);
        }
        $query->each(function ($row) use(&$IDs) {
            $IDs[] = $row->get('correspondent_refid');
        });

        return $IDs;
    }

    /**
     * Fetches the connections of each person from a given user's connections list
     *
     * If the $user is null, then the $query object must not be null
     *
     * @param string $user refid of the user
     * @return Collection
     */
    public function connectionsOfConnections(string $user)
    {
        $userConnections = $this->connections($user);

        $connectionsOfConnections = [];
        $userConnections->each(
            function (User $connection)
            use ($user, &$connectionsOfConnections) {
                /**
                 * @var CollectionInterface $connectionsOfThisConnection
                 */
                $connectionsOfThisConnection = $this
                    ->connections(
                        $connection->get('refid'), $user
                    )
                    ->filter(
                        function (User $thisConnection)
                        use ($user) {
                            return $thisConnection->get('refid') !== $user;
                        }
                    )
                    ->toArray();
//
                $connectionsOfConnections = array_merge(
                    $connectionsOfConnections,
                    $connectionsOfThisConnection
                );
            }
        );

        $connectionsOfConnections = \collection(
            array_unique($connectionsOfConnections)
        );

        return $connectionsOfConnections;
    }

    /**
     * Extracts the actual users from result returned by ConnectionsTable::findUserConnections();
     *
     * @param string $user
     * @return CollectionInterface
     */
    public function connections(string $user, string $excludedUser = null)
    {
        $ConnectionsTable = (new TableLocator())->get('Connections');
        $rawConnections = $ConnectionsTable->find('forUser', ['user' => $user]);

        $filteredConnections = $rawConnections->extract(
            function ($row) {
                return $row->correspondent;
            }
        )
            ->toArray();

        $filteredConnections = \collection($filteredConnections)
            ->filter(function ($person) use($excludedUser) {
                return $person->refid !== $excludedUser;
            });

        return $filteredConnections;
    }


    /**
     *
     * @param string|User $userOne The primary user with whose connections list is being
     * is being searched
     * @param string|User $userTwo string|array One or more users to compare connections
     * against. If there is more than one user, the processes will be repeated
     * for each user
     * @return array|null
     */
    public function getMutualConnections($userOne, $userTwo)
    {
        if ($userOne instanceof User) {
            $userOne = $userOne->get('refid');
        }
        if ($userTwo instanceof User) {
            $userTwo = $userTwo->get('refid');
        }
        if ($userOne === $userTwo) {
            return null;
        }

        $connectionsOfUserOne = (array) $this->connections($userOne)->toArray();
        $connectionsOfUserTwo = (array) $this->connections($userTwo)->toArray();
        $commonConnections = array_intersect($connectionsOfUserOne, $connectionsOfUserTwo) ?? null;

        return $commonConnections;
    }

    /**
     * @param $user string
     * @param $user2
     */
    public function hasMutualConnectionsWith($user, $user2)
    {
        return null === $this->getMutualConnections($user, $user2);
    }

    /**
     * Get a list of the most basic containable association
     * By default, this method will return an array containing `Profiles`, since
     * each user has a profile (which is created automatically upon account
     * creation). Either or both of Emails and/or Phones will be added
     * only if the user has either or both.
     *
     * @param string $refid The user's refid (primaryKey)
     * @return array An array containing `Profiles` as the first and default
     * value, and either or both of `Emails` and/or `Phones` as additional values.
     */
    public function getBasicContainables($refid)
    {
        $containments = ['Profiles'];
        $locator = new TableLocator();
        $emailsTable = $locator->get('Emails');
        $phonesTable = $locator->get('Phones');
        if ($emailsTable->exists(['user_refid' => $refid])) {
            $containments[] = 'Emails';
        }
        if ($phonesTable->exists(['user_refid' => $refid])) {
            $containments[] = 'Phones';
        }

        return $containments;
    }
}
