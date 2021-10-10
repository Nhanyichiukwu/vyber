<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Notifications Controller
 *
 * @property \App\Model\Table\NotificationsTable $Notifications
 *
 * @method \App\Model\Entity\Notification[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class NotificationsController extends AppController
{
    public function initialize()
    {
        parent::initialize();

        $this->viewBuilder()->setLayout('standard_sidebar');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        if ($this->getRequest()->is('ajax')) {
//            $this->autoRender = false;
            $this->viewBuilder()->setLayout('ajax');
        }
        $user = $this->getActiveUser();
        $notifications = $this->Notifications
            ->find('allForUser', [
                'for' => $user->get('refid'),
                'contain' => [
                    'Initiators' => ['Profiles'],
                    'Users' => ['Profiles']
                ]
            ]);
        $notifications = $this->Notifications->categorize($notifications)->all();



//        $notifications = $notifications->map(function ($row) {
//                $row->set('subject', $this->getSubject($row));
//                return $row;
//            })
//            ->sortBy('Notifications.id')
//            ->toArray();

        pr($notifications);
        exit;
        $this->set(compact('notifications'));
    }

    public function recent()
    {
        $this->paginate = [
            'contain' => []
        ];
        $result = $this->Notifications
                ->find('unread', ['user_refid' => $this->getActiveUser()->refid])
                ->contain(['Initiators','Users'])
                ->orderDesc('created')
                ->limit(10); //$this->paginate($this->Notifications);

        $notifications = [];
        if (! $result->isEmpty()) {
            $notifications = (array) $result->toArray();
        }

        $isAjax = $this->getRequest()->is('ajax');
        if ($isAjax) {
            $this->viewBuilder()->setLayout('ajax');
        }

        $expectedContentType = $this->getRequest()->getHeaderLine('Content-Type');
        pr($expectedContentType);
        exit;
        if ($expectedContentType === 'json') {
            $notifications = json_encode($notifications);
            $response = $this->getResponse()->withStringBody($notifications);

            return $response;
        }

        $this->set(compact('notifications', 'isAjax'));
    }

    public function read()
    {
        $user = $this->getActiveUser();
        $notifications = $this->Notifications->find('read', [
            'for' => $user->get('refid'),
            'contain' => [
                'Initiators' => ['Profiles'],
                'Users' => ['Profiles']
            ]
        ])
        ->all()
        ->toArray();

        $this->set(compact('notifications'));
    }

    public function unread() {
        $user = $this->getActiveUser();
        $notifications = $this->Notifications->find('unread', [
            'for' => $user->get('refid'),
            'contain' => [
                'Initiators' => ['Profiles'],
                'Users' => ['Profiles']
            ]
        ])
            ->all()
            ->toArray();

        $this->set(compact('notifications'));
    }

    private function __getNotifications() {
        $this->paginate = [
            'contain' => []
        ];
        $notifications = $this->paginate($this->Notifications);
        $notifications = $notifications->toArray();
    }


    private function __getProperties(&$notification)
    {
        $notification->initiator = $this->getUserObject($notification->initiator_refid);
        $notification->target = $this->getUserObject($notification->target_refid);
        $subjects = [
            'connection_request' => 'Requests',
            'meeting_requests' => 'Requests',
            'introduction_requests' => 'Requests',
            'post_like' => 'Posts',
            'post_share' => 'Posts'
        ];
        $subjectTbl = $this->getTableLocator()->get($subjects[$notification->reason]);
        $result = $subjectTbl->find('all')->where(['refid' => $notification->subject_refid])->limit(1);
        $notification->subject = $result->first();
    }

    /**
     * View method
     *
     * @param string|null $id Notification id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $notification = $this->Notifications->find('all')->where([
            'refid' => $id
        ]);
        $notification = $notification->toArray()[0];
        $notification->message =
        $this->set('notification', $notification);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $notification = $this->Notifications->newEntity();
        if ($this->request->is('post')) {
            $notification = $this->Notifications->patchEntity($notification, $this->request->getData());
            if ($this->Notifications->save($notification)) {
                $this->Flash->success(__('The notification has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The notification could not be saved. Please, try again.'));
        }
        $targets = $this->Notifications->Targets->find('list', ['limit' => 200]);
        $initiators = $this->Notifications->Initiators->find('list', ['limit' => 200]);
        $this->set(compact('notification', 'targets', 'initiators'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Notification id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $notification = $this->Notifications->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $notification = $this->Notifications->patchEntity($notification, $this->request->getData());
            if ($this->Notifications->save($notification)) {
                $this->Flash->success(__('The notification has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The notification could not be saved. Please, try again.'));
        }
        $targets = $this->Notifications->Targets->find('list', ['limit' => 200]);
        $initiators = $this->Notifications->Initiators->find('list', ['limit' => 200]);
        $this->set(compact('notification', 'targets', 'initiators'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Notification id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $notification = $this->Notifications->get($id);
        if ($this->Notifications->delete($notification)) {
            $this->Flash->success(__('The notification has been deleted.'));
        } else {
            $this->Flash->error(__('The notification could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    private function getSubject($row)
    {

    }
}
