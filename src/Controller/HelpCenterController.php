<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * HelpCenter Controller
 *
 *
 * @method \App\Model\Entity\HelpCenter[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class HelpCenterController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $helpCenter = $this->paginate($this->HelpCenter);

        $this->set(compact('helpCenter'));
    }

    /**
     * View method
     *
     * @param string|null $id Help Center id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $helpCenter = $this->HelpCenter->get($id, [
            'contain' => []
        ]);

        $this->set('helpCenter', $helpCenter);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $helpCenter = $this->HelpCenter->newEntity();
        if ($this->request->is('post')) {
            $helpCenter = $this->HelpCenter->patchEntity($helpCenter, $this->request->getData());
            if ($this->HelpCenter->save($helpCenter)) {
                $this->Flash->success(__('The help center has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The help center could not be saved. Please, try again.'));
        }
        $this->set(compact('helpCenter'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Help Center id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $helpCenter = $this->HelpCenter->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $helpCenter = $this->HelpCenter->patchEntity($helpCenter, $this->request->getData());
            if ($this->HelpCenter->save($helpCenter)) {
                $this->Flash->success(__('The help center has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The help center could not be saved. Please, try again.'));
        }
        $this->set(compact('helpCenter'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Help Center id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $helpCenter = $this->HelpCenter->get($id);
        if ($this->HelpCenter->delete($helpCenter)) {
            $this->Flash->success(__('The help center has been deleted.'));
        } else {
            $this->Flash->error(__('The help center could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
