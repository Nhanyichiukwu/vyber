<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\EventInterface;
use Cake\ORM\Locator\TableLocator;
use Cake\Utility\Text;
use Cake\Utility\Security;
use Cake\Utility\Inflector;
use App\Utility\CustomString;
use App\Utility\RandomString;
use Cake\Cache\Cache;
use Cake\Core\Plugin;
use Cake\Event\Event;
use Cake\Error\Debugger;
use Cake\Core\Configure;
use Cake\Validation\Validation;
use Cake\Datasource\ConnectionManager;
use Cake\Network\Exception\NotFoundException;
use Cake\Network\Exception\ForbiddenException;
use Cake\Http\Exception\BadRequestException;
use Cake\Controller\Exception\MissingActionException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Http\ServerRequest;
use Cake\Auth\DefaultPasswordHasher;

/**
 * Settings Controller
 *
 *
 * @method \App\Model\Entity\Setting[] paginate($object = null, array $settings = [])
 * @property \App\Model\Table\UsersTable $Users;
 */
class SettingsController extends AppController
{


    public function initialize(): void
    {
        parent::initialize();

        $this->loadModel('Users');
        $this->set(['page_layout' => 'no-sidebar','sidebar' => false]);

//        $this->Auth->allow(['help']);
    }


    public function beforeRender(EventInterface $event) {
        parent::beforeRender($event);
//        $this->viewBuilder()->setLayout('settings');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $user = $this->getActiveUser();

        $this->set(compact('user'));
        $this->set('page', 'profile');
    }


    public function career(...$path)
    {
        $page = $subpage = null;

        if (!empty($path[0])) {
            $page = $path[0];
        }

        if (!empty($path[1])) {
            $subpage = $path[1];
        }

        // Prevent illegal dots in the path
        if (in_array('..', $path, true) || in_array('.', $path, true)) {
            throw new ForbiddenException();
        }

        $request = $this->getRequest();
        $user = $this->getActiveUser();
        $industry = 'defineIndustry';

        if (! $request->getQuery('change_industry') && ! empty($user->industry)) {
            $industry = $user->industry . 'Industry';
        }

        $tpl = Inflector::underscore($industry);

        if (count($path)) {
            $tpl = implode('/', $path);
        }

        try {
            $this->viewBuilder()->setTemplate($tpl);
        } catch (MissingTemplateException $ex) {
            if (Configure::read('debug')) {
                throw new MissingTemplateException($ex);
            } else {
                throw new NotFoundException();
            }
        }

        $this->set('user', $user);
//        return $this->setAction($industry);
    }

    public function defineIndustry($option = null)
    {
        $request = $this->getRequest();
        $user = $this->getActiveUser();

        if ($request->is(['post', 'put'])) {
            if (! empty($request->getData('industry'))) {
                $industry = $request->getData('industry');
                $user = $this->Users->patchEntity($user, ['industry' => $industry]);

                if ($this->Users->save($user)) {
                    $this->Flash->success('Industry Saved');
                    return $this->redirect(['action' => 'industry']);
                }

                $this->Flash->error(__('Sorry. Unable to choose industry'));
            }
        }
    }

