<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Http\Exception\NotFoundException;
use Cake\Datasource\Exception\RecordNotFoundException;

/**
 * Requests Controller
 *
 * @property \App\Model\Table\RequestsTable $Requests
 *
 * @method \App\Model\Entity\Request[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RequestsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $requests = $this->paginate($this->Requests);
        $this->set(compact('requests'));
    }
    
    /**
     * Request view method
     * 
     * @param string|null $id Request id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function v($id)
    {
        $result = $this->Requests->find('byRefid', ['refid' => $id])
                ->where([
                    'target_refid' => $this->getActiveUser()->refid
                ]);
        if ($result->count() !== 1) {
            throw new NotFoundException();
        }
        $request = $result->toArray()[0];
        $this->_setAsOpened($request);
        $requester = $this->getUserObject($request->sender_refid);
        $requester = $this->buildUserProfile($requester);
        $pendingRequests = (array)$this->Requests->getPending($this->getActiveUser()->refid, 'inbox', 0, 10);
                
        if (count($pendingRequests)) {
            $callback = function (&$request, $index) {
                $sender = $this->getUserObject($request->sender_refid);
                $request->sender = $sender;
            };
            array_walk($pendingRequests, $callback);
        }
        
        $this->set(compact('request', 'requester', 'pendingRequests'));
    }
    
    protected function _setAsOpened(\App\Model\Entity\Request $request)
    {
        $request = $this->Requests->patchEntity($request, ['is_read' => 1]);
        $this->Requests->save($request);
        $notifRef = $this->getRequest()->getQuery('e_ntf_ref');
        $NotifTbl = $this->loadModel('Notifications');

        if (!empty($notifRef)) {
            try {
                $notification = $NotifTbl
                        ->find('byRefid', ['refid' => $notifRef])
                        ->limit(1)
                        ->first();
            } catch (RecordNotFoundException $ex) {
                
            }
            
            $notification = $NotifTbl->patchEntity($notification, ['is_read' => 1]);
            $NotifTbl->save($notification);
        }
    }

    /**
     * View method
     *
     * @param string|null $id Request id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
//    public function view($id = null)
//    {
//        $request = $this->Requests->get($id, [
//            'contain' => []
//        ]);
//
//        $this->set('request', $request);
//    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $request = $this->Requests->newEntity();
        if ($this->request->is('post')) {
            $request = $this->Requests->patchEntity($request, $this->request->getData());
            if ($this->Requests->save($request)) {
                $this->Flash->success(__('The request has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The request could not be saved. Please, try again.'));
        }
        $this->set(compact('request'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Request id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $request = $this->Requests->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $request = $this->Requests->patchEntity($request, $this->request->getData());
            if ($this->Requests->save($request)) {
                $this->Flash->success(__('The request has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The request could not be saved. Please, try again.'));
        }
        $this->set(compact('request'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Request id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $request = $this->Requests->get($id);
        if ($this->Requests->delete($request)) {
            $this->Flash->success(__('The request has been deleted.'));
        } else {
            $this->Flash->error(__('The request could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
