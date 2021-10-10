<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Calendar Controller
 *
 *
 * @method \App\Model\Entity\Calendar[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CalendarController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
//        $calendar = $this->paginate($this->Calendar);
//
//        $this->set(compact('calendar'));
    }
    
    public function beforeFilter(\Cake\Event\Event $event) {
        parent::beforeFilter($event);
        
        $requestAction = $this->getRequest()->getParam('action');
        if (!$this->hasAction($requestAction)) {
            $path = (array) $this->getRequest()->getParam('pass');
            return $this->setAction('viewDate', $requestAction, $path);
        }
    }

    /**
     * View method
     *
     * @param string|null $id Calendar id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $calendar = []; //$this->Calendar->get($id, [
//            'contain' => []
//        ]);

        $this->set('calendar', $calendar);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $calendar = $this->Calendar->newEntity();
        if ($this->request->is('post')) {
            $calendar = $this->Calendar->patchEntity($calendar, $this->request->getData());
            if ($this->Calendar->save($calendar)) {
                $this->Flash->success(__('The calendar has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The calendar could not be saved. Please, try again.'));
        }
        $this->set(compact('calendar'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Calendar id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $calendar = $this->Calendar->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $calendar = $this->Calendar->patchEntity($calendar, $this->request->getData());
            if ($this->Calendar->save($calendar)) {
                $this->Flash->success(__('The calendar has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The calendar could not be saved. Please, try again.'));
        }
        $this->set(compact('calendar'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Calendar id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $calendar = $this->Calendar->get($id);
        if ($this->Calendar->delete($calendar)) {
            $this->Flash->success(__('The calendar has been deleted.'));
        } else {
            $this->Flash->error(__('The calendar could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    public function viewDate( $year, $path = [] )
    {
        if (strlen($year) > 4) {
            // throw error
        }
        
        
    }
}
