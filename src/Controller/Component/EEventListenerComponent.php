<?php
declare(strict_types=1);

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Event\EventListenerInterface;
use Cake\Mailer\Mailer;
use Cake\Mailer\Email;
use Cake\Log\Log;
use Cake\I18n\Time;

/**
 * EEventListener component
 */
class EEventListenerComponent extends Component implements EventListenerInterface
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function implementedEvents() :array
    {
        parent::implementedEvents();
        return [
            'Model.User.afterSignup' => 'afterSignup',
            'App.User.login' => 'userLoggedIn',
            'App.User.logout' => 'userLoggedOut',
//            'Model.Request.afterSend' => [
//
//            ],
//            'Model.Request.afterConfirmation' => [
//
//            ],
            'Model.Post.afterNewPost' => 'newPostEvent'
        ];
    }

    public function afterSignup($event, $user) {
        Log::write('info', 'One user registered!');
    }

    public function userLoggedIn($event, $user) {
        Log::write('info', 'One user logged in!');
    }
    public function userLoggedOut($event, $user, $time) {
        Log::write('info', 'One user Logged out!');
    }

    public function sendContactVerificationEmail($event, $user) {

    }

    public function notifyAdmin($event, $user) {

    }

    public function newPostEvent($events, $post) {

    }
}
