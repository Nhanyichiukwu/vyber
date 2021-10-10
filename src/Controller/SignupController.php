<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use App\Utility\RandomString;
use Cake\Controller\Exception\MissingActionException;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Event\EventInterface;
use Cake\Http\Exception\BadRequestException;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\I18n\Date;
use Cake\I18n\Time;
use Cake\Routing\Router;
use Cake\Utility\Inflector;
use Cake\Validation\Validation;

/**
 * SignupController Controller
 *
 *
 * @method \App\Model\Entity\SignupController[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 * @property \App\Controller\Component\VerificationServiceProviderComponent $VerificationServiceProvider
 */
class SignupController extends AppController
{

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        $this->Auth->allow();
        $this->viewBuilder()
            ->setTemplatePath('Auth' . DS . 'signup')
            ->setLayout('auth');
//        $this->set(['hasHeader','hasFooter'],[false,false]);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        // Redirect the user if already logged in
        if ($this->AuthServiceProvider->isAuthenticated()) {
            return $this->redirect($this->Auth->redirectUrl());
        }

        $request = $this->getRequest();
        $errors = $credentials = [];
        if ($request->is(['post','ajax'])) {
            $isAjax = $request->is('ajax');
            $credentials = $request->getData();
            $options = [
                'requiredFields' => ['contact','accept_terms'],
                'expectedValues' => [
                    'accept_terms' => [
                        'value' => 'accept',
                        'message' => 'Sorry, but your request was aborted because you did not accept the terms of service'
                    ]
                ]
            ];
            if ($this->AuthServiceProvider->validate('signup', $options)) {
                $contact = (string) $this->AuthServiceProvider->getFormData('contact');
                $contactType = $this->AuthServiceProvider->getDataType($contact);
                $afterVerifyAction = (string) Router::url([
                    // 'controller' => 'TheCurrentController',
                    'action' => 'personal-info',
                    '?' => [
                        'contact_verified' => '1',
                        'after_auth_redirect' => $request->getQuery('after_auth_redirect')
                    ]
                ], true);

                $nextAction = Router::url([
                    'controller' => 'ContactVerification',
                    'action' => 'send-code',
                    "$contact",
                    '?' => [
                        'process' => 'signup',
                        'type' => $contactType,
                        'after_verify_redirect' => urlencode($afterVerifyAction)
                    ]
                ], true);

                $request->getSession()->write('process', 'signup');

                if ($isAjax) {
                    $result = [
                        'url' => $nextAction
                    ];
                    $response = $this->getResponse()->withStringBody(json_encode($result));
                    return $response;
                }

                return $this->redirect($nextAction);
            }

            $errors += $this->AuthServiceProvider->getErrors();
            foreach ($errors as $field => $error) {
                foreach ($error as $code => $msg) {
                    $this->Flash->error(__($msg));
                }
            }
        }