    /**
     *
     * @return void
     */
    public function musicIndustry()
    {
        // Initializing Variables
        $request = $this->getRequest();
        $user = $this->getActiveUser();

        // Initializing Table Locators
        $this->loadModel('MusicMakers');
        $this->loadModel('UserEntities');
        $this->loadModel('Roles');
        $this->loadModel('MusicCategories');
        $this->loadModel('Genres');
        $this->loadModel('Albums');
        $this->loadModel('MusicalInstruments');
        $this->loadModel('Songs');

        // Retrieving data
        $userEntities = (array) $this->UserEntities->find()->all()->toArray();
        $userRoles = (array) $this->Roles->find()->all()->toArray();
        $musicCategories = (array) $this->MusicCategories->find()->chunk(4)->toArray();
        $genres = (array) $this->Genres->find()->all()->toArray();
        $musicalInstruments = $this->MusicalInstruments->find()->all()->toArray();
        $albums = (array) $this->Albums->find('byUser', ['user' => $user->refid])->all()->toArray();
        $songs = (array) $this->Songs->find('byAuthor', ['author' => $user->refid])->all()->toArray();
        $musicMakerResult = $this->MusicMakers->find('userData', ['user' => $user->refid])->limit(1)->all()->toArray();
        $musicMakerData = false;
        if (count($musicMakerResult)) {
            $musicMakerData = $musicMakerResult[0];
        }
        if (! $musicMakerData) {
            $musicMakerData = $this->MusicMakers->newEntity();
        }


        if ($request->is('post'))
        {
            // Receiving Data from the post request
            $entity = $request->getData('user_entity');
            $role = $request->getData('role');
            $stagename = $request->getData('stagename');
            $genre = $request->getData('genre');
            $musicCats = (empty($request->getData('music_categories')) ? '' :
                    implode(',', $request->getData('music_categories')));
            $debut = implode('-', array_values($request->getData('debut')));
            $debutAlbum = $request->getData('debut_album');
            $debutSong = $request->getData('debut_song');
            $manager = $request->getData('manager');
            $skills = $request->getData('skills');
            $instruments = (empty($request->getData('instruments')) ? '' :
                    implode(',', $request->getData('instruments')));
            $debut = implode('-', array_values($request->getData('debut')));
            $story = $request->getData('story');

            $data = [
                'user_refid' => $user->refid,
                'user_entity_refid' => $entity,
                'role_refid' => $role,
                'stagename' => $stagename,
                'genre_refid' => $genre,
                'music_categories' => $musicCats,
                'debut' => $debut,
                'debut_album' => $debutAlbum,
                'debut_song' => $debutSong,
                'manager' => $manager,
                'skills' => $skills,
                'instruments_known' => $instruments,
                'story' => $story
            ];

            $musicMakerData = $this->MusicMakers->patchEntity($musicMakerData, $data);
            if ($this->MusicMakers->save($musicMakerData)) {
                $this->Flash->success(__('Recored updated successfully'));
                return $this->redirect($request->getRequestTarget());
            }
            $this->Flash->error(__('Oops! Something went wrong. Please try again.'));
        }

        // $this->viewBuilder()->setTemplate('music_industry');

        $this->set(compact('musicMakerData', 'userEntities', 'userRoles', 'musicCategories', 'genres', 'musicalInstruments', 'albums', 'songs'));
    }

    public function movieIndustry()
    {

    }

    public function oldAccount()
    {
//        $page = $subpage = null;
//
//        if (!empty($path[0])) {
//            $page = $path[0];
//        }
//
//        if (!empty($path[1])) {
//            $subpage = $path[1];
//        }
//
//        // Prevent illegal dots in the path
//        if (in_array('..', $path, true) || in_array('.', $path, true)) {
//            throw new ForbiddenException();
//        }

        // $this->detectRequestOrigin();

//        if (!empty($page)) {
//            $prepareContent = '_' . $page;
//
//            if (method_exists($this, $prepareContent)) {
//                $this->$prepareContent();
//            } else {
//                if (Configure::read('debug')) {
//                    throw new MissingActionException;
//                }
//                throw new NotFoundException();
//            }
//        }

//        $this->set(compact('page', 'subpage'));
//        //$this->viewBuilder()->setTemplatePath('Settings\account');
//
//        // Set a fallback path if there is none requested
//        if (!count($path)) {
//            $path[] = 'account';
//        }
//
//        $template = implode('/', $path);
//        try {
//            $this->viewBuilder()->setTemplate($template);
//        } catch (MissingTemplateException $exception) {
//            if (Configure::read('debug')) {
//                throw $exception;
//            }
//            throw new NotFoundException();
//        }
    }

    public function account()
    {
        $user = $this->getActiveUser();

        $this->set(compact('user'));
    }


    protected function _edit()
    {
        $request = $this->getRequest();
        if ($request->is(['post','put']))
        {
            $section = $request->getParam('section');
            $editSection = 'edit' . ucfirst($this->CustomString->toCamelCase($section));
            $this->loadComponent('AccountUpdater');

            if ($this->AccountUpdater->$editSection())
            {
                $this->Flash->success(__($this->AccountUpdater->getLastMessage()));
                return $this->_doRedirect();
            }
            else
            {
                $this->Flash->error(__($this->AccountUpdater->getLastMessage()));
            }
        }

        //$this->getRequest()->allowMethod(['get','post','patch','put','ajax']);
        $UsersTbl = $this->loadModel('Users');
        //$ContactsTbl = $this->loadModel('Contacts');
        $user = $UsersTbl->get($this->getActiveUser()->refid);
        //$contacts = $ContactsTbl->find('belongingTo', ['user' => $user]);

        $this->set(compact('user', 'contacts'));
    }

