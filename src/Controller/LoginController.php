<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use App\Controller\Component\AuthServiceProviderComponent;
use Cake\Event\Event;
use Cake\Event\EventInterface;
use Cake\Http\Client\Request;
use Cake\Http\Cookie\Cookie;
use Cake\Http\ServerRequest;
use Cake\I18n\Time;

/**
 * Login Controller
 *
 *
 * @method \App\Model\Entity\Login[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 * @property AuthServiceProviderComponent $AuthServiceProvider
 */
class LoginController extends AppController
{
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        $layout = 'auth';
        if ($this->getRequest()->is('ajax')) {
            $layout = 'ajax';
        }
        $this->viewBuilder()
            ->setTemplatePath('Auth' . DS . 'login')
            ->setLayout($layout);

        $this->Auth->allow();
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        // In an event a user attempts to access this page while already logged
        // in, send them back to the dashboard
        if ($this->AuthServiceProvider->isAuthenticated()) {
            return $this->redirect($this->Auth->redirectUrl());
        }

        $request = $this->getRequest();
        $response = $this->getResponse();
        $login = $errors = [];

        if ($request->is(['post'])) {
            $this->AuthServiceProvider->authenticate(['contact','password']);
            if ($this->AuthServiceProvider->authStatus === 'success') {
                $authenticatedUser = $this->AuthServiceProvider->getAuthenticatedUser();

                $cookie = (new Cookie(
                    'remember_me',
                    $this->AuthServiceProvider->getFormData('remember_me')
                ))
                    ->withPath('/')
                    ->withSecure(false)
                    ->withNeverExpire();
                $response = $response->withCookie($cookie);
                $this->Auth->setUser(
                    $authenticatedUser->jsonSerialize()
                );
                $this->_status = 'success';
                $this->_authMessage = 'Login successful...';

                $event = new Event('App.User.login', $this, [
                    'user' => $authenticatedUser,
                    'time' => Time::now()
                ]);
                $this->getEventManager()->dispatch($event);

                $status = 'success';
                $message = 'Login successful...';
            } else {
                $status = 'error';
                $message = "We searched everywhere but couldn't find any user
            matching the username and password you provided. ... Are you sure
            you did not miss a letter or two?.";
                $errors = $this->AuthServiceProvider->getErrors();
                $login = $request->getData();
                $response = $response->withStatus(500, $status);
            }
            if ($request->is('ajax')) {
                $feedback = [
                    'status' => $status,
                    'message' => $message
                ];
                $feedback = json_encode($feedback);
                $response = $response->withStringBody($feedback);
                return $response;
            }

            $this->Flash->{$status}(__($message));
            if ($status === 'success') {
                $next = $this->Auth->redirectUrl();
                if ($request->getQuery('redirect')) {
                    $next = urldecode($request->getQuery('redirect'));
                }

                return $response->withLocation($next);
            }
        }

        $this->set(compact('login','errors'));
    }
}
