<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Cache\Cache;
use Cake\Core\Plugin;
use Cake\Event\Event;
use Cake\Error\Debugger;
use Cake\Core\Configure;
use Cake\Http\Response;
use Cake\Mailer\Mailer;
use Cake\Validation\Validation;
use Cake\Mailer\MailerAwareTrait;
use Cake\Datasource\ConnectionManager;
use Cake\Auth\DefaultPasswordHasher;
use App\Utility\RandomString;
use Cake\Utility\Text;
use Cake\Routing\Router;
use Cake\Http\Cookie\Cookie;
use Cake\I18n\Time;

/**
 * Auth Controller
 *
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\AccountService[] paginate($object = null, array $settings = [])
 */
class AuthController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        //$this->Auth->allow(['passwordHelp']);

        $this->Auth->allow(['index', 'checkpoint','help', 'password', 'username', 'email']);

//        $this->loadComponent('User', [
//            'user' => $this->Auth->user()
//        ]);
//        $this->loadComponent('Media');
//        $this->loadComponent('Playlist');
//        $this->loadComponent('Album');
        $this->loadComponent('CustomString');

        $this->loadModel('Users');
        $this->loadModel('UserLoginCredentials');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index() {
        $accountService = $this->paginate($this->AccountService);

        $this->set(compact('accountService'));
        $this->set('_serialize', ['accountService']);
    }

    /**
     * @return \Cake\Http\Response
     */
    public function checkpoint(): Response
    {
        $this->viewBuilder()->setLayout('ajax');
        $response = $this->getResponse();
        $state = 0;
        if ($this->Auth->user('refid')) {
            $state = 1;
        }
        $response = $response
            ->withStringBody(
                json_encode(['state' => $state])
            )
            ->withHeader('X-Authenticated', 1)
            ->withType('json');
        return $response;
    }


    /**
     * Login method
     *
     * @param void
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function login()
    {
        // In an event a user attempts to access this page while already logged
        // in, send them back to the dashboard
        if ($this->getActiveUser()) {
            return $this->redirect($this->Auth->redirectUrl());
        }

        $this->viewBuilder()->setLayout('auth_screen');

        $request = $this->getRequest();
        $response = $this->getResponse();
        $session = $request->getSession();
        $postData = ['username' => '','password' => ''];

        if ($request->is(['post', 'ajax']))
        {
            $isAjax = $request->is('ajax');
            $status = $msg = '';

            if ($isAjax)
                $this->viewBuilder()->setLayout('ajax');

            $username = $this->CustomString->sanitize($request->getData('username'));
            $password = $this->CustomString->sanitize($request->getData('password'));
            $saveLogin = (int) $request->getData('save_login');
            $request = $request->withoutData('save_login');

            if (empty($username)) {
                $status = 'error';
                $msg = 'Please input username or email';
            }
            // This part is blocked out to give way for username-only identification
            //
//            elseif (empty($password)) {
//                $status = 'error';
//                $msg = 'Please input password';
//            }
            else {
                if (Validation::email($username))
                {
                    $this->Auth->config('authenticate', [
                        'Form' => [
                            'fields' => ['username' => 'email']
                        ]
                    ]);

                    $this->Auth->constructAuthenticate();
                    $this->setRequest($request->withoutData('username')->withData('email', $username));
                }
                else
                {
                    $this->Auth->config('authenticate', [
                        'Form' => [
                            'fields' => ['username' => 'username']
                        ]
                    ]);

                    $this->Auth->constructAuthenticate();

                    // Re-assign the request data username to the validated and
                    // sanitized username
                    $this->setRequest($request->withData('username', $username));
                }

                if (! $this->__identifyUsernameAndPassword($username, $password)) {
                    if ($this->__identifyUsername($username)) {
                        $userfound = $this->Users->getUser($username);
                        $this->set(['element' => 'identified_by_username', 'userfound' => $userfound]);
//                        $requestParams = $request->getQueryParams();
//                        $requestParams += ['foo' => 'bar'];
//                        $response = $response->with(Router::url(['?'=> $requestParams]));
                    } else {
                        $status = 'error';
                        $msg = "Sorry we didn't find any user matching your details";
                    }
                } else {
                    $cookie = (new Cookie('remember_me', $saveLogin))
                            ->withPath('/')->withSecure(false)->withNeverExpire();
                    $response = $response->withCookie($cookie);
                    // Setting the session
                    $user = $this->Users->getUser($username);
                    $this->Auth->setUser($user->toArray());
                    $status = 'success';
                    $msg = 'Login successful...';

                    $event = new Event('App.User.login', $this, [
                        'user' => $user,
                        'time' => Time::now()
                    ]);
                    $this->getEventManager()->dispatch($event);
                }
            }

            if ($isAjax) {
                $feedback = json_encode(['status' => $status, 'message' => $msg]);
                $response = $response->withStringBody($feedback);
                $this->setResponse($response);

                return $response;
            }
            if ($status === 'success') {
                // Just in case the user is being redirected from another page
                // where login is mandatory, we return them to the page
                if ($request->getQuery('redirect'))
                    $url = urldecode($request->getQuery('redirect'));

                // Otherwise the default login redirect will be used
                else
                    $url = $this->Auth->redirectUrl();

                $url = Router::url($url, true);
                $response = $response->withLocation($url);
                return $response;
            }

            $postData = ['username' => $username, 'password' => $password];
        }

        $this->set('postData', $postData);
    }

    /**
     * Matches the user supplied login details against the records in the db
     * and logs the user in if identified as a valid user
     *
     * @param string $userid
     * @param string $password
     * @return \App\Model\Entity\User|boolean
     */
    private function __identifyUsernameAndPassword($userid, $password)
    {
        $user = $this->Users->getUser($userid);
        if (!$user instanceof \App\Model\Entity\User)
            return false;
        if ((new DefaultPasswordHasher)->check($password, $user->password))
            return $user;

        return false;
    }

    private function __identifyUsername($username) {
        $user = $this->Users->getUser($username);
        if (!$user instanceof \App\Model\Entity\User)
            return false;

        return $user;
    }

    public function logout()
    {
        $event = new Event('App.User.logout', $this, [
            'user' => $this->getActiveUser(),
            'time' => Time::now()
        ]);
        $this->getEventManager()->dispatch($event);
        $msg = '<h5>You are now logged out.</h5>' . "\n";
        $msg .= '<p>You will be missed... Please come back soon.</p>' . "\n";
        $this->Flash->success(__($msg), ['escape' => false]);

        return $this->redirect($this->Auth->logout() . '?logged_out=1');
    }

    /**
     * Signup Method
     *
     * @return \Cake\Http\Response|null
     */
    public function old_signup()
    {
// Prevent access to this page from logged users
        if (null !== $this->getActiveUser()) {
            return $this->redirect($this->Auth->redirectUrl());
        }
        $this->viewBuilder()->setLayout('auth_screen');

        $request = $this->getRequest();
        $session = $request->getSession();

        if (!$session->check('Signup.step') || !$session->check('NewUser')) {
            $session->write('Signup.step', 'start');
        }

        // In case the user decides to cancel account creation process, or reset
        // an already submitted data in order to make changes
        if ($request->getQuery('reset')) {
            $session->delete('Signup');
            $session->delete('NewUser');
            return $this->redirect('/' . $request->getPath());
        }

        switch ($session->read('Signup.step')) {
            case 'contact_verification':
                if ($request->getQuery('step') !== 'contact_verification')
                {
                    return $this->redirect($request->getPath()
                            . '?step=contact_verification&contact_method='
                            . $session->read('NewUser.contact_method'));
                }
                return $this->requireContactVerification();
            case 'personal_info':
                if ($request->getQuery('step') !== 'personal_info')
                    return $this->redirect($request->getPath() . '?step=personal_info');

                return $this->requirePersonalInfo();
            default:
                if ($request->getQuery('step'))
                {
                    return $this->redirect($request->getPath());
                }
                return $this->__registerNewUser();
        }
    }

    public function signup()
    {
        // Redirect the user if already logged in
        if (null !== $this->getActiveUser()) {
            return $this->redirect($this->Auth->redirectUrl());
        }

        $this->viewBuilder()->setLayout('auth_screen');

        $request = $this->getRequest();
        $response = $this->getResponse();

        $newUser = $this->Users->newEntity();
        $errors = [];
        if ($request->is(['post','ajax'])) {
            $isAjax = $request->is('ajax');
            $data = [];
            $fields = [
                'firstname' => [
                    'required' => true,
                    'min' => Configure::read('User.NAME_MIN_LENGTH'),
                    'max' => Configure::read('User.NAME_MAX_LENGTH')
                ],
                'lastname' => [
                    'required' => true,
                    'min' => Configure::read('User.NAME_MIN_LENGTH'),
                    'max' => Configure::read('User.NAME_MAX_LENGTH')
                ],
                'contact' => [
                    'required' => true,
                    'must_match' => 'email|phone'
                ],
                'username' => [
                    'required' => true,
                    'min' => Configure::read('User.USERNAME_MIN_LENGTH'),
                    'max' => Configure::read('User.USERNAME_MAX_LENGTH')
                ],
                'password' => [
                    'required' => true,
                    'match' => [
                        'regex' => Configure::read('User.SECURE_PASSWORD_FORMAT'),
                        'instruction' => sprintf("Password must not be less than %s"
                            . "characters long, and must contain at least two lowercase "
                            . "letters, two uppercase letters, two numbers, two "
                            . "special characters and no white spaces", Configure::read('User.PASSWORD_MIN_LENGTH'))
                    ]
                ]
            ];

            if ($this->__validateInputs($request->getData(), $fields, $data, $errors)) {
                $data['refid'] = RandomString::generateString(20);
                // Automatically Create a record in the profiles table
                $data['profile'] = [
                    'user_refid' => $data['refid']
                ];
                $contactType = $this->__getContactType($data['contact']);
                $data[$contactType] = $data['contact'];
                $newUser = $this->Users->patchEntity($newUser, $data);

                if ($this->Users->register($newUser)) {
                    if ($isAjax) {
                        $response = $response->withType('json')
                                ->withStringBody(json_encode([
                                    'status' => 'success'
                                ]));
                        return $response;
                    }
                    $this->Auth->setUser($newUser->toArray());
                    if ($request->getQuery('redirect'))
                        return $this->redirect ($request->getQuery ('redirect'));
                    return $this->redirect($this->Auth->redirectUrl());
                }
                $this->Flash->error(__('Oops! Looks like something went wrong... Please try again'));
            }
        }

        $this->set(compact('newUser', 'errors'));
    }

    public function password($option = null) {
//        $requestParams = $this->request->getQueryParams();
//        if (!isset($requestParams['accountChallenge'])) {
//            $this->redirect('/' . $this->request->controller . '/password-help' .
//                    '/?accountChallenge=forgot_password&process=pw_recovery&step=1&task=enter_contact');
//        }

        switch ($option)
        {
            case 'reset' :

                break;
            case '' :

                break;
            default :

        }
    }

    public function username($option = null)
    {
        $this->autoRender = false;
    }

    public function email($option = null)
    {
        $this->autoRender = false;
    }

    public function verifyContact() {
        // accountService/contact-verification/?type=email&contact=email@example.com&token=JwernorhEOqLHpmtROTUOPQTUN
        $q = $this->request->getQueryParams();
        $process = isset($q['process'])? $q['process'] : false;
        if ( $process ) {
            $method = $this->CustomString->toCamelCase( $process );
            $method = '_' . $method;
        }

        if ( isset($method) && method_exists( $this, $method ) ) {
            return $this->{$method}();
        }
    }

    private function _joinRequest() {
        $this->viewBuilder()
                ->setTemplate('contact_verification');
        $session = $this->request->getSession();
        $q = $this->request->getQueryParams();

        if ($session->check('Signup') && $session->check('Signup.contactType')) {
            $contact = $session->read('Signup.contact');
            $contactType = $session->read('Signup.contactType');
            if ($contactType === 'email') {
                $email = $contact;
                if ( $this->_sendSignupEmailVerificationMail($email) ) {
                    if ( !isset($q['msg_sent']) ) {
                        $this->redirect($this->request->here, ['msg_sent' => 1]);
                    }
                }
            } elseif ($contactType === 'phone') {
                $phone = $contact;
                $this->_sendSignupPhoneVerificationSms($phone);
            }
        }
    }

    private function _sendSignupEmailVerificationMail($email, $name) {
        $this->autoRender = false;
        $verification_link = $this->request->getAttribute('base') .
                '/accountService/verify-contact/?type=email&process=signup&token='
                . base64_encode($email.'|'. date('Y-m-d', time()));

        $message = "Hello $name, you recently requested to join "
                . Configure::read('Site.name') . "," . "using this email address"
                . " as your contact email. To proceed with the registration, "
                . "please click <a href=\"$verification_link\">here</a>. "
                . "If you are unable to click the link, you can alternatively"
                . "copy the link bellow and paste it in your browser address bar";

        //$this->Mailer->sendMail($email, $subject, $message, $headers);
        $Email = new Mailer\Email();
        $Email->setEmailFormat('html');
        $Email->setTemplate('/html/default');
        return  $Email
                ->setFrom('account-service@musicloud.com', 'Musicloud Account Service')
                ->setTo($email, $name)
                ->setSubject('Musicloud Email Verification')
                ->send($message);
    }

    private function _sendSignupPhoneVerificationSms($phone) {
        $this->set('element', 'signup_controls/sms_sent');
        $this->set('phone', $phone);
    }

    private function __registerNewUser()
    {
        $request = $this->getRequest();
        $response = $this->getResponse();
        $session = $request->getSession();

        if ($request->is(['post', 'ajax'])) {
            $isAjax = $request->is('ajax');
            $msg = '';

            if ($isAjax) {
                $this->viewBuilder()->setLayout('ajax');
            }

            if (!$request->getData('contact')) {
                $msg = 'Please input email or phone number!';

                if ($isAjax) {
                    $response = $response->withStringBody($msg);
                    return $response;
                }

                $this->Flash->error(__($msg));
            }
            else
            {
                $contact = $request->getData('contact'); // $this->CustomString->sanitize($data['contact']);

    // Validate the contact field
                $contactMethod = '';
                $email = $phone = '';
                if (is_numeric($contact)) {
                    $contactMethod = 'phone';
                    $phone = $contact;
                }
                elseif (filter_var($contact, FILTER_VALIDATE_EMAIL))
                {
                    $contactMethod = 'email';
                    $email = $contact;
                }
                else
                {
                    if ($isAjax) {
                        return $response->withStringBody('Sorry, you\'ve entered an invalid phone or email.');
                    }

                    $this->Flash->error('Sorry, you\'ve entered an invalid phone or email.');
                    return;
                }

                if ($this->Users->getUser($contact))
                {
                    $msg = ucfirst($contactMethod) . ' already in use by another '
                                    . 'account. Could this be you? Click '
                                    . '<a href="/account-services/account-recovery/?'
                                    . 'process=reclaim&id_method=' . $contactMethod . '" '
                                    . 'target="_blank">here</a> to claim your account...';
                    if ($isAjax) {
                        return $response->withStringBody($msg);
                    }
                    $this->Flash->error(__($msg), ['escape' => false]);
                }
                else
                {
                    $session->write('NewUser.email', $email);
                    $session->write('NewUser.phone', $phone);
                    $session->write('NewUser.contact_method', $contactMethod);
                    $session->write('Signup.step', 'contact_verification');
                    $code = RandomString::generateString(6);
                    $session->write('NewUser.verification_code', $code);

                    $this->_sendContactVerificationCode();
                    return $this->redirect($request->getPath() . '?step=contact_verification');
                    //return $this->redirect('/accountService/verify-contact?process=join_request');
                }
            }
        }
    }

    public function requireContactVerification()
    {
        $request = $this->getRequest();
        $response = $this->getResponse();
        $session = $request->getSession();
        $this->viewBuilder()->setTemplate('newuser_contact_verification');

        // In case the user did not receive the verification code and requests to
        // resend it
        if ($request->getQuery('resend_code') == '1') {
            $this->_sendContactVerificationCode();
            return $this->redirect($request->referer());
        }

        $code = $session->read('NewUser.verification_code');
        $contactMethod = $session->read('NewUser.contact_method');
        $this->set(compact('code', 'contactMethod'));

        // Upon submission of the verification code
        if ( $request->is(['post', 'ajax'] ) )
        {
            $isAjax = $request->is('ajax');
            $code = $request->getData('verification_code');
            $msg = '';
            $isError = false;

            if (!$code)
            {
                $isError = true;
                $msg = 'Please input verification code';
            }
            elseif ($code !== $session->read('NewUser.verification_code'))
            {
                $isError = true;
                $msg = 'You have entered an invalid code. Please input a valid code';
            }
            else
            {
                $msg = "Congratulations! Your {$session->read('NewUser.contact_method')} has been verified.";
            }

            if ($isError)
            {
                // If there is an error, then return the error message
                $response = $response->withStringBody($msg);
                if ($isAjax) {
                    return $response;
                }
                $this->setResponse ($response);
                $this->Flash->error(__($msg));

                return ;
            }
            else
            {
                // Register the next process in the session
                $session->write('NewUser.contact_verified', true);
                $session->write('Signup.step', 'personal_info');
                $response = $response->withStringBody($msg);
                $nextUrl = $request->getPath() . '?step=personal_info';

                if ($isAjax) {
                    $response = $response->withLocation($nextUrl);

                    return $response;
                }

                $this->setResponse($response);
                $this->Flash->error(__($msg));

                return $this->redirect($nextUrl);
            }
        }
    }

    public function requirePersonalInfo()
    {
        $request = $this->getRequest();
        $response = $this->getResponse();
        $session = $request->getSession();
        $this->viewBuilder()->setTemplate('newuser_personal_info');

        $usersTbl = $this->getTableLocator()->get('Users');
        $user = $usersTbl->newEntity();
        $isAjax = $request->is('ajax');

        if ( $request->is(['post', 'ajax']) )
        {
            $firstname = $request->getData('firstname');
            $lastname = $request->getData('lastname');
            $username = $request->getData('username');
            $password = $request->getData('password');
            $msg = '';


            // Empty fields validation
            if ( empty($firstname) ) {
                $msg = 'Firstname is required!';
            } elseif ( empty($lastname) ) {
                $msg = 'Lastname is required!';
            } elseif(
                    (
                    strlen($firstname) < Configure::read('User.NAME_MIN_LENGTH') ||
                    strlen($firstname) > Configure::read('User.NAME_MAX_LENGTH')
                    ) ||
                    (
                    strlen ($lastname) < Configure::read('User.NAME_MIN_LENGTH') ||
                    strlen($lastname) > Configure::read('User.NAME_MAX_LENGTH')
                    )
            ) {
                $msg = sprintf("Names cannot be lesser than %s or greater than %s characters", $this->User::NAME_MIN_LENGTH, $this->User::NAME_MAX_LENGTH);
            } elseif (is_numeric($firstname) || is_numeric($lastname)) {
                $msg = 'Names must not be numbers all through!';
            } elseif ( !$username ) {
                $msg = 'Please input username!';
            } elseif(
                    strlen($username) < Configure::read('User.USERNAME_MIN_LENGTH') ||
                    strlen($username) > Configure::read('User.USERNAME_MAX_LENGTH')
                    ) {
                $msg = sprintf("Username cannot be lessr than %s or greater than %s characters", $this->User::USERNAME_MIN_LENGTH, $this->User::USERNAME_MAX_LENGTH);
            }
// Check for existing user
            elseif ($this->Users->getUser($username)) {
                $msg = 'Sorry, username already taken!';
            } elseif ( !$password ) {
                $msg = 'Please input password';
            } elseif (strlen($password) < Configure::read('User.PASSWORD_MIN_LENGTH')) {
                $msg = sprintf("Password must be %s characters or above", Configure::read('User.PASSWORD_MIN_LENGTH'));
            } elseif (! preg_match(Configure::read('User.SECURE_PASSWORD_FORMAT'), $password)) {
                $msg = sprintf("Password must not be less than %s"
                        . "characters long, and must contain at least two lowercase "
                        . "letters, two uppercase letters, two numbers, two "
                        . "special characters and no white spaces", Configure::read('User.PASSWORD_MIN_LENGTH'));
            }

            if ( strlen($msg) > 0 )
            {
                if ($isAjax) {
                    $response = $response->withStringBody($msg);
                    return $response;
                }
                $this->Flash->error(__($msg));
            }


// If no errors are encountered, then it is time to gather all the
// data and save
            else
            {
                $firstname = $this->CustomString->sanitize($firstname);
                $lastname = $this->CustomString->sanitize($lastname);
                $username = $this->CustomString->sanitize($username);
                $password = $this->CustomString->sanitize($password);
                $email = $session->check('NewUser.email') ? $session->read('NewUser.email') : '';
                $phone = $session->check('NewUser.phone') ? $session->read('NewUser.phone') : '';
                $contactMethod = $session->read('NewUser.contact_method');
                $datetime = date('Y-m-d h:i:s');
//                $refid = $this->CustomString->generateRandom(20, ['type' => 'numbers']);
                $refid = RandomString::generateString(20);

                $userData = array(
                    'refid' => $refid,
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'username' => $username,
                    'password' => $password,
                    'email' => $email,
                    'phone' => $phone,
                    'last_login' => $datetime,
                    'created' => $datetime,
                    'modified' => $datetime
                );

                $user = $usersTbl->patchEntity($user, $userData);

                if ($usersTbl->save($user))
                {
                    if ($contactMethod === 'phone') {
                        // Write SMS Code Here...
                    } else if ($contactMethod === 'email') {
                        // Send email...
                    }

// Destroy the entire session and start a new one for this user
                    $session->delete('step');
                    $session->delete('Signup');
                    $session->delete('NewUser');
                    $user = $this->getUser($user->refid);

                    if ($user) {
                        $this->Auth->setUser($user);
                        //$user = $this->User->getProfile($user);
                        $msg = 'Congratulations... You are now on ' . $this->configure()::read('Site.name');

                        if ($isAjax) {
                            $response = $response->withStringBody($msg);
                            return $response;
                        }

                        $this->Flash->success(__($msg));
                        return $this->redirect($this->Auth->redirectUrl());
                    }
                } else {
                    $msg = 'Sorry, we\'re unable to create your account at the moment. Please, try again.';
                    if ($isAjax) {
                        $response = $response->withStringBody($msg);
                        return $response;
                    }
                    $this->Flash->error(__($msg));
                    $this->setResponse($response);
                    // return;
                }
            }
        }

        $this->set(compact('user'));
    }

    private function _sendContactVerificationCode() {
        $request = $this->getRequest();
        $session = $request->getSession();

//        $firstname = $session->read('Signup.firstname');
//        $othernames = $session->read('Signup.othernames');
//        $lastname = $session->read('Signup.lastname');
        $email = $session->read('NewUser.email');
        $phone = $session->read('NewUser.phone');
        $contactMethod = $session->read('NewUser.contact_method');
        $verificationCode = $session->check('NewUser.verification_code') ?
                $session->read('NewUser.verification_code') :
                RandomString::generateString(6);

        // Save the code for later use
        $session->write('NewUser.verification_code', $verificationCode);

        $token = RandomString::generateString(20, 'mixed');
        $verificationLink = Router::url([
            'controller' => 'account-services',
            'action' => 'contact-verification',
            'token' => $token
        ]);

        if ($contactMethod === 'email') {
            $newUser = array(
//                'firstname' => $firstname,
//                'othernames' => $othernames,
//                'lastname' => $lastname,
                'email' => $email,
                'code' => $verificationCode,
                'link' => $verificationLink
            );

            //$this->getMailer('User')->send('contactVerificationMail', [$newUser]);
        } elseif ($contactType === 'phone') {
            // Send SMS instead
        }
    }

    /**
     *
     * @param array $inputFields
     * @param array $fieldsToValidate
     * @param array $validatedData
     * @param array $errorFields
     * @return boolean
     */
    private function __validateInputs(array $inputFields, array $fieldsToValidate, array &$validatedData,  array &$errorFields)
    {
        if (empty($inputFields) || empty($fieldsToValidate)) return false;
        foreach ($fieldsToValidate as $field => $options)
        {
            if (! array_key_exists($field, $inputFields))
                    continue; // Jump to the next

            $input = $inputFields[$field];
            // Blank field validation
            if ($options['required'] === true && ! Validation::notBlank($input)) {
                $errorFields[$field] = sprintf ("%s is required!", ucfirst($field));
            }

            // Minimum length validation
            if (Validation::notBlank($input) &&
                    array_key_exists('min', $options) &&
                    strlen($input) < $options['min'])
                $errorFields[$field] = sprintf ("%s cannot be shorter than "
                        . "%s characters!", ucfirst($field), $options['min']);

            // Maximum length validation
            if (Validation::notBlank($input) &&
                    array_key_exists('max', $options) &&
                    strlen($input) > $options['max'])
                $errorFields[$field] = sprintf ("%s cannot be longer than %s"
                        . " characters!", ucfirst($field), $options['max']);

            // Match fields validation


            // Format validation by Regex
            if (array_key_exists('match', $options) &&
                    array_key_exists('regex', $options['match']) &&
                    ! preg_match($options['match']['regex'], $input))
                    $errorFields[$field] = $options['match']['instruction'];

            // If at the end of each loop, the field is not in the list of
            // fields with errors, we push it to the list of validated fields
            if (! array_key_exists($field, $errorFields))
                $validatedData[$field] = $input;
        }

        // If any field has errors, then fail all
        if (count($errorFields))
            return false;
        return true;
    }

    private function __getContactType($data)
    {
        $contactType = 'unknown';
        if (filter_var($data, FILTER_VALIDATE_EMAIL))
                $contactType = 'email';
        if (filter_var($data, FILTER_VALIDATE_INT) || is_numeric($data))
                $contactType = 'phone';

        return $contactType;
    }
}
