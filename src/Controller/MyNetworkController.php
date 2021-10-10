<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\Request;
use App\Model\Entity\User;
use App\Utility\CustomMessages;
use Cake\Collection\Collection;
use Cake\Core\Configure;
use Cake\Event\EventInterface;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\ORM\Locator\TableLocator;

/**
 * Connections Controller
 *
 * @property \App\Model\Table\ConnectionsTable $Connections
 *
 * @method \App\Model\Entity\Connection[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MyNetworkController extends AppController
{
    private $__categories = [
        'connections',
        'followers',
        'followings',
        'groups',
        'hashtags',
        'events'
    ];

    public function initialize(): void
    {
        parent::initialize();

        $this->loadModel('Requests');
    }

    public function beforeRender(EventInterface $event) {
        parent::beforeRender($event);

//        $this->viewBuilder()->setLayout('standard_sidebar');
    }


    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {

    }

    /**
     *
     * @return Response|null|void
     */
    public function connections()
    {
        $user = $this->getActiveUser();
        $query = $this->Connections
            ->find('forUser', ['user' => $user->get('refid')]);
        $paginatedResult = $this->paginate($query);

        $result = \collection($paginatedResult->toArray())
            ->extract(
                function ($row) {
                    return $row->correspondent;
                }
            )
            ->map(function (User $user, int $index) {
//                $connections = \collection($user->connections)->extract(
//                    function ($row) use($user) {
//                        $connection = null;
//                        if ($user->isSameAs($row->correspondent)) {
//                            $connection = $row->actor;
//                        } elseif ($user->isSameAs($row->actor)) {
//                            $connection = $row->correspondent;
//                        }
//                        return $connection;
//                    }
//                );
//
//                $user->set('connections', $connections->toArray());
                return $user;
            });

        $connections = (array) $result->toArray();

        $this->set(compact('connections'));
    }

    /**
     * List of people following the user
     * @return Response|null|void
     */
    public function followers()
    {
        $user = $this->getActiveUser();
//        $query = $this->User->getFollowers($user->refid);
        $followsTable = (new TableLocator())->get('Follows');
        $query = $followsTable
            ->find('followers', ['user' => $user->refid]);
        $followers = $this->paginate($query)
            ->map(
                function (\App\Model\Entity\Follow $follow, $index) {
                    return $follow->follower;
                }
            );

        $this->set(compact('followers'));
    }

    /**
     * List of people whom the user follows
     * @return Response|null|void
     */
    public function followings()
    {
        $user = $this->getActiveUser();
        $followsTable = (new TableLocator())->get('Follows');
        $query = $followsTable
            ->find('followings', ['user' => $user->refid]);
        $followings = $this->paginate($query)
            ->map(
                function (\App\Model\Entity\Follow $follow, $index) {
                    return $follow->following;
                }
            );

        $this->set(compact('followings'));
    }

    /**
     * List of social groups the user belongs to
     * @return Response|null|void
     */
    public function myGroups()
    {
        $user = $this->getActiveUser();
        $this->loadModel('Groups');
        $this->viewBuilder()->setTemplatePath('Groups')
            ->setTemplate('index');
        $query = $this->Groups->find('forUser', ['user' => $user->refid]);
        $groups = $this->paginate($query);

        $this->set(compact('groups'));
    }

    public function requestedConnections()
    {
        $user = $this->getActiveUser();
        $sentRequests = $this->Requests
                ->find('sent', ['user' => $user->get('refid')])
                ->where(['type' => 'connection']);
        $paginatedResult = $this->paginate($sentRequests);
        $requests = (array) $paginatedResult->toArray();

        $this->set(compact('requests'));
    }

    public function invitations($invitationID = null)
    {
        $user = $this->getActiveUser();
        $serverRequest = $this->getRequest();

        if ($serverRequest->is('ajax')) {
            $box = $serverRequest->getQuery('status') ?? 'received';
            if (is_null($invitationID)) {
                $query = $this->Requests
                    ->find($box, ['user' => $user->get('refid')])
                    ->where(['Requests.type' => 'connection'])
                    ->contain([
                        'Senders' => [
                            'Profiles'
                        ],
                        'Recipients' => [
                            'Profiles'
                        ]
                    ]);
                $invitations = $this->paginate($query);
                $this->set(compact('invitations'));
            } else {
                try {
                    $invitation = $this->Requests
                        ->find($box, ['user' => $user->get('refid')])
                        ->where([
                            'Requests.refid' => $invitationID,
                            'Requests.type' => 'connection'
                        ])
                        ->contain([
                            'Senders' => [
                                'Profiles'
                            ],
                            'Recipients' => [
                                'Profiles'
                            ]
                        ])->first();

                    if ($invitation instanceof Request) {
                        $invitation = $this->Requests->patchEntity(
                            $invitation,
                            [
                                'Requests.is_read' => '1'
                            ]);
                        $this->Requests->save($invitation);
                    }
                } catch (\Throwable $e) {
                    throw $e;
                }

                $this->viewBuilder()->setTemplate('view_invitation');
                $this->set(compact('invitation'));
            }
        }
    }

    public function introductions()
    {

    }

    public function pendingIntroductions()
    {

    }

    public function sentIntroductions()
    {

    }

    public function recommendations()
    {

    }

    public function pendingRecommendations()
    {

    }

    public function sentRecommendations()
    {

    }

    public function requests($id = null)
    {
        $user = $this->getActiveUser();
        $this->loadModel('Requests');
        $results = $this->Requests
                ->getConnectionRequests($user->refid)
                ->orderDesc('Requests.created')
                ->limit(20);
        $connectionRequests = $results->toArray();

//        if (count($connectionRequests)) {
//
//        }
        $this->set(compact('connectionRequests'));
    }

    public function manage($category = null)
    {
        $user = $this->getActiveUser();
        if (!is_null($category)) {
            try {
                return $this->viewCategory($category);
            } catch (\Exception $e) {
                if (Configure::read('debug')) {
                    throw new $e;
                }
                throw new NotFoundException(
                    CustomMessages::getMissingPageMessage()
                );
            }
        } else {
            $connectionsCount = $this->User->connections($user->refid)->count();
            $followersCount = $this->User->getFollowers($user->refid)->count();
            $followingsCount = $this->User->getFollowings($user->refid)->count();
            $eventsCount = $this->User->getSubscriptions(
                $user->refid, 'event'
            )->count();
            $hashtagsCount = $this->User->getSubscriptions(
                $user->refid, 'hashtag'
            )->count();
            $groupsCount = $this->User->getSubscriptions(
                $user->refid, 'group'
            )->count();

            $this->set(compact(
                'connectionsCount',
                'followersCount',
                'followingsCount',
                'eventsCount',
                'hashtagsCount',
                'groupsCount'
            ));
        }
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $connection = $this->Connections->newEntity();
        if ($this->request->is('post')) {
            $connection = $this->Connections->patchEntity($connection, $this->request->getData());
            if ($this->Connections->save($connection)) {
                $this->Flash->success(__('The connection has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The connection could not be saved. Please, try again.'));
        }
        $this->set(compact('connection'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Connection id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $connection = $this->Connections->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $connection = $this->Connections->patchEntity($connection, $this->request->getData());
            if ($this->Connections->save($connection)) {
                $this->Flash->success(__('The connection has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The connection could not be saved. Please, try again.'));
        }
        $this->set(compact('connection'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Connection id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $connection = $this->Connections->get($id);
        if ($this->Connections->delete($connection)) {
            $this->Flash->success(__('The connection has been deleted.'));
        } else {
            $this->Flash->error(__('The connection could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


}
