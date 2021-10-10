<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\Post;
use App\Model\Entity\User;
use App\Utility\CustomString;
use Cake\Controller\Exception\MissingActionException;
use Cake\Core\Configure;
use Cake\Database\Connection;
use Cake\Database\Exception;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Event\EventInterface;
use Cake\Http\Exception\BadRequestException;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\InternalErrorException;
use Cake\Http\Exception\NotFoundException;
use Cake\Log\Log;
use Cake\Utility\Inflector;
use Cake\Utility\Text;
use App\Utility\RandomString;
use Cake\Utility\Security;
use Cake\Validation\Validation;
use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\Event\EventManager;
use Cake\Event\EventList;
use Cake\Event\EventDispatcherInterface;


/**
 * Commit Controller
 *
 *
 * @method \App\Model\Entity\Commit[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CommitsController extends AppController
{
    private $__intents = [
        'reactions' => [
            'like' => '%s likes your %s',
            'dislike' => '%s dislikes your %s',
            'love' => '%s loves your %s',
            'perfect' => '%s thinks your %s is perfect',
            'excellent' => '%s thinks your %s is excellent!',
            'laugh' => 'Your %s made %s laugh',
            'cry' => 'Your %s made %s cry',
            'sad' => 'Your %s made %s feel sad',
            'happy' => 'Your %s made %s feel happy',
            'super_excited' => '%s is super excited at your %s',
            'impressed' => '%s is impressed with your %s'
        ],
        'connection' => [
            'request' => '',
            'accept' => '',
            'decline' => '',
            'disconnect' => '',
        ],
        'introduction' => [

        ],
        'meeting' => [

        ]
    ];
    public function initialize(): void
    {
        parent::initialize();

//        $this->getRequest()->allowMethod(['post', 'ajax']);
        $this->loadComponent('CustomString');
    }

    public function beforeFilter(EventInterface $event) {
        parent::beforeFilter($event);
        $this->autoRender = false;
        $this->viewBuilder()->setLayout('ajax');
    }

    public function afterRequest(Event $event)
    {
        return $this->redirect(['controller' => 'foo', 'action' => 'bar']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {

        $type = $this->getRequest()->getQuery('type');
        $action = Inflector::camelize($type);
        if ($this->hasAction($action)) {
            return $this->{$action}();
        }

        return $this
                ->getResponse()
                ->withStatus(303, 'Invalid Request')
                ->withType('json')
                ->withStringBody(json_encode(['status' => 'error', 'message' => 'unknown intent']));
    }

    private function __isValidIntent($intent)
    {
        if (array_key_exists($intent, $this->__intents)) {
            return true;
        }

        return true;
    }

    public function request(...$path)
    {
        if (! count($path) || in_array('..', $path)) {
            throw new BadRequestException();
        }
        $action = $path[0];
        $action = Inflector::camelize($action);
        if ($this->hasAction($action)) {
            return $this->{$action}();
        }

        return $this
            ->getResponse()
            ->withStatus(303, 'Invalid Request')
            ->withType('json')
            ->withStringBody(json_encode(['status' => 'error', 'message' => 'unknown intent']));
    }

    /** @noinspection PhpComposerExtensionStubsInspection */
    public function connection()
    {
        $request = $this->getRequest();
        $response = $this->getResponse();
        $intent = $request->getQuery('intent');
        $action = '_' . lcfirst(Inflector::camelize($intent));
        $actorUsername = $request->getData('actor');
        $accountUsername = $request->getData('account');

        if (is_null($actorUsername) || is_null($accountUsername)) {
            return $response
//                ->withStatus(500, 'Invalid Request')
                ->withStringBody(
                    json_encode([
                        'status' => 'error',
                        'message' => 'Actor or target account username not provided',
                        'intent' => $intent,
                    ])
                );
        }

        /* @var  $actor User */
        $actor = $this->Users->getUser($actorUsername);
        /* @var  $account User */
        $account = $this->Users->getUser($accountUsername);
        $message = $reasonPhrase = $statusCode = null;

        if (!$actor instanceof User || !$account instanceof User) {
            return $response
//                ->withStatus(500, 'Internal Server Error')
                ->withStringBody(
                    json_encode([
                        'status' => 'error',
                        'message' => 'Oops! Either the actor or target account username ' .
                            'did not match any of our records.',
                        'intent' => $intent,
                    ])
                );
        }
        try {
            return $this->{$action}($actor, $account);
        } catch (MissingActionException $notFoundException) {
            return $this
                ->getResponse()
//                ->withStatus($notFoundException->getCode())
                ->withStringBody(
                    json_encode(
                        [
                            'status' => 'error',
                            'message' => $notFoundException->getMessage(),
                            'intent' => $intent,
                        ])
                );
        } catch (RecordNotFoundException $recordNotFoundException) {
            return $this
                ->getResponse()
//                ->withStatus($recordNotFoundException->getCode())
                ->withStringBody(
                    json_encode(
                        [
                            'status' => 'error',
                            'message' => $recordNotFoundException->getMessage(),
                            'intent' => $intent,
                        ])
                );
        }
    }
    protected function _inviteConnection(User $actor, User $account)
    {
        $response = $this->getResponse();
        $requestType = 'connection';
        $date = date('Y-m-d h:i:s');

        // If the parties are already connected, then abort the operation
        if (
            $this->Requests->isAlreadySent($actor->refid, $account->refid, $requestType) ||
            $this->Connections->existsBetween($actor->refid, $account->refid)
        ) {
            return null;
        }

        $options = [];
        if ($this->Requests->send($actor, $account, $requestType, $options)) {
            $statusCode = 200;
            $message = [
                'intent' => 'invite',
                'status' => 'success',
                'message' => 'Request sent'
            ];
        } else {
            $statusCode = 200;
            $message = [
                'intent' => 'invite',
                'status' => 'error',
                'message' => 'Sorry, your request could not be sent at the moment'
            ];
        }
//                $beforeSaveEvent = new Event('Model.Requests.beforeSave', $this->Requests, [
//                    'request' => $requestEntity
//                ]);
//                $this->eventManager()->dispatch($beforeSaveEvent);
//
//                $event = new Event('Notification.connection.afterRequest', $this, [
//                    'request' => $requestEntity
//                ]);
//                $this->getEventManager()->dispatch($event);
//                $this->Notifier->sendNotification($account, 'connection_request', $actor, $requestEntity);

        $message = json_encode($message);
        $response = $response
            ->withStatus($statusCode)
            ->withStringBody($message);

        return $response;
    }

    /** @noinspection PhpComposerExtensionStubsInspection */
    protected function _acceptInvitation(User $actor, User $account)
    {
        $response = $this->getResponse();

        if (!$this->Requests->hasPendingInvitation($account, $actor)) {
            return null;
        }

        $requestType = 'connection';

        if ($this->Requests->exists([
            'sender_refid' => $account->refid,
            'recipient_refid' => $actor->refid,
            'type' => $requestType
        ])
        ) {
            /** @var bool|Connection $acceptance */
            $acceptance = $this->Requests->accept($actor, $account, $requestType);
            if (!$acceptance instanceof Connection) {
                return $response->withStringBody(
                    json_encode([
                        'status' => 'error',
                        'message' => 'Unable to complete request.',
                        'intent' => 'accept',
                    ])
                );
            }

            // Establish connection
            try {
                if ($this->Connections->connect($actor->refid, $account->refid)) {
                    $acceptance->commit();
                }
            } catch (\Throwable $e) {
                $acceptance->rollback(false);
                if (Configure::read('debug')) {
                    throw $e;
                }
                return $response->withStringBody(
                    json_encode([
                        'status' => 'error',
                        'message' => 'Unable to complete request at the moment.',
                        'intent' => 'accept',
                    ])
                );
            }
        }

//                $beforeSaveEvent = new Event('Model.Requests.beforeSave', $this->Requests, [
//                    'request' => $requestEntity
//                ]);
//                $this->eventManager()->dispatch($beforeSaveEvent);
//
//                $event = new Event('Notification.connection.afterRequest', $this, [
//                    'request' => $requestEntity
//                ]);
//                $this->getEventManager()->dispatch($event);
//                $this->Notifier->sendNotification($account, 'connection_request', $actor, $requestEntity);

//        $message = json_encode($message);
//        $response = $response
//            ->withStatus($statusCode)
//            ->withStringBody($message)
//            ->withType('json')
//            ->withAddedHeader('Request-Intent', 'Acceptance');

        return $response;
    }

    /** @noinspection PhpComposerExtensionStubsInspection */
    protected function _declineInvitation(User $actor, User $account)
    {
        $response = $this->getResponse();

        if (!$this->Requests->hasPendingInvitation($account, $actor)) {
            return null;
        }

        if ($this->Requests->cancel(
            $account->refid,
            $actor->refid,
            'connection'
        )) {
            /** @noinspection PhpComposerExtensionStubsInspection */
            $response = $response
//                ->withStatus(200)
                ->withStringBody(
                    json_encode([
                        'status' => 'success',
                        'message' => 'Invitation Declined',
                        'intent' => 'decline',
                    ])
                );
        } else {
            $response = $response
//                ->withStatus(200)
                ->withStringBody(
                    json_encode([
                        'status' => 'error',
                        'message' => 'Unable to decline invitation.',
                        'intent' => 'decline',
                    ])
                );
        }

        return $response;
    }

    /** @noinspection PhpComposerExtensionStubsInspection */
    protected function _cancelInvitation(User $actor, User $account)
    {
        $response = $this->getResponse();
        if (!$this->Requests->hasPendingInvitation($actor, $account)) {
            return null;
        }
        if ($this->Requests->cancel(
            $actor->refid,
            $account->refid,
            'connection'
        )) {
            /** @noinspection PhpComposerExtensionStubsInspection */
            $response = $response
                ->withStatus(200)
                ->withStringBody(
                    json_encode([
                        'status' => 'success',
                        'message' => 'Invitation Cancelled',
                        'intent' => 'invitation_cancellation',
                    ])
                );
        } else {
            $response = $response
                ->withStatus(200)
                ->withStringBody(
                    json_encode([
                        'status' => 'error',
                        'message' => 'Unable to cancel request.',
                        'intent' => 'invitation_cancellation',
                    ])
                );
        }

        return $response;
    }

    /**
     * @param User $actor
     * @param User $account
     * @return \Cake\Http\Response|\Psr\Http\Message\MessageInterface|null
     */
    protected function _disconnect(User $actor, User $account)
    {
        $response = $this->getResponse();
        $message = null;
//            Otherwise, if the both users are already connected, then they will
//            be disconnected
        if (!$this->Connections->existsBetween(
            $actor->refid,
            $account->refid
        )) {
            return $response;
        }
        if ($this->Connections->disconnect(
            $actor->refid,
            $account->refid
        )) {
            $message = [
                'status' => 'success',
                'message' => sprintf('You are now disconnected from %s. '
                    . 'You will no longer be able to see %s post on your timeline',
                    $account->getFullname(), $account->getGenderAdjective()),
                'intent' => 'disconnection',
            ];
        } else {
            $message = [
                'status' => 'error',
                'message' => sprintf('Sorry, we could not disconnect you from %s.', $account->getFullname()),
                'intent' => 'disconnection',
            ];
        }
        $message = json_encode($message);
        $response = $response
            ->withStringBody($message)
            ->withType('json')
            ->withAddedHeader('Request-Intent', 'Disconnection');

        return $response;
    }

    public function postReaction($intent)
    {
        $httpR = $this->getRequest();
        $response = $this->getResponse();
        $message = $reasonPhrase = null; $statusCode = 200;

        if (! $this->__isValidIntent($intent)) {
            $response = $response->withStatus(404, 'Unknown Intent!');
        } else {
            $postData = $httpR->getData('data');
            $splitData = explode('_', $postData);
            $postType = $splitData[0];
            $postID = $splitData[1];

            /* @var  $actor User */
            $actor = $this->Users->getUser($splitData[3]);
            if (! ($actor instanceof User)) {
                throw new ForbiddenException();
            }

            // If the user had already reacted to this post, then undo it
            if ($this->PostReactions->alreadyExists($actor->refid, $postID, $postType)) {
                $this->PostReactions->undo($actor->refid, $postID, $postType);
                $totalLeft = count($this->PostReactions->find()->where([
                    'content_refid' => $postID
                ])->toArray());

                $response = $response
                    ->withStatus(200)
                    ->withStringBody(json_encode([
                        'status' => 'success',
                        'count' => $totalLeft,
                        'intent' => 'unreaction'
                    ]));
                return $response;
            }

            // Otherwise, gather the details and create a new reaction with it.
            $data = [
                'refid' => RandomString::generateString(20),
                'name' => ucfirst($intent),
                'reactor_refid' => $actor->refid,
                'content_refid' => $postID,
                'content_type' => $postType
            ];
            $reaction = $this->PostReactions->newEntity($data);
            if ($reaction->hasErrors()) {
//                Log::error(implode(', ', array_values($reaction->getErrors())));
            }
            elseif (! $this->PostReactions->save($reaction)) {
                $statusCode = 200;
                $message = [
                    'status' => 'error',
                    'intent' => 'reaction',
                    'message' => 'Sorry, your request can not be completed at the moment.'
                ];
            } else {
                $totalNow = count($this->PostReactions->find()->where([
                    'content_refid' => $postID
                ])->toArray());
                $message = [
                    'intent' => 'reaction',
                    'status' => 'success',
                    'count' => $totalNow,
                    'message' => 'Done'
                ];

                // Send notification to the owner and any other person who might have
                // notification enabled for the post
            }
        }

        $response = $response
            ->withStatus($statusCode, $reasonPhrase)
            ->withType('json')
            ->withStringBody(json_encode($message));

        return $response;
    }