        $this->set(compact('errors', 'credentials'));
    }


    public function personalInfo()
    {
        $request = $this->getRequest();
        if (!$request->getSession()->check('process') ||
            !$this->VerificationServiceProvider->check('verified')) {
            $this->Flash->error(__('Oops! Your session has expired or you may have followed a dead link'));
            return $this->redirect(['controller' => 'login']);
        }
        $errors = [];
        $credentials = [];
        $registeringUser = $this->Users->newEmptyEntity();
        if ($request->is(['post','ajax'])) {
            $isAjax = $request->is('ajax');
            $credentials = $request->getData();
            $requiredFields = ['lastname','firstname','username','password','confirm_password'];
            if ($this->AuthServiceProvider->validate('signup', [
                'requiredFields' => $requiredFields
            ])) {
                $contact = (string) $this->VerificationServiceProvider->readPreviouslyVerified('contact');
                $contactType = $this->AuthServiceProvider->getDataType($contact);
                $timestamp = Date::now();
                $contactVerifiedAt = $this->VerificationServiceProvider->getVerificationTime();
                $password = $this->AuthServiceProvider->getFormData('password');
                $password2 = $this->AuthServiceProvider->getFormData('confirm_password');
                if (!Validation::equalTo($password, $password2)) {
                    $errors += ['confirm_password' => 'Password mismatch. Your password confirmation does not match the first one '];
                } else {
                    $userRefid = RandomString::generateString(20);
                    $contactTypeIdentifiers = [
                        'email' => 'address',
                        'phone' => 'number'
                    ];
                    $data = [
                        'refid' => $userRefid,
                        'lastname' => $this->AuthServiceProvider->getFormData('lastname'),
                        'firstname' => $this->AuthServiceProvider->getFormData('firstname'),
                        'othernames' => $this->AuthServiceProvider->getFormData('other_names'),
                        'username' => $this->AuthServiceProvider->getFormData('username'),
                        'gender' => $this->AuthServiceProvider->getFormData('gender'),
                        'date_of_birth' => $this->AuthServiceProvider->getFormData('date_of_birth'),
                        'password' => $password,
                        "{$contactType}s" => [
                            [
                                'refid' => RandomString::generateString(20),
                                'user_refid' => $userRefid,
                                "$contactTypeIdentifiers[$contactType]" => $contact,
                                "is_primary" => '1'
                            ]
                        ],
                        "profile" => [
                            'user_refid' => $userRefid
                        ],
                        "contact_verified_at" => $contactVerifiedAt
                    ];

                    $registeringUser = $this->Users->patchEntity($registeringUser, $data);

                    if ($this->Users->save($registeringUser)) {
                        $latestUser = $this->Users->get(
                            $registeringUser->refid,
                            [
                                'contain' => (array)$this->User->getBasicContainables(
                                    $registeringUser->refid
                                )
                            ]
                        );

                        $event = new Event('App.User.NewUser', $this, [
                            'user' => $latestUser,
                            'datetime' => Time::now()
                        ]);
                        $this->getEventManager()->dispatch($event);

                        $this->getRequest()->getSession()->destroy();
                        $this->Auth->setUser($latestUser->toArray());

                        // If the user was being redirected here for authentication,
                        // then we should inform the next handler
                        if ($request->getQuery('after_auth_redirect')) {
                            $nextAction = urldecode($request->getQuery('after_auth_redirect'));
                            return $this->redirect($nextAction);
                        }
                        return $this->redirect($this->Auth->redirectUrl());
                    }
                }
                $errors += $registeringUser->getErrors();
            }
            $errors += $this->AuthServiceProvider->getErrors();
        }

        $this->set(compact('errors', 'credentials'));
    }


    protected function accountProtection()
    {
        $request = $this->getRequest();
        $errors = [];
        $credentials = [];
        if (!$request->getSession()->check('verifiedUser')) {
            throw new BadRequestException('Bad Request! You may have followed a dead link, or you are attempting to access this page without due process.');
        }
        $session = $request->getSession();
        $verifiedUser = $session->read('verifiedUser');
        $contact = $verifiedUser['email'] ?? $verifiedUser['phone'];

        if ($request->is(['post','ajax'])) {
            $credentials = $request->getData();

            if ($this->AuthServiceProvider->validateForm('register')) {
                $password = $this->AuthServiceProvider->getFormData('password');
                $password2 = $this->AuthServiceProvider->getFormData('confirm_password');
                if (!Validation::equalTo($password, $password2)) {
                    $errors += ['confirm_password' => ['Password mismatch. Your password confirmation does not match the first one above']];
                } else {
                    $data = [
                        'gender' => $this->AuthServiceProvider->getFormData('gender'),
                        'date_of_birth' => new Date($this->AuthServiceProvider->getFormData('date_of_birth')),
                        'password' => $password
                    ];
                    $userEntity = $this->Users->getUserBy($contact);
                    $updatedUser = $this->Users->patchEntity($userEntity, $data);

                    if ($this->Users->save($updatedUser)) {
                        $session->delete('verifiedUser');
                        $session->delete('verifiedContact');
                        $session->delete('pendingVerification');
                        $this->Flash->default(
                            __(sprintf("Congratulations! You have been"
                            . " registered on %s, the most exciting and truly "
                            . "digital bank. You may now log in to open your "
                            . "first ever digital bank account.",
                                Configure::read('Site.name')))
                        );

                        // Now you may log in
                        $redirectAfterAuth = $this->getRequest()->getQuery('after_auth_redirect');
                        $next = Router::url('/login');
                        if (!empty($redirectAfterAuth)) {
                            $next .= '&after_auth_redirect='.$redirectAfterAuth;
                        }
                        return $this->redirect($next);
                    }

                }
            }
            $errors += $this->AuthServiceProvider->getErrors();
        }

        $this->set(compact('errors', 'credentials'));
    }
}
