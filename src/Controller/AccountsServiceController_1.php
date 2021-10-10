<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Validation\Validation;
use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\Network\Exception\ForbiddenException;
use Cake\Http\Exception\BadRequestException;
use Cake\Controller\Exception\MissingActionException;
use Cake\Routing\Router;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Utility\Text;
use App\Utility\RandomString;

/**
 * AccountsService Controller
 *
 *
 * @method \App\Model\Entity\AccountsService[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AccountsServiceController extends AppController
{

    /**
     * Initialization Method
     */
    public function initialize() {
        parent::initialize();
        
        $this->Auth->allow();
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
//        $accountsService = $this->paginate($this->AccountsService);
//
//        $this->set(compact('accountsService'));
    }

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
    
    public function passwordRecovery($method = null)
    {
        if ($method === null) {
            $method = 'default';
        }
        $action = $method . 'RecoveryMethod';
        $this->viewBuilder()->setTemplate('password_recovery');
        
        return $this->setAction($action);
    }
    
    public function defaultRecoveryMethod()
    {
        $request = $this->getRequest();
        if (! $request->getQuery('task')) {
            return $this->redirect(['task' => 'account_search']);
        }
        
        $this->viewBuilder()->setTemplatePath('AccountsService' . DS . 'password');
        $task = $request->getQuery('task');
        
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
//        $this->viewBuilder()->setTemplatePath('AccountsService' . DS . 'password');
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
    
    protected function _prAccountSearch($task = null)
    {
        $request = $this->getRequest();
        $response = $this->getResponse();
        $session = $request->getSession();
        
        if ( ! $task ) {
            $task = $request->getQuery('task');
        }
        
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
                
                return $this->redirect(['task' => 'account_confirmation']);
            } else {
                $message = '<div class="alert alert-message">Ooops! We couldn\'t find any account with that ' . $contactMethod . '</div>';
            }
        }
        
        $this->set(compact('message'));
    }
    
    protected function _prAccountConfirmation()
    {
        $request = $this->getRequest();
        $session = $request->getSession();
        if (! $session->check('PasswordRecovery.matched_account')) {
            $this->Flash->default(__('Oops! No account to confirm'));
            return $this->redirect(['task' => 'account_search']);
        }
        
        $matchedAccount = $session->read('PasswordRecovery.matched_account');
        if ($request->getQuery('feedback') === 'accepted') 
        {
            $contactMethod = $session->read('PasswordRecovery.contact_method');
            $resetCode = RandomString::generateString();
            //$resetLink = Router::url(['controller' => 'AccountsService', 'action' => 'password-reset', 'method' => $contactMethod, '_token' => base64_encode(microtime())]);
            // $token = $this->CustomString->generateRandom(32);
            $token = RandomString::generateString(32, 'mixed');
            $resetLink = Router::url('/accounts-service/password-recovery/email-verification/' . $token);
            $session->write('PasswordRecovery.code', $resetCode);
            $session->write('PasswordRecovery.link', $resetLink);
            $session->write('PasswordRecovery.token', $token);
            
//            try {
//                $this->recordPasswordResetRequest($matchedAccount, $token);
//            } catch (Cake\ORM\Exception $ex) {
//                throw new Cake\ORM\Exception();
//            }
            
            if ($contactMethod === 'email') {
                // Try sendig a mail to the user's email address
                
            } elseif ($contactMethod === 'sms') {
                // Try sending a sms to the user's phone
            } elseif ($contactMethod === 'call') {
                // Try putting a call through to the user's phone
            }
            
            return $this->redirect(['task' => 'code_verification']);
        }
        elseif ($request->getQuery('feedback') === 'rejected') 
        {
            return $this->redirect(['alternative']);
        }
        
        $this->set(compact('matchedAccount'));
    }
    
    protected function _prCodeVerification()
    {
        $request = $this->getRequest();
        $response = $this->getResponse();
        $session = $request->getSession();
        
        if ($request->is('ajax')) {
            $this->viewBuilder()->setLayout('ajax');
            $this->autoRender = false;
        }
        if (! $session->check('PasswordRecovery.code')) {
            $status = 'error';
            $message = 'Oops! Something\'s not right... Our engineers will be notified of this issue. It will be fixed as soon as possible.';
            
            if ($request->is('ajax')) {
                $json = \json_encode(['status' => $status, 'message' => $message]);
                $response = $response->withType('json')->withStringBody($json);
                return $response;
            } else {
                $this->Flash->error(__($message));
                return $this->redirect($request->referer());
            }
        }

        $matchedAccount = $session->read('PasswordRecovery.matched_account');
        $code = (int) $session->read('PasswordRecovery.code');
        $link = $session->read('PasswordRecovery.link');
        $token = $session->read('PasswordRecovery.token');
        
        if ($request->is('post')) {
            $postedCode = (int) $request->getData('code');
            
            if ($postedCode !== $code) {
                $status = 'error';
                $message = 'Invalid Code!';
            } else {
                $status = 'success';
                $message = 'Verified';
                $session->write('PasswordRecovery.code_verified', true);
            }
            $redirectUri = Router::normalize(
                            [ 
                                'action' => 'password-reset'
                            ]);
            
            if ($request->is('ajax')) {
                $data = [
                    'status' => $status,
                    'message' => $message,
                    'redirectUri' => $redirectUri
                ];
                $jsonData = \json_encode($data);
                $response = $response->withType('json')->withStringBody($jsonData);
                return $response;
            } else {
                $this->Flash->success(__($message));
                return $this->redirect($redirectUri);
            }
        }
        
        
        $this->set(compact('message', 'code', 'matched_account'));
    }
    
    public function passwordReset($token = null)
    {
        $request = $this->getRequest();
        $response = $this->getResponse();
        $session = $request->getSession();
        if ($request->is('ajax')) {
            $this->viewBuilder()->setLayout('ajax');
        }
        
        $this->viewBuilder()->setTemplate('password\password_reset');
        
        if (!$session->check('PasswordRecovery.code') && $token === null) {
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
                $pwHasher = new DefaultPasswordHasher();
                $password = $pwHasher->hash($newPass);
                $user = ($session->check('PasswordRecovery.matched_account') ? 
                        $session->read('PasswordRecovery.matched_account') : 
                    $this->getUser($this->findPasswordRecoveryRequest($token)->user_refid));
                if (! $user) {
                    
                }
                $user = $this->Users->patchEntity($user, ['password' => $password]);
                
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
}
