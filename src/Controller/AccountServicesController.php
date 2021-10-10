<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Datasource\ResultSetInterface;
use Cake\Event\EventInterface;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\Validation\Validation;
use Cake\Core\Configure;
use Cake\Http\Exception\BadRequestException;
use Cake\Controller\Exception\MissingActionException;
use Cake\Routing\Router;
use App\Utility\CustomString;
use App\Utility\RandomString;

/**
 * AccountServices Controller
 *
 *
 * @method AccountServices[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class AccountServicesController extends AppController
{

    const USERNAME_PATTERN = '/^[A-Za-z][A-Za-z0-9]*(?:__[A-Za-z0-9]+)*(?:_[A-Za-z0-9]+)*$/';

    /**
     * Initialization Method
     * @param EventInterface $event
     */

    public function beforeFilter(EventInterface $event): void
    {
        parent::beforeFilter($event);

        $this->Auth->allow();
    }

//    public function beforeFilter(Event $event) {
//
//    }

    /**
     * Index method
     *
     * @return Response|void
     */
    public function index()
    {
//        $accountsService = $this->paginate($this->AccountServices);
//
//        $this->set(compact('accountsService'));
    }

    /**
     * @return mixed
     */
    public function password()
    {
        $request = $this->getRequest();
        $tpl = 'password';

        if ( ! empty($request->getQuery('challenge')) ) {
//            $this->redirect('/' . $this->request->controller . '/password-help' .
//                    '/?challenge=forgot_password&process=pw_recovery&step=1&task=enter_contact');
            $challenge = $request->getQuery('challenge');
            switch ($challenge)
            {
                case 'forgot_pw' :
//                    $tpl = 'password_recovery';
                    return $this->setAction('recoverPassword');
                    break;
                case 'pw_compromised' :
//                    $tpl = 'compromised_password';
                    return $this->setAction('compromisedAccount');
                    break;
                case 'trouble_logging_in' :
//                    $tpl = 'trouble_logging_in';
                    return $this->setAction('unableToLogin');
                    break;
                default :
//                    $tpl = 'specific_challenge';
                    return $this->setAction('perculiarProblem');
            }
        }

        //$this->viewBuilder()->setTemplate($tpl);
    }

    public function passwordRecovery($step = null)
    {
        $request = $this->getRequest();
        if ($step === null) {
            $step = 'account-search';
        }

        $step = new CustomString($step);

        $action = 'passwordRecovery' . ucfirst($step->toCamelCase());
        if (! $this->hasAction($action)) {
            if (Configure::read('debug')) {
                throw new MissingActionException();
            }
            throw new NotFoundException();
        }

        $this->viewBuilder()->setTemplatePath('AccountServices' . DS . 'password');
        $this->viewBuilder()->setTemplate('password_recovery');
        $this->set(['step' => $step->underscore()]);
        return $this->setAction($action);
    }

    public function defaultRecoveryMethod()
    {


        $taskHandler = '_pr' . ucfirst($this->CustomString->toCamelCase($task));
        $this->set(compact('task'));

        try {
            $this->{$taskHandler}();
        } catch (MissingActionException $ex) {
            if (Configure::read('debug')) {
                throw new MissingActionException($ex);
            }
            throw new NotFoundException();
        }
    }


    public function alternativeRecoveryMethod()
    {
        $request = $this->getRequest();
//        if (!$request->getQuery('step') || ! $request->getQuery('task')) {
//            return $this->redirect(['step' => 1, 'task' => 'account_search']);
//        }
//
//        $this->viewBuilder()->setTemplatePath('AccountServices' . DS . 'password');
//        $task = $request->getQuery('task');
//
//        $taskHandler = '_pr' . ucfirst($this->CustomString->toCamelCase($task));
//        try {
//            $this->{$taskHandler}();
//        } catch (MissingActionException $ex) {
//            if (Configure::read('debug')) {
//                throw new MissingActionException($ex);
//            }
//            throw new NotFoundException();
//        }

        $this->set(compact('task'));
    }


    public function compromisedAccount()
    {

    }

    public function troubleLoggingIn()
    {

    }

    public function perculiarProblem()
    {

    }

    public function passwordRecoveryAccountSearch()
    {
        $request = $this->getRequest();
        $response = $this->getResponse();
        $session = $request->getSession();

        $message = '';
        if ($request->is('ajax')) {
            $this->viewBuilder()->setLayout('ajax');
        }
        if ($request->is('post'))
        {
            $credential = $request->getData('contact');

            if (filter_var($credential, FILTER_VALIDATE_EMAIL)) {
                $contactMethod = 'email';
            } elseif (is_numeric($credential)) {
                $contactMethod = 'phone';
            } else {
                $contactMethod = 'username';
            }

            $userFound = false;

            if (
                    Validation::email($credential) ||
                    Validation::numeric($credential) ||
                    is_string($credential)) {
                $userFound = $this->User->getUser($credential);
            }
            if ($userFound) {
//                $message = '<div class="alert alert-success">Your search matched the following account. Is this you?</div>';
                $session->write('PasswordRecovery.matched_account', $userFound);
                $session->write('PasswordRecovery.contact_method', $contactMethod);

                return $this->redirect(['account-confirmation']);
            } else {
                $message = '<div class="alert alert-message">Ooops! We couldn\'t find any account with that ' . $contactMethod . '</div>';
            }
        }

        $this->set(compact('message'));
    }

    public function passwordRecoveryAccountConfirmation()
    {
        $request = $this->getRequest();
        $session = $request->getSession();
        if (! $session->check('PasswordRecovery.matched_account')) {
            $this->Flash->default(__('Oops! No account to confirm'));
            return $this->redirect(['account-search']);
        }

        $matchedAccount = $session->read('PasswordRecovery.matched_account');

        $this->set(compact('matchedAccount'));
    }

    public function passwordRecoveryCodeVerification()
    {
        $request = $this->getRequest();
        $response = $this->getResponse();
        $session = $request->getSession();

        if ($request->is('ajax')) {
            $this->viewBuilder()->setLayout('ajax');
            $this->autoRender = false;
        }

        // Ensure the password recovery session is still active
        if (! $session->check('PasswordRecovery') || ! $session->check('PasswordRecovery.matched_account')) {
            $status = 'error';
            $message = 'Oops! Something\'s not right... Our engineers will be '
                    . 'notified of this issue. It will be fixed as soon as '
                    . 'possible. Try searching for your account again...';

            if ($request->is('ajax')) {
                $json = json_encode(['status' => $status, 'message' => $message]);
                $response = $response->withType('json')->withStringBody($json);
                return $response;
            } else {
                $this->Flash->error(__($message));
                return $this->redirect(['account-search']);
            }
        }

        $contactMethod = $session->read('PasswordRecovery.contact_method');

        if ($session->check('PasswordRecovery.code')) {
            $code = $session->read('PasswordRecovery.code');
        } else {
            $code = RandomString::generateString();
        }
        if ($session->check('PasswordRecovery.token')) {
            $token = $session->read('PasswordRecovery.token');
        } else {
            $token = RandomString::generateString(32, 'mixed');
        }

        $link = Router::url('/accounts-service/password-recovery/email-verification/' . $token);
        $session->write('PasswordRecovery.code', $code);
        $session->write('PasswordRecovery.link', $link);
        $session->write('PasswordRecovery.token', $token);

        $matchedAccount = $session->read('PasswordRecovery.matched_account');
//        $code = (int) $session->read('PasswordRecovery.code');
//        $link = $session->read('PasswordRecovery.link');
//        $token = $session->read('PasswordRecovery.token');

        if ($request->is('post')) {
            $postedCode = (int) $request->getData('code');

            if ($postedCode !== (int) $code) {
                $status = 'error';
                $message = 'Invalid Code!';
            } else {
                $status = 'success';
                $message = 'Verified';
                $session->write('PasswordRecovery.code_verified', true);
            }
            $redirectUri = Router::normalize(['action' => 'new-password']);

            if ($request->is('ajax')) {
                $data = [
                    'status' => $status,
                    'message' => $message,
                    'redirectUri' => $redirectUri
                ];
                $jsonData = json_encode($data);
                $response = $response->withType('json')->withStringBody($jsonData);
                return $response;
            } else {
                $this->Flash->success(__($message));
                return $this->redirect($redirectUri);
            }
        }


        $this->set(compact('message', 'code', 'matched_account'));
    }

    public function passwordRecoveryEmailVerification()
    {

    }


    public function newPassword($token = null)
    {
        $request = $this->getRequest();
        $response = $this->getResponse();
        $session = $request->getSession();
        if ($request->is('ajax')) {
            $this->viewBuilder()->setLayout('ajax');
        }

        $this->viewBuilder()->setTemplate('password\new_password');

        if (! $session->check('PasswordRecovery.code') && $token === null) {
            $this->Flash->error(__('Oops! Something went wrong. Please try again.'));
            return $this->redirect(['action' => 'password-recovery']);
        }
        elseif ($token) {
            $passwordRecoveryRequest = $this->findPasswordRecoveryRequest($token);
            if (! $passwordRecoveryRequest ) {
                throw new BadRequestException('Invalid request. You must have followed a broken link or the link has expired.');
            }
        } elseif (
                $session->check('PasswordRecovery.code') &&
                $session->read('PasswordRecovery.code_verified') !== true
        )
        {
            $this->Flash->error(__('No verification code provided! Please verify your request by entering the code that was sent to you.'));
            return $this->redirect(['action' => 'password-recovery', 'task' => 'code_verification']);
        }
        if ($request->is('post')) {
            $newPass = $request->getData('new_password');
            $confirmNewPass = $request->getData('confirm_new_password');

            if ($confirmNewPass !== $newPass) {
                $status = 'error';
                $message = 'Both passwords do not match';
            } else {
//                $password = (new DefaultPasswordHasher)->hash($newPass);
                $user = ($session->check('PasswordRecovery.matched_account') ?
                        $session->read('PasswordRecovery.matched_account') :
                    $this->getUser($this->findPasswordRecoveryRequest($token)->user_refid));
                if (! $user) {
                    throw new BadRequestException();
                }
                $this->loadModel('Users');
                $user = $this->Users->patchEntity($user, ['password' => $newPass]);

                if ($this->Users->save($user)) {
                    $status = 'success';
                    $message = 'Password successfully changed.';
                }
            }

            if ($request->is('ajax')) {
                $data = json_encode([
                    'status' => $status,
                    'message' => $message,
                    'redirectUrl' => Router::normalize(['controller' => '/', 'action' => 'login'])
                    ]);
                $response = $response->withType('json')->withStringBody($data);

                return $response;
            } else {
                $this->Flash->default(__('Login with your new password'));
                return $this->redirect(['controller' => '/', 'action' => 'login']);
            }
        }
    }

    public function accountActivation() {
        $user = $this->Auth->user();
        if (NULL !== $user) {
            if ((int) $user->active === 1) {
                $this->Flash->default(__('Your account is already activated'));
                return $this->redirect('/accountService');
            }
        }
    }

    public function help($option = null)
    {
        if ($option) {
            $this->viewBuilder()->setTemplate($option);
            try {
                return $this->setAction($option);
            } catch (MissingActionException $ex) {
                if (Configure::read('debug')) {
                    throw new MissingActionException($ex);
                }
                throw new NotFoundException();
            }
        }
    }

    public function usernameValidation()
    {
        $request = $this->getRequest();
        $isAjax = $request->is('ajax');
        if ($isAjax) {
            $this->autoRender = false;
            $this->viewBuilder()->setLayout('ajax');
        }
        if ($request->is('post')) {
            $user = $this->getActiveUser();
            $currentUsername = $user->getUsername();
            $newUsername = $request->getData('entry');
            $status = $description = null;
            if (false === Validation::notBlank($newUsername)) {
                $status = 'error';
                $message = 'empty_field';
                $description = 'Please input username';
            } elseif (Validation::equalTo(strtolower($newUsername), strtolower($currentUsername))) {
                $status = 'success';
                $message = 'no_changes';
                $description = 'No changes made';
            } elseif (false === Validation::custom($newUsername, self::USERNAME_PATTERN)) {
                $status = 'error';
                $message = 'invalid_characters';
                $description = 'Invalid character found in username. Only letters and numbers are allowed.';
            } elseif (true === $this->Users->getUser($newUsername)) {
                $status = 'error';
                $message = 'taken';
                $description = 'Username already taken';
            } elseif (false === Validation::lengthBetween($newUsername, 3, 15)) {
                $status = 'error';
                $message = 'out_of_range';
                $description = 'Username must be between 3-15 characters long';
            } elseif (Validation::inList ($newUsername, Configure::read('Site.reservedWords'), true)) {
                $status = 'error';
                $message = 'not_allowed';
                $description = 'Sorry, but you are not allowed to use this word as username. It is part of the ' . Configure::read('Site.name') . ' reserved words';
            } else {
                $status = 'success';
                $message = 'available';
                $description = '';
            }

            if ($isAjax) {
                $msg = json_encode([
                    'status' => $status,
                    'message' => $message,
                    'description' => $description
                ]);
                $response = $this->getResponse();
                $response = $response->withType('json')->withStringBody($msg);
                return $response;
            }

            $this->Flash->{$status}(__($description));
            $this->render();
        }
    }

    public function lookup() {
        $request = $this->getRequest();
        $response = $this->getResponse();
        $request->allowMethod('post');

        $table = $request->getData('t');
        $field = $request->getData('f');
        $detail = $request->getData('d');

        $Table = $this->getTableLocator()->get($table);
        if ($Table->exists([
            $field => $detail
        ])) {
            $response = $response->withStringBody('exists');
        } else {
            $response = $response->withStringBody('not_exists');
        }

        return $response;
    }

    public function checkSession()
    {
        $response = $this->getResponse();
        $account = [];
        $this->getRequest()->allowMethod('ajax');
        if (! $this->getActiveUser()) {
            $account = [];
        } else {
            $account = [
                'username' => $this->getActiveUser()->getUsername(),
                'email' => $this->getActiveUser()->getPrimaryEmail()
            ];
        }
        $str = json_encode($account);
        $response = $response->withStringBody($str);

        return  $response;
    }

    public function fetchPhotos($user = null) {
        $request = $this->getRequest();
        $response = $this->getResponse();
        $isAjax = $request->is('ajax');
        $user = $this->getActiveUser();

        if ($isAjax)
            $this->viewBuilder()->setLayout ('ajax');
        $this->viewBuilder()
                ->setTemplatePath('Photos')
                ->setTemplate('photo_selector');
        $photosTbl = $this->getTableLocator()->get('Photos');
        $photos = $photosTbl->findByAuthorRefid($user->refid);
        $photos = $this->paginate($photos);
        $photos->toArray();

        $this->set(compact('photos', ['_serialize' => 'photos']));
    }
}
