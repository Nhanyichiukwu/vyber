<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
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
use Cake\Validation\Validation;
use Cake\ORM\Locator\TableLocator;

/**
 * User component
 */
class BkpUserComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public $components = ['CustomString', 'Paginator', 'Cookie'];

    private $_tableLocator;


    public function initialize(array $config) {
        parent::initialize($config);

        $this->_tableLocator = $this->getController()->getTableLocator();

//        $this->Users = $this->_tableLocator->get('Users');
//        $this->Playlists = $tableLocator->get('Playlists');
//        $this->PlaylistsItems = $tableLocator->get('PlaylistsItems');
//        $this->Albums = $tableLocator->get('Albums');
//        $this->Comments = $tableLocator->get('Comments');
//        $this->Follows = $tableLocator->get('Follows');
//        $this->Personalities = $tableLocator->get('Personalities');
//        $this->UserPhotos = $tableLocator->get('UserPhotos');
//        $this->Campaigns = $tableLocator->get('Campaigns');
//        $this->Engagements = $tableLocator->get('Engagements');
//        $this->Notifications = $tableLocator->get('Notifications');
//        $this->Categories = $tableLocator->get('Categories');
//        $this->Genres = $tableLocator->get('Genres');
    }

    /**
     * isAccountOwner function
     *
     * Compares two user objects (typically the active user and the account
     * being viewed by the user) to see if they are the same
     *
     * @param \App\Model\Entity\User $account
     * @return boolean
     */
    public function isAccountOwner( \App\Model\Entity\User $account ) {
        $controller = $this->getController();
        $activeUser = $controller->getActiveUser();

        if ( false == $activeUser )
            return false;

        if ( $activeUser->ref_id === $account->ref_id )
            return true;
        return false;
    }

    /**
     * isActivated
     *
     * Check if a given account is activated or not
     *
     * @param \App\Model\Entity\User $account
     * @return boolean
     */
    public function isActivated( \App\Model\Entity\User $account ) {
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
            $controller->getRequest()->data['password'] = $password;

            if (Validation::email($username)) {
                $controller->Auth->config('authenticate', [
                    'Form' => [
                        'fields' => ['username' => 'email']
                    ]
                ]);

                $controller->Auth->constructAuthenticate();
                $controller->request->data['email'] = $username;
            } else {
                $controller->Auth->config('authenticate', [
                    'Form' => [
                        'fields' => ['username' => 'username']
                    ]
                ]);

                $controller->Auth->constructAuthenticate();
                // Re-assign the request data username to the validated and
                // sanitized username

                $controller->getRequest()->data['username'] = $username;
            }

            $user = $controller->Auth->identify();

            if (is_array($user) && array_key_exists('ref_id', $user)) {
                $user = $this->getInfo($user['ref_id']);

                // Profiling the user's account
                $user = $this->getProfile($user);

                // Setting the session
                $controller->Auth->setUser($user);
                unset($controller->getRequest()->data['username']);
                unset($controller->getRequest()->data['password']);
            }
        }
    }

    public function logout() {
        $this->redirect($this->Auth->logout());
    }

    /**
     *
     * @param string $credential
     * @return User object | false
     */
    public function getUser($credential) {
        $Users = $this->_tableLocator->get('Users');
        $user = null;

        if ( $Users->exists(['user_id =' => $credential]))
        {
            $q = $Users->find()->where(['user_id =' => $credential])->limit(1);
            $result = $q->all()->toArray();
            if (count($result)) {
                $user = $result[0];
            }
        }
        if ( $Users->exists(['username =' => $credential]))
        {
            $q = $Users->find()->where(['username =' => $credential])->limit(1);
            $result = $q->all()->toArray();
            if (count($result)) {
                $user = $result[0];
            }
        }
        elseif ( $Users->exists(['email =' => $credential]))
        {
            $q = $Users->find()->where(['email =' => $credential])->limit(1);
            $result = $q->all()->toArray();
            if (count($result)) {
                $user = $result[0];
            }
        }
        elseif ( $Users->exists(['phone =' => $credential]))
        {
            $q = $Users->find()->where(['phone =' => $credential])->limit(1);
            $result = $q->all()->toArray();
            if (count($result)) {
                $user = $result[0];
            }
        }

        return $user;
    }


    /**
     * Checks if a given user information is already in use
     * Searches the User table for a match
     *
     * @param string $info
     * @return boolean true on success | false otherwise
     */
    public function infoExists( $info )
    {
        $Users = $this->_tableLocator->get('Users');
        $infoExists = false;

        if ( $Users->exists(['username =' => $info]))
            $infoExists = true;
        elseif ( $Users->exists(['email =' => $info]))
            $infoExists = true;
        elseif ( $Users->exists(['phone =' => $info]))
            $infoExists = true;

        return $infoExists;
    }

    public function getPersonality($personality_id) {
        $data = $this->Personalities->get($personality_id);
        // $results = $query->all();
        // $data = $results->toArray();

        return $data->personality;
    }

