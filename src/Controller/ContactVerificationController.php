<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\User;
use App\Utility\RandomString;
use Cake\Event\Event;
use Cake\Event\EventInterface;
use Cake\Http\Exception\ForbiddenException;
use Cake\I18n\Time;
use Cake\Routing\Router;
use Cake\Validation\Validation;

/**
 * ContactVerification Controller
 *
 *
 * @property \Cake\Controller\Component\FlashComponent $Flash;
 * @property \App\Controller\Component\VerificationServiceProviderComponent $VerificationServiceProvider
 */
class ContactVerificationController extends AppController
{
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

//        $this->viewBuilder()->setLayout('blank');
        $this->Auth->allow();
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $request = $this->getRequest();
        if (!$request->getQuery('contact') ||
            !$request->getQuery('type') ||
            !$request->getSession()->check('process')) {
            throw new ForbiddenException();
        }
        $previouslyPending = $this->VerificationServiceProvider->readPendingVerification();
        $storedCode = $previouslyPending['code'];
        $storedContact = (string) $previouslyPending['contact'] ?? '';
        $contactType = (string) $previouslyPending['contact_type'];
        if ($request->is(['post','ajax'])) {
            $submittedCode = $request->getData('verification_code');
            if (Validation::equalTo($submittedCode, $storedCode)) {
                $event = new Event('App.NewUser.optin', $this, [
                    "$contactType" => $storedContact,
                    'datetime' => Time::now()
                ]);
                $this->getEventManager()->dispatch($event);

                $this->VerificationServiceProvider->write('verified', $previouslyPending);
                $contactTypePhrase = ['phone' => 'phone number','email' => 'email address'];
                $this->Flash->success(
                    __(
                        sprintf(
                            "Your %s has been verified.",
                            $contactTypePhrase[$contactType]
                        )
                    )
                );
                $afterVerifyRedirectUrl = $request->getQuery('after_verify_redirect');
                $afterVerifyRedirectUrl = urldecode($afterVerifyRedirectUrl);

                $responseData = json_encode(['verified_contact' => $storedContact]);

                return $this->redirect($afterVerifyRedirectUrl);
            }
            $this->Flash->error(
                __(
                    'You have entered a wrong code! Please crosscheck ' .
                    'the code and try again.'
                )
            );
        }

        $this->set(compact('storedContact','contactType','storedCode'));
    }

    public function sendCode($contact)
    {
        $this->disableAutoRender();
        $request = $this->getRequest();
        if (!$request->getSession()->check('process')) {
            throw new ForbiddenException();
        }
        if (!Validation::email($contact) && !Validation::numeric($contact)) {
            throw new ForbiddenException();
        }
        $contactType = $this->AuthServiceProvider->getDataType($contact);
        $this->VerificationServiceProvider->verify($contact, $contactType);
        $afterVerifyUrl = $request->getQuery('after_verify_redirect');

        $nextAction = Router::url([
            'action' => 'index',
            '?' => [
                'process' => 'signup',
                'contact' => $contact,
                'type' => $contactType,
                'after_verify_redirect' => $afterVerifyUrl
            ]
        ], true);

        return $this->redirect($nextAction);
    }

    public function requestCode()
    {
        $this->disableAutoRender();
        $request = $this->getRequest();
        if ($request->getSession()->check('pendingVerification')) {
            $code = $request->getSession()->read('pendingVerification.code');
            $target = $request->getSession()->read('pendingVerification.target');
        } else {
            $code = RandomString::generateString(8);
            $target = $request->getQuery('contact');
        }
        if (!$this->sendCode($code, $target)) {
            $this->Flash->error(__('Unable to resend code at the moment. Please try again later'));
        } else {
            $this->Flash->success(__('Code sent.'));
        }

        $afterSendRedirect = $request->getQuery('after_send_redirect');
        return $this->redirect($afterSendRedirect);
    }
}