    public function name() {

    }

    /**
     * @param null $subpage
     * @return \Cake\Http\Response|null|void
     */
    public function profile($subpage = null)
    {
        $request = $this->getRequest();
        $response = $this->getResponse();

        $user = $this->getActiveUser([
            'Emails',
            'Phones',
//            'Profiles' => [
//                'Industries',
//                'Roles',
//                'Genres',
//                'Languages',
//                'Educations'
//            ]
        ]);


        if ($request->is(['post','put'])) {
            try {
                $accountUpdater = $this->loadComponent('AccountUpdater');
            } catch (\Throwable $e) {
                if (Configure::read('debug')) {
                    throw new $e;
                }
            }

            $section = $request->getData('section');
            if (!empty($section)) {
                $updateSection = 'update' . Inflector::camelize($section);
                if (!method_exists($accountUpdater, $updateSection)) {
                    $this->Flash->error(
                        __('Oops! Profile update failed. You must have submitted an invalid ' .
                            'form or the form may have expired. Try refreshing ' .
                            'the page and try again.')
                    );
//                    return null;
                } elseif ($accountUpdater->$updateSection($request)) {
                    $this->Flash->success(__($accountUpdater->getLastMessage()));
                    return $this->redirect(
                        $request->getRequestTarget()
                    );
                } else {
                    $this->Flash->error($accountUpdater->getLastMessage());
                }
            }
        }

        $userIndustries = $this->User->getUserIndustryInfo($user, 'industries');
        $userRoles = $this->User->getUserIndustryInfo($user, 'roles');
        $userGenres = $this->User->getUserIndustryInfo($user, 'genres');

        $this->set(compact('user','userIndustries','userRoles','userGenres'));
    }

//
//    protected function _doRedirect()
//    {
//        $request = $this->getRequest();
//        $redirectUri = $request->getQuery('redirect');
//        if ($redirectUri) {
//            $redirectUri = urldecode($redirectUri);
//            return $this->redirect($redirectUri);
//        } else {
//            return $this->redirect($request->referer(true));
//        }
////        if ($request->getParam('request_origin') === 'iframe') {
////            return $this->redirect($request->referer(true));
////        } else {
////            return $this->redirect(['controller' => $request->getParam('controller'), 'action' => ]);
////        }
//    }
    public function notification()
    {

    }

    public function addEmail() {
        $user = $this->getActiveUser();
        $request = $this->getRequest();
        $emailTable = $this->getTableLocator()->get('Emails');
        $email = $emailTable->newEmptyEntity();
        if ($request->is('post')) {

        }
    }


    /**
     * @return \Cake\Http\Response|null
     */
    public function editEmail() {
        $id = $this->getRequest()->getQuery('id');

        if (is_null($id)) {
            throw new \Cake\Http\Exception\BadRequestException(
                'Oops! You must have followed a broken link. Please go back' .
                ' to previous page.'
            );
        }
        $user = $this->getActiveUser([
            'Emails',
            'Phones',
        ]);

        if ($user->emails[$id]->is_primary) {
            $this->Flash->warning(__('Sorry. But you cannot edit ' .
                'the primary email. First make another one the primary email ' .
                'before making changes to this one.'));
            return $this->redirect([
                'controller' => 'settings',
                'actions' => 'account',
            ]);
        }
        $this->set(compact('id'));
    }

    public function addPhone() {

    }

    public function changePhone($phoneID = null) {

    }