//    public function getFollowers($user_user_id) {
//
//        $query = $this->Follows->find('all')->where(['Follows.followed =' => $user_user_id]);
//        $results = $query->all()->toArray();
//        $followers = [];
//        foreach ($results as $result) {
//            $followers[] = $result['follower'];
//        }
//        return $followers;
//    }
//
//    public function getFollowings($user_user_id) {
//        $query = $this->Follows->find('all')->where(['Follows.follower =' => $user_user_id]);
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
                    'user_id' => $this->RandomString->generate(16),
                    'user_user_id' => $user->user_id,
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

            $album_user_id = $this->RandomString->generate(16);
            $cover_photo = '';

            if (sizeof($postData['cover_photo']) > 0 && !empty($postData['cover_photo']['name']) && $postData['cover_photo']['error'] < 1) {

                // Upload the file to the server
                $destination = $user->user_id . '/album-cover-photos/' . $album_ref_id . '_' . $postData['cover_photo']['name'];

                if ($this->FileManager->moveUploadedFile($postData['cover_photo'], $destination, false)) {
                    $cover_photo = $this->FileManager->getRecentlyUploadedFile('path');
                }
            }

            $data = array(
                'ref_id' => $album_ref_id,
                'user_ref_id' => $user->ref_id,
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
        $items = $MediaController->getMediaByAlbum($album->ref_id);

        // $this->set('title', 'Album - ' .$album->title );
        $this->set('album', $album);
        $this->set('items', $items);
        $this->set('_serialize', 'album');
        $this->set('_serialize', 'items');
        $this->set('subpage', 'view_album');
    }

    public function editAlbum($ref_id) {
        // print_r(get_class_methods($this));
        // exit;
        self::restrictAccessToLoggedInUsers($this);
        $user = $this->Auth->user();
        $album = $this->getAlbumByMcdId($ref_id);

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
                $destination = $user->ref_id . '/album-cover-photos/' . $album->ref_id . '_' . $postData['cover_photo']['name'];

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

    public function deleteAlbum($ref_id) {
        self::restrictAccessToLoggedInUsers($this);
        //$this->request->allowMethod(['post', 'delete']);
        $record = $this->getAlbumByMcdId($ref_id);
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



    public function getFeed($user_ref_id) {
        $MediaController = new MediaController();
        $media = $content = $ref_ids = [];

        $followings = $this->getFollowings($user_ref_id);
        foreach ($followings as $record) {
            $ref_ids[] = $record->user_ref_id;
        }

        $ref_ids[] = $user_ref_id; // Also add the user in the list for general content retrieval

        foreach ($ref_ids as $user_id) {
            $audios = $MediaController->getUserAudios($user_id);
            $videos = $MediaController->getUserVideos($user_id);
            $media = array_merge($audios, $videos);
        }

        $dates = [];
        if (!empty($media)) {
            foreach ($media as $key => $m) {
                $dates[] = $m->created;

                usort($dates, function ($a, $b) {
                    return strtotime($a) - strtotime($b);
                });

                foreach ($dates as $date) {
                    if ($date == $m->created) {
                        $m = $MediaController->addFeatures($m);
                        $content[] = $m;
                    }
                }
            }
        }
        return $content;
    }

    /**
     * Profile View method
     *
     * @param string|null $path server request path
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\NotFoundException When record not found.
     */
    public function viewProfile(...$path) {
        // $this->viewBuilder()
        // ->layout('ui');

        $this->setPageCssClasses(['ui']);

        $params = $this->request->getQueryParams();

        if ($params) {
            if (isset($params['window']) && $params['window'] === 'popcard') {
                $this->viewBuilder()->layout('blank');
                $params = [];
            }
        }

        if (sizeof($path) > 3) {
            throw new NotFoundException($this->pageNotFoundMessage);
        }

        // Find the requested account
        $account = $this->getUser($path[0]);
        if (!$account)
            throw new NotFoundException($this->pageNotFoundMessage);

        if (sizeof($account) > 1) {
            return $this->Flash->error(__('Sorry. We\'re unable to complete your request due to an internal system error'));
        }

        // Profile the user account
        $account = $this->createProfile($account);

        // Define the page main title.
        $pageTitle = $account->fullname;

        // Getting user's media
        $MediaController = new MediaController();
        $MediaController->parseRequestResource($this->request);

        $account->gallery = (array) $MediaController->getUserGallery($account->ref_id);
        $account->songs = (array) $MediaController->getUserAudios($account->ref_id);
        $account->videos = (array) $MediaController->getUserVideos($account->ref_id);
        $account->playlists = (array) $this->getPlaylists($account->ref_id);
        $account->albums = (array) $MediaController->getUserAlbums($account->ref_id);
        $account->feed = $this->getFeed($account->ref_id);

        // Check whether the viewer is the owner
        $isAccountOwner = false;
        $user = $this->Auth->user();
        if (NULL !== $user && $user->ref_id === $account->ref_id) {
            $isAccountOwner = true;
        }

        $account->similarAccounts = $this->getSimilarAccounts($account);

        $subpage = '';
        $sub_subpage = '';

        if (sizeof($path) > 1) {
            array_shift($path);

            if (isset($path[0])) {
                $validSubPages = ['songs', 'audios', 'videos', 'playlists', 'gallery', 'following', 'followers', 'albums', 'about', 'ads'];

                $subpage .= $path[0];
                $this->set('subpage', $subpage);

                if (!in_array($subpage, $validSubPages)) {
                    throw new NotFoundException($this->pageNotFoundMessage);
                }

                // Move the array to the next key
                if ($path > 0)
                    array_shift($path);
            }
        }

        if ($subpage && count($path) > 0) {
            $sub_subpage .= $path[0];

            switch ($subpage) {
                case 'playlists': {
                        $this->viewPlaylist($sub_subpage);
                    }
                    break;
                case 'albums': {
                        $this->viewAlbum($sub_subpage);
                    }
                    break;
                default: {

                    }
            }
        }

        // Handle post, put, patch and delete requests at this point
        $this->_processRequests($account, $params);

        if ($subpage)
            $pageTitle .= ' - ' . ucfirst($subpage);
        if ($sub_subpage)
            $pageTitle .= ' &rarr; ' . ucwords(str_replace('-', ' ', $sub_subpage));

        $this->set('isAccountOwner', $isAccountOwner);
        $this->set('pageTitle', $pageTitle);
        $this->set('account', $account);
        $this->set('_serialize', ['account']);
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
    public function getSimilarAccounts($account) {
        $loggedUser = $this->Auth->user();
        $users = $this->Users->getAll();
        $similarAccounts = [];

        foreach ($users as $index => $userObj) {
            if (null !== $loggedUser) {
                if ($loggedUser->ref_id === $userObj->ref_id) {
                    continue; // Skip it
                }
            }

            if ($account->ref_id === $userObj->ref_id) {
                continue; // Skip it
            }

            // Profile the user's account
            $userObj = $this->createProfile($userObj);

            if ($userObj->hasPersonality) {
                if (stripos($account->personality, $userObj->personality) !== false || $userObj->genre === $account->genre) {
                    $similarAccounts[] = $userObj;
                }
            }
        }

        return $similarAccounts;
    }

    /**
     * User Profiler method
     *
     * @param array|object App\Model\Entity\User $user
     * @return \stdClass object $user
     */
    public function getProfile( \App\Model\Entity\User $account )
    {
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
//        if ($account->genre_id) {
//            $account->genre = strtoupper($this->getGenre($account->genre_id));
//        }
//        if ($account->acceptsFollowers) {
//            $account->followers = $this->getFollowers($account->ref_id);
//        }
//        $account->followings = $this->getFollowings($account->ref_id);
//        $account->totalFollowers = count($account->followers);
//        $account->totalFollowings = count($account->followings);
//        // Set empty variables for user's content
//        $account->gallery = $account->songs = $account->videos = $account->playlists = $account->albums = $account->feed = [];

        // Getting user's promoted media
        // $account->ads = (array) $this->getAds( $account->ref_id );
        return $account;
    }

    public function isLoggedIn()
    {
        $controller = $this->getController();
        if ($controller->Auth->user() instanceof \App\Model\Entity\User) {
            return true;
        }
        return false;
    }

    public function getPlaylists($mediaFiletype = null) {
        $c = $this->getController();
        $user = $c->getActiveUser();
        if (!$user) {
            return false;
        }
        $playlistsTlb = $this->Playlists;
        $results = $playlistsTlb->find()->where([
           'author_ref_id =' => $user->ref_id,
            'media_type =' => $mediaFiletype
        ]);
        $playlists = (array) $results->all()->toArray();

        return $playlists;
    }

    public function getAlbum($album_id) {
        $c = $this->getController();
        $user = $c->getActiveUser();
        if (!$user) {
            return false;
        }
        $albumsTbl = $this->Albums;
        $results = $albumsTbl->find()->where(['ref_id =' => $album_id])->limit(1);
        $album = (array) $results->all()->toArray();

        return $album[0];
    }

    public function getAlbums($mediaFiletype = null) {
        $c = $this->getController();
        $user = $c->getActiveUser();
        if (!$user) {
            return false;
        }
        $albumsTbl = $this->Albums;
        $results = $albumsTbl->find()->where([
            'author_ref_id =' => $user->ref_id,
            'media_type =' => $mediaFiletype
        ]);
        $albums = (array) $results->all()->toArray();

        return $albums;
    }

    public function getSettings() {

    }

    public function getNewsfeed($user_id)
    {
//        $controller = $this->getController();
//        $request = $controller->getRequest();
//        $response = $controller->getResponse();

        $feedSources = $this->getFeedSources($user_id);

        $posts = [];
        for ($x = 0; $x < sizeof($feedSources); $x++) {
            // Because the getPosts method return an array of posts from a given
            // user_id, we need to loop through to pick each individual post and
            // add it to the list of post

            // Get all recent posts from the user with the user_id at $feedSources[$x];
            $sourcePosts = $this->getPosts($feedSources[$x], true, 'recent');
            foreach ($sourcePosts as $post) {
                $posts[] = $post;
            }
        }

        return $posts;
    }

    public function getPosts($user_id, $include_comments = false, $filter = 'any')
    {
        $controller = $this->getController();
        $PostTbl = $this->_tableLocator->get('Posts');

        $pagination_limit = $this->Cookie->check('UserPreferences.paged_result_limit')?
                $this->Cookie->read('UserPreferences.paged_result_limit') : 20;
        $comments = '';
        if ($include_comments) {
            $comments = 'Comments';
        }
        $query = $PostTbl->find('all',
                [
                    'conditions' => ['Posts.author_id' => $user_id],
                    'limit' => $pagination_limit,
                    'contain' => ['Users', $comments]
                ]);
        $posts = $query->orderDesc('Posts.created')->all()->toArray();
        // $query = $articles->find() ->where(['published' => 1]) ->limit(10) ->contain(['Users', 'Comments']);

        return $posts;
    }

    public function getFeedSources($user_id, $include_followed_feeds = false)
    {
        // The primary source is the user
        $sources = [$user_id];

        // Get IDs of user's connections
        $sources += (array) $this->getConnectionsIds($user_id);

        if ($include_followed_feeds) {
            // IDs of users to which timeline the use is subscribed
            $sources += (array) $this->getFollowedFeeds($user_id);
        }

        return $sources;
    }

    public function getFollowedFeeds($user_id) {
        $ff = $this->_tableLocator->get('FollowedFeeds');
        $query = $ff->find()->where(['subscriber_id =' => $user_id]);
        $result = $query->aliasField('user_id');

        return $result;
    }

    public function getConnectionsIds($user_id) {
        $ConxTbl = $this->_tableLocator->get('Connections');
        $query = $ConxTbl->find()->where(['OR' => ['party_a' => $user_id, 'party_b' => $user_id]]);
        $result = $query->aliasFields(['party_a', 'party_b']);
        $connections = [];

        foreach ($result as $key => $value) {
            if ($value === $user_id) {
                continue;
            }

            $connections[] = $value;
        }

        return $connections;
    }

    public function getConnections($user_id)
    {
        $connections = (array) $this->getConnectionsIds($user_id);

        if (count($connectionsIds))
        {
            array_walk($connections, function(&$connection, $index) {
                $connection = $this->getUser($connection);
            });
        }

        return $connections;
    }

    public function getNotifications($user_id, $type = null)
    {
        $NotifsTbl = $this->_tableLocator->get('Notifications');
        $query = $NotifsTbl->find()->where(['Notifications.target_id =' => $user_id]);
        $result = null;

        if (is_null($type)) {
            switch ($type)
            {
                case 'unread':
                    $query = $query->where(['Notifications.read =' => '0', 'Notifications.trashed =' => '0']);
                    break;
                case 'read':
                    $query = $query->where(['Notifications.read =' => '1', 'Notifications.trashed =' => '0']);
                    break;
                case 'trashed':
                    $query = $query->where(['Notifications.trashed =' => '1']);
                    break;
                case 'trashed_unread':
                    $query = $query->where(['Notifications.read =' => '0', 'Notifications.trashed =' => '1']);
                    break;
                case 'trashed_read':
                    $query = $query->where(['Notifications.read =' => '1', 'Notifications.trashed =' => '1']);
                    break;
                default:
                    $query = false;
            }

        }

        if ($query !== false) {
            $result = $query->all()->toList();
        }

        return $result;
    }

    public function getMessages($user_id, $filter = null)
    {
        $MsgTbl = $this->_tableLocator->get('IncomingMessages');
        $query = $MsgTbl->find()->where(['IncomingMessages.recipient_id =' => $user_id]);
        $result = null;

        if ( !is_null($filter) )
        {
            switch ($filter)
            {
                case 'read':
                    $query = $query->where(['IncomingMessages.read =' => '1', 'IncomingMessages.trashed =' => '0']);
                    break;
                case 'unread':
                    $query = $query->where(['IncomingMessages.read =' => '0', 'IncomingMessages.trashed =' => '0']);
                    break;
                case 'trashed':
                    $query = $query->where(['IncomingMessages.trashed =' => '1']);
                    break;
                case 'trashed_read':
                    $query = $query->where(['IncomingMessages.trashed =' => '1', 'IncomingMessages.read =' => '1']);
                    break;
                case 'trashed_unread':
                    $query = $query->where(['IncomingMessages.trashed =' => '1', 'IncomingMessages.read =' => '0']);
                    break;
                case 'seen':
                    $query = $query->where(['IncomingMessages.seen =' => '1', 'IncomingMessages.trashed =' => '0']);
                    break;
                case 'has_attachment':
                    $query = $query->where(['IncomingMessages.has_attachment =' => '1', 'IncomingMessages.trashed =' => '0']);
                    break;
                case 'has_attachment_trashed':
                    $query = $query->where(['IncomingMessages.has_attachment =' => '1', 'IncomingMessages.trashed =' => '1']);
                    break;
                default:
                    $query = false;
            }

            if ($query !== false) {
                $result = $query->all()->toList();
            }

            return $result;
        }
    }

    public function getChats($user_id)
    {

    }

    public function getChat($chat_id)
    {

    }
}