//    public function _likePost($content)
//    {
//
//    }
//
//    public function _dislikePost($content)
//    {
//
//    }
//
//    public function _Post($content)
//    {
//
//    }



    public function introduce()
    {

    }

    public function meet()
    {

    }

    public function cloner()
    {
        $request = $this->getRequest();
        $request->allowMethod(['ajax','post','put']);
        $response = $this->getResponse();
        $postID = $this->CustomString->sanitize($request->getData('id'));
        $cloneAs = $this->CustomString->sanitize($request->getData('as'));
        $postPrivacy = $this->CustomString->sanitize($request->getData('privacy'));
        $timestamp = (new \DateTime())->getTimestamp();
        $newPostID = RandomString::generateString(20);

        try {
            $post = $this->Posts->get($postID);
            $originalAuthor = $post->author_refid;
            $originalPost = $post->refid;
            $post->isNew(true);
            $post->set('id', null);
            $post->set('refid', $newPostID);
            $post->set('author_refid', $this->getActiveUser()->refid);
            $post->set('copied', 1);
            $post->set('copied_as', $cloneAs);
            $post->set('original_author_refid', $originalAuthor);
            $post->set('original_post_refid', $originalPost);
            $post->set('date_published', $timestamp);
            if ($post->hasValue('parent_refid')) {
                $post->set('parent_refid', null);
            }
            $post->set('location', $this->getUserLocationInfo(['city','region']));
            $post->set('privacy', $postPrivacy);
            $post->set('created', $timestamp);
            $post->set('modified', $timestamp);
            try {
                $this->Posts->saveOrFail($post);
            } catch (Exception $ex) {

            }
        } catch (RecordNotFoundException $ex) {
            if (Configure::read('debug') === true) {
                throw new RecordNotFoundException('The post does not exists.');
            }

            return null;
        }
        try {
            $newPost = $this->Posts->get($newPostID);
            if ($newPost instanceof Post) {
                // Create an onPostClone Event here
                // ...
                return $this->redirect(['controller' => 'live-feed', 'action' => 'fetch_post', $newPostID]);
            }
        } catch (RecordNotFoundException $ex) {

        }

        return null;
    }

    /**
     * View method
     *
     * @param string|null $id Commit id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $commit = $this->Commit->get($id, [
            'contain' => []
        ]);

        $this->set('commit', $commit);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $commit = $this->Commit->newEntity();
        if ($this->request->is('post')) {
            $commit = $this->Commit->patchEntity($commit, $this->request->getData());
            if ($this->Commit->save($commit)) {
                $this->Flash->success(__('The commit has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The commit could not be saved. Please, try again.'));
        }
        $this->set(compact('commit'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Commit id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $commit = $this->Commit->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $commit = $this->Commit->patchEntity($commit, $this->request->getData());
            if ($this->Commit->save($commit)) {
                $this->Flash->success(__('The commit has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The commit could not be saved. Please, try again.'));
        }
        $this->set(compact('commit'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Commit id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $commit = $this->Commit->get($id);
        if ($this->Commit->delete($commit)) {
            $this->Flash->success(__('The commit has been deleted.'));
        } else {
            $this->Flash->error(__('The commit could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
