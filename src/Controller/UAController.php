<?php
namespace App\Controller;

use App\Controller\AppController;
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
 * UA Controller
 *
 *
 * @method \App\Model\Entity\UA[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UAController extends AppController
{

    public function initialize()
    {
        parent::initialize();

        $this->getRequest()->allowMethod(['ajax']);
    }

    public function beforeFilter(Event $event) {
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
//        $commit = $this->paginate($this->Commit);
//
//        $this->set(compact('commit'));

        $intent = $this->getRequest()->getQuery('intent');
        if ($this->hasAction($intent)) {
            return $this->{$intent}();
        }

        return $this
                ->getResponse()
                ->withStatus(303, 'Invalid Request')
                ->withType('json')
                ->withStringBody(json_encode(['error' => 'invalid request', 'message' => 'unknown intent']));
    }

    public function takeAction(...$path)
    {

    }

    public function connection()
    {
//        $isAjax = $this->getRequest()->is('ajax');
        $request = $this->getRequest();
        $response = $this->getResponse();
        $data = $request->getData('data');
        $dataArr = explode('/', $data);
        $actorUsername = $this->CustomString->sanitize($dataArr[0]);
        $accountUsername = $this->CustomString->sanitize($dataArr[1]);
        /* @var  $actor User */
        $actor = $this->Users->getUser($actorUsername);
        /* @var  $account User */
        $account = $this->Users->getUser($accountUsername);
        $message = $reasonPhrase = '';
        $statusCode = null;

        if (! ($account && $actor)) {
            $reasonPhrase = 'User not found';
            $statusCode = 500;
            $message = [
                'status' => 'error',
                'message' => 'Either the source or target account could not be found.'
            ];
        } else {

            $requestType = 'connection';
            $date = date('Y-m-d h:i:s');

            if (
                $this->Requests->isAlreadySent($actor->refid, $account->refid, $requestType) &&
                ! $this->Connections->existsBetween($actor->refid, $account->refid)
            ) {
                if ($this->Requests->cancelRequest($actor->refid, $account->refid)) {
                    $statusCode = 200;
                    $message = [
                        'intent' => 'request_cancellation',
                        'status' => 'success',
                        'message' => 'Request Cancelled'
                    ];
                } else {
                    $statusCode = 200;
                    $message = [
                        'intent' => 'request_cancellation',
                        'status' => 'error',
                        'message' => 'Unable to cancel request.'
                    ];
                }
            } elseif ($this->Connections->existsBetween($actor->refid, $account->refid)) {
                if ($this->Connections->disconnect($actor->refid, $account->refid)) {
                    $statusCode = 200;
                    $message = [
                        'intent' => 'disconnection',
                        'status' => 'success',
                        'message' => sprintf('You are now disconnected from %s. '
                            . 'You will no longer be able to see %s post on your timeline', $account->getFullname(), $account->getGenderAdjective())
                    ];
                } else {
                    $statusCode = 200;
                    $message = [
                        'intent' => 'disconnection',
                        'status' => 'error',
                        'message' => sprintf('Sorry, we could not disconnect you from %s.', $account->getFullname())
                    ];
                }
            } elseif (
                ! $this->Requests->isAlreadySent($actor->refid, $account->refid, $requestType) &&
                ! $this->Connections->existsBetween($actor->refid, $account->refid)
            ) {
                if ($this->Connections->connect($actor, $account)) {
                    $statusCode = 200;
                    $message = [
                        'intent' => 'connection',
                        'status' => 'success',
                        'message' => sprintf('You and %s are now connected.', $account->getFullname())
                    ];
                } else {
                    $statusCode = 200;
                    $message = [
                        'intent' => 'connection',
                        'status' => 'error',
                        'message' => 'Sorry, your request could not be completed at the moment';
                    ];
                }
            }
            $message = json_encode($message);
            $response = $response
                ->withStatus($statusCode)
                ->withStringBody($message)
                ->withType('json')
                ->withAddedHeader('Request-Intent', 'Connections');

            return $response;
        }
//        }
    }

    public function disconnect()
    {
        $isAjax = $this->getRequest()->is('ajax');
        $account = $this->getRequest()->getQuery('account');
        $user = $this->getRequest()->getQuery('user');

        $response = $this->getResponse()->withType('json');
        $message = $reasonPhrase = '';
        $statusCode = null;
    }

    public function like($content)
    {

    }

    public function introduce()
    {

    }

    public function meet()
    {

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
