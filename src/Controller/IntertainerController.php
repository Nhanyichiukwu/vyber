<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * I Controller
 *
 *
 * @method \App\Model\Entity\I[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 *
 */
class IntertainerController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
//        $i = $this->paginate($this->I);

//        $this->set(compact('i'));
        $this->viewBuilder()
                ->setTemplate('index')
                ->setLayout('standard_sidebar');
    }

    /**
     * View method
     *
     * @param string|null $id I id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $i = $this->I->get($id, [
            'contain' => []
        ]);

        $this->set('i', $i);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $i = $this->I->newEntity();
        if ($this->request->is('post')) {
            $i = $this->I->patchEntity($i, $this->request->getData());
            if ($this->I->save($i)) {
                $this->Flash->success(__('The i has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The i could not be saved. Please, try again.'));
        }
        $this->set(compact('i'));
    }

    /**
     * Edit method
     *
     * @param string|null $id I id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $i = $this->I->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $i = $this->I->patchEntity($i, $this->request->getData());
            if ($this->I->save($i)) {
                $this->Flash->success(__('The i has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The i could not be saved. Please, try again.'));
        }
        $this->set(compact('i'));
    }

    /**
     * Delete method
     *
     * @param string|null $id I id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $i = $this->I->get($id);
        if ($this->I->delete($i)) {
            $this->Flash->success(__('The i has been deleted.'));
        } else {
            $this->Flash->error(__('The i could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