    public function username() {
        $user = $this->getActiveUser();
        $request = $this->getRequest();
        $response = $this->getResponse();
        $isAjax = $request->is('ajax');
//        if ($isAjax) {
//            $this->autoRender = false;
//        }

        if ($request->is('post')) {
            $currentUsername = $user->getUsername();
            $username = $request->getData('username');
            $password = $request->getData('password');
            if ($username && false === Validation::notBlank($username)) {
                $status = 'error';
                $message = 'Please input username';
            } elseif ($password && false === Validation::notBlank($password)) {
                $status = 'error';
                $message = 'Please input password';
            } elseif (false === Validation::alphaNumeric($username)) {
                $status = 'error';
                $message = 'Invalid character found in username. Only letters and numbers are allowed.';
            } elseif (false === (new DefaultPasswordHasher())->check($password, $user->get('password'))) {
                $status = 'error';
                $message = 'Your password is incorrect';
            } elseif (Validation::equalTo($username, $currentUsername)) {
                $status = 'error';
                $message = 'Nothing changed';
            } elseif (true === $this->Users->getUser($username)) {
                $status = 'error';
                $message = 'Username already taken';
            } elseif (false === Validation::lengthBetween($username, 3, 15)) {
                $status = 'error';
                $message = 'Username must be between 3-15 characters long';
            } else {
                $user = $this->Users->patchEntity($user, ['username' => $username]);
                if ($this->Users->save($user)) {
                    $status = 'success';
                    $message = 'Username changed';
                }
            }

            if ($isAjax) {
                $msg = json_encode(array(['status' => $status, 'message' => $message]));
                $response = $response->withStringBody($msg)->withType('json');
                return $response;
            }

            $this->Flash->$status(__($message));
//            $this->render();
            if ($status === 'success') {
                return $this->redirect(['action' => 'account']);
            }
        }
    }

    private function _validateUsername($username, $match = null) {

    }

    /**
     * Allows users to change their password and its settings thereof
     */
    public function password()
    {
        $user = $this->getActiveUser();
        $request = $this->getRequest();

        if ($request->is('post'))
        {
            $currentPassword = $request->getData('current_password');
            $newPassword = $request->getData('new_password');
            $rePassword = $request->getData('repeat_password');

            if  (
                    ! Validation::notBlank($currentPassword) ||
                    ! Validation::notBlank($newPassword) ||
                    ! Validation::notBlank($rePassword)
            ) {
                $this->Flash->error(__('Please fill the empty field(s).'));
            } elseif (! (new DefaultPasswordHasher)->check($currentPassword, $user->password)) {
                $this->Flash->error(__('Sorry, the password you provided does not match your current password!'));
            } elseif ($newPassword !== $rePassword) {
                $this->Flash->error(__('Your new password fields do not match.'));
            } elseif (strlen($newPassword) < Configure::read('User.PASSWORD_MIN_LENGTH')) {
                $msg = sprintf("Password must be %s characters or above", Configure::read('User.PASSWORD_MIN_LENGTH'));
                $this->Flash->error(__($msg));
            } elseif (! preg_match(
                    Configure::read ('User.SECURE_PASSWORD_FORMAT'), $newPassword
                    )) {
                $msg = sprintf("Password must not be less than %s"
                        . " characters long, and must contain at least two lowercase "
                        . "letters, two uppercase letters, two numbers, two "
                        . "special characters and no white spaces", Configure::read('User.PASSWORD_MIN_LENGTH'));

                $this->Flash->error(__($msg));
            } else {
                $user = $this->Users->patchEntity($user, ['password' => $newPassword]);

                if ($this->Users->save($user)) {
                    $this->Flash->success(__('Password updated successfully.'));

                    return $this->redirect(['action' => 'password']);
                }

                $this->Flash->message(__('Sorry, your password could not be updated. Please try again'));
            }
        }

//        $this->set(compact('user'));
    }

    public function privacy()
    {

    }

    public function location()
    {
        $user = $this->getActiveUser();
        $request = $this->getRequest();
        if ($request->is('post'))
        {

        }

        $this->set(compact('user'));
    }


    public function help()
    {
        $this->autoRender = false;
        $request = $this->getRequest();
        $challenge = $request->getQuery('challenge');
        $challenges = [
            'forgot_pass' => ['controller' => 'accounts', 'action' => 'password', 'reset'],
            'forgot_username' => ['controller' => 'accounts', 'action' => 'username', 'reset'],
            'forgot_email' => ['controller' => 'accounts', 'action' => 'email', 'reset']
        ];

        foreach ($challenges as $key => $value)
        {
            if ($challenge === $key) {
                return $this->redirect($challenges[$challenge]);
            }
        }
    }

    public function blocking()
    {

    }

    public function apps()
    {

    }
}
