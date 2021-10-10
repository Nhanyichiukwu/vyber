<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Mailer;
use Cake\Mailer\MailerAwareTrait;
use Cake\ORM\Locator\TableLocator;

/**
 * Registration component
 */
class UserAccessControlComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    
    public $components = ['User', 'CustomString', 'Auth'];


    public function initialize(array $config) {
        parent::initialize($config);
        
        $tableLocator = new TableLocator();
        $this->Users = $tableLocator->get('Users');
        $this->UserAuthenticators = $tableLocator->get('UserAuthenticators');
    }
    
    public function registerNewUser()
    {
        $controller = $this->getController();
        $request = $controller->getRequest();
        $response = $controller->getResponse();
        $session = $request->getSession();

        if ($request->is(['post', 'ajax'])) {
            $isAjax = $request->is('ajax');
            $msg = '';

            if ($isAjax) {
                $controller->viewBuilder()->setLayout('ajax');
            }

            if (!$request->getData('contact')) {
                $msg = 'Please input email or phone number!';
                
                if ($isAjax) {
                    $response = $response->withStringBody($msg);
                    return $response;
                }
                
                $controller->Flash->error(__($msg));
                return;
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

                    $controller->Flash->error('Sorry, you\'ve entered an invalid phone or email.');
                    return;
                }
                
                if ($this->User->infoInUse($contact)) 
                {
                    $msg = ucfirst($contactMethod) . ' already in use by another '
                                    . 'account. Could this be you? Click '
                                    . '<a href="/accountService/account-recovery/?'
                                    . 'process=reclaim&id_method=' . $contactMethod . '" '
                                    . 'target="_blank">here</a> to claim your account...';
                    if ($isAjax) {
                        return $response->withStringBody($msg);
                    }
                    $controller->Flash->error(__($msg), ['escape' => false]);
                }
                else
                {
                    // Store the data temporarily in the session for later use
        //            $session->write('NewUser.firstname', $firstname);
        //            $session->write('NewUser.middlename', $middlename);
        //            $session->write('NewUser.lastname', $lastname);
                    $session->write('NewUser.email', $email);
                    $session->write('NewUser.phone', $phone);
                    $session->write('NewUser.contact_method', $contactMethod);
                    $session->write('Signup.step', 'contact_verification');
                    $code = $this->CustomString->generateRandom(6, ['type' => 'numbers']);
                    $session->write('NewUser.verification_code', $code);

                    $this->_sendContactVerificationCode();
                    return $controller->redirect( $request->getPath() . '?step=contact_verification');
                    //return $this->redirect('/accountService/verify-contact?process=join_request');
                }
            }
        }
    }
    
    public function requireContactVerification()
    {
        $controller = $this->getController();
        $request = $controller->getRequest();
        $response = $controller->getResponse();
        $session = $request->getSession();
        $controller->viewBuilder()->setTemplate('newuser_contact_verification');
        
        // In case the user did not receive the verification code and requests to 
        // resend it
        if ($request->getQuery('resend_code') == '1') {
            $this->_sendContactVerificationCode();
            return $controller->redirect($request->referer());
        }
        
        $code = $session->read('NewUser.verification_code');
        $contactMethod = $session->read('NewUser.contact_method');
        $controller->set(compact('code', 'contactMethod'));
        
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
                    $controller->setResponse ($response);
                    $controller->Flash->error(__($msg));
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
                
                $controller->setResponse($response);
                $controller->Flash->error(__($msg));
                
                return $controller->redirect($nextUrl);
            }
        }
    }
    
    public function requirePersonalInfo()
    {
        $controller = $this->getController();
        $request = $controller->getRequest();
        $response = $controller->getResponse();
        $session = $request->getSession();
        $controller->viewBuilder()->setTemplate('newuser_personal_info');
        
        $user = $this->Users->newEntity();
        $isAjax = $this->request->is('ajax');

        if ( $this->request->is(['post', 'ajax']) ) 
        {
            $firstname = $request->getData('firstname');
            $lastname = $request->getData('lastname');
            $personality = $request->getData('personality');
            $username = $request->getData('username');
            $password = $request->getData('password');
            $msg = '';
            $name_min_len = 2;
            $name_max_len = 45;
            $username_min_len = 3;
            $username_max_len = 15;
            $pass_min_len = 6;
            $secure_pass_format = '/^[a-zA-Z0-9@#*^&%?}{[]$-:;]/';
            
            // Empty fields validation
            if ( !$firstname ) 
            {
                $msg = 'Firstname required!';
            } 
            elseif( strlen ($firstname) < $name_min_len || strlen($firstname) > $name_max_len ) 
            {
                $msg = "Names cannot be lesser than $name_min_len or greater than $name_max_len characters";
            } 
            elseif ( !$lastname ) 
            {
                $msg = 'Lastname required!';
            } 
            elseif( strlen ($lastname) < $name_min_len || strlen($lastname) > $name_max_len ) 
            {
                $msg = "Names cannot be lesser than $name_min_len or greater than $name_max_len characters";
            } 
            elseif (is_numeric($firstname) || is_numeric($lastname))
            {
                $msg = 'Names must not be numbers all through!';
            }
            elseif ( !$personality )
            {
                $msg = 'Please specify your personality!';
            }
            elseif ( !$username ) 
            {
                $msg = 'Please create your username!';
            } 
            elseif( strlen ($username) < $username_min_len || strlen($username) > $username_max_len) 
            {
                $msg = "Username cannot be lessr than $username_min_len or greater than $username_max_len characters";
            }
// Check for existing user
            elseif ($this->User->infoInUse($username)) {
                $msg = 'Sorry, username already taken!';
            }
            elseif ( !$password ) 
            {
                $msg = 'Please input password';
            } 
            elseif( strlen ($password) < $pass_min_len ) 
            {
                $msg = "Password must be $pass_min_len characters or above";
            }
//            elseif (!preg_match($secure_pass_format, $password))
//            {
//                $msg = 'Plassword must contain at least one special character, a number and a capital letter';
//            }
            
            if ( strlen($msg) > 0 )
            {
                if ($isAjax) {
                    $response = $response->withStringBody($msg);
                    return $response;
                }
                $controller->Flash->error(__($msg));
                //return;
            }


// If no errors are encountered, then it is time to gather all the 
// data and save
            else 
            {
                $firstname = $this->CustomString->sanitize($firstname);
                $lastname = $this->CustomString->sanitize($lastname);
                $personality = $this->CustomString->sanitize($personality);
                $username = $this->CustomString->sanitize($username);
                $password = $this->CustomString->sanitize($password);
                $email = $session->check('NewUser.email') ? $session->read('NewUser.email') : '';
                $phone = $session->check('NewUser.phone') ? $session->read('NewUser.phone') : '';
                $contactMethod = $session->read('NewUser.contact_method');
                $datetime = date('Y-m-d h:i:s');
                $user_id = $this->CustomString->generateRandom(16);
                $userData = array(
                    'user_id' => $user_id,
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'email' => $email,
                    'phone' => $phone,
                    'created' => $datetime,
                    'modified' => $datetime,
                    'user_authentication' => [
                        'user_id' => $user_id,
                        'email' => $email,
                        'phone' => $phone,
                        'username' => $username,
                        'password' => $password
                    ]
                );

                $user = $this->Users->newEntity($userData, ['associated' => 'UserAuthenticators']);

                if ($this->Users->save($user)) {
//                    $authenticationData = [
//                        'user_id' => $user_id,
//                        'email' => $email,
//                        'phone' => $phone,
//                        'username' => $username,
//                        'password' => $password
//                    ];
                    // Notify the administrator about the event.
//                        $event = 'signup';
//                        $msgToAdmin = $userData['firstname'] . ' ' . $userData['lastname'];
//                        $this->notifyAdminAboutThisEvent($event, $msgToAdmin);
                    // If no errors, send a mail or sms to the contact provided, depending on the contact type
                    if ($contactMethod === 'phone') {
                        // Write SMS Code Here...
                    } else if ($contactMethod === 'email') {
                        // Send email...
                    }

// Destroy the entire session and start a new one for this user
                    $session->delete('Signup');
                    $session->delete('NewUser');
                    $user = $this->User->getInfo($user->ref_id);

                    if ($user) {
                        $user = $this->User->getProfile($user);
                        $this->Auth->setUser($user);
                        $msg = 'Congratulations... You are now on ' . \Cake\Core\Configure::read('Site.name');
                        $controller->Flash->default(__($msg));
                        if ($isAjax) {
                            $response = $response->withStringBody($msg);
                            return $response;
                        }
                        $response = $response->withLocation('/');
                        $controller->setResponse($response);
                        //return;
                    }
                } else {
                    $msg = 'Sorry, we\'re unable to create your account at the moment. Please, try again.';
                    $controller->Flash->error(__($msg));
                    if ($isAjax) {
                        $response = $response->withStringBody($msg);
                        return $response;
                    }
                    $controller->setResponse($response);
                    // return;
                }
            }
        }
        
        $controller->set(compact('user'));
    }
    
    private function _sendContactVerificationCode() {
        $request = $this->getController()->getRequest();
        $session = $request->getSession();
        
//        $firstname = $session->read('Signup.firstname');
//        $middlename = $session->read('Signup.middlename');
//        $lastname = $session->read('Signup.lastname');
        $email = $session->read('NewUser.email');
        $phone = $session->read('NewUser.phone');
        $contactMethod = $session->read('NewUser.contact_method');
        $verificationCode = $session->check('NewUser.verification_code') ?
                $session->read('NewUser.verification_code') :
                $this->CustomString->generateRandom(6, ['type' => 'numbers']);

        // Save the code for later use
        $session->write('NewUser.verification_code', $verificationCode);

        $verificationLink = $request->getAttribute('base') .
                '/accountService/verify-contact/';
        $query = http_build_query([
            'type' => 'email',
            'process' => 'signup',
            'token' => base64_encode($email . '|' . date('Y-m-d', time()))
        ]);
        $verificationLink .= '?' . $query;

        if ($contactMethod === 'email') {
            $newUser = array(
//                'firstname' => $firstname,
//                'middlename' => $middlename,
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
}
