<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\Notification;
use Cake\Datasource\ResultSetInterface;
use Cake\ORM\Query;

/**
 * Notifications Controller
 *
 * @property \App\Model\Table\NotificationsTable $Notifications
 *
 * @method \App\Model\Entity\Notification[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class NotificationsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();

//        $this->viewBuilder()->setLayout('standard_sidebar');
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
        $timezone = $this->GuestsManager->getGuest()->get('timezone');


        $notifications = $this->Notifications
            ->find('allForUser', [
                'user' => $user->get('refid'),
                'contain' => [
                    'Initiators' => ['Profiles'],
                    'Users' => ['Profiles']
                ]
            ]);

        $notifications = (array) $this->Notifications->categorize($notifications);

        $this->set(compact('notifications'));
    }

    public function recent()
    {
        $this->paginate = [
            'contain' => []
        ];
        $user = $this->getActiveUser();
//        $query = $this->Notifications
//                ->find('betweenTimes', [
//                    'user' => $this->getActiveUser()->refid
//                ])
//                ->contain(['Initiators','Users'])
//                ->orderDesc('Notifications.created')
//                ->limit(10);

//        $notifications = $query->filter(function ($row) {
//            return $row->matches >= 1;
//        })
//        ->toArray();
        $notifications = $this->__fetchRecent($user->refid, true);
        if ($notifications->count() < 1) {
            $notifications = $this->__fetchRecent($user->refid);
        }

        $notifications = $notifications->toArray();

//        $notifications = [];
//        if (! $result->isEmpty()) {
//            $notifications = (array) $result->toArray();
//        }

//        $isAjax = $this->getRequest()->is('ajax');
//        if ($isAjax) {
//            $this->viewBuilder()->setLayout('ajax');
//        }
//
//        $expectedContentType = $this->getRequest()->getHeaderLine('Content-Type');
//
//        if ($expectedContentType === 'json') {
//            $notifications = json_encode($notifications);
//            $response = $this->getResponse()->withStringBody($notifications);
//
//            return $response;
//        }

        $this->set(compact('notifications'));
    }

    public function read()
    {
        $user = $this->getActiveUser();
        $notifications = $this->Notifications->find('read', [
            'user' => $user->get('refid'),
            'contain' => [
                'Initiators' => ['Profiles'],
                'Users' => ['Profiles']
            ]
        ]);
        $notifications = (array) $this->Notifications->categorize($notifications);

        $this->set(compact('notifications'));
    }

    public function unread() {
        $user = $this->getActiveUser();
        $notifications = $this->Notifications->find('unread', [
            'user' => $user->get('refid'),
            'contain' => [
                'Initiators' => ['Profiles'],
                'Users' => ['Profiles']
            ]
        ]);
        $notifications = (array) $this->Notifications->categorize($notifications);

        $this->set(compact('notifications'));
    }


    /**
     * Fetch the most recent notifications, or a list of records created within
     * a given time frame, beginning from a recent time specified in the
     * 'between_time' key through an earlier time specified in the
     * 'and_time' key of the $timeframe. For the time frame to work,
     * the '$byTimeframe' parameter must be set to true.
     *
     * @param string $user Required: The ref_id of the user
     * @param bool $byTimeframe Optional: Set to true if the result should be
     * based on a given time frame.
     * @param array $timeframe Optional: A time frame to use if result should be
     * based on time frame. The array accepts the following keys: 'between_time'
     * and 'and_time', where the former is a more recent date/time that defaults
     * to the current timestamp 'now', if not specified, and the later is an
     * earlier date/time that defaults to the number of hours since midnight,
     * if not specified.
     * @return \Cake\Collection\CollectionInterface|ResultSetInterface
     */
    private function __fetchRecent(string $user, bool $byTimeframe = false, array $timeframe = [])
    {
        if ($byTimeframe) {
            $defaultTimeFrame = [
                'between_time' => 'now',
                'and_time' => "-".date('H') . " hours",
            ];
            $options = array_merge($defaultTimeFrame, $timeframe);
            $options['user'] = $user;
            unset($defaultTimeFrame);
            $query = $this->Notifications
                ->find('byTimeFrame', $options);
        } else {
            $query = $this->Notifications->find('allForUser', [
                'for' => $user
            ]);
        }
        $query = $query
            ->contain([
                'Initiators' => ['Profiles'],
                'Users' => ['Profiles']
            ])
            ->orderDesc('Notifications.created');

        if ($byTimeframe) {
            return $query->filter(function ($row) {
                return $row->matches >= 1;
            });
        } else {
            return $query->all();
        }
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
    public function v($id = null)
    {
        echo $id;
        exit;
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
