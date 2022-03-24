<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * TalentsHub Controller
 *
 * @method \App\Model\Entity\TalentsHub[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TalentsHubController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
//        $talentsHub = $this->paginate($this->TalentsHub);
//
//        $this->set(compact('talentsHub'));
    }

    /**
     * View method
     *
     * @param string|null $id Talent Hub id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $talentsHub = $this->TalentsHub->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('talentsHub'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $talentsHub = $this->TalentsHub->newEmptyEntity();
        if ($this->request->is('post')) {
            $talentsHub = $this->TalentsHub->patchEntity($talentsHub, $this->request->getData());
            if ($this->TalentsHub->save($talentsHub)) {
                $this->Flash->success(__('The talent hub has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The talent hub could not be saved. Please, try again.'));
        }
        $this->set(compact('talentsHub'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Talent Hub id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $talentsHub = $this->TalentsHub->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $talentsHub = $this->TalentsHub->patchEntity($talentsHub, $this->request->getData());
            if ($this->TalentsHub->save($talentsHub)) {
                $this->Flash->success(__('The talent hub has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The talent hub could not be saved. Please, try again.'));
        }
        $this->set(compact('talentsHub'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Talent Hub id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $talentsHub = $this->TalentsHub->get($id);
        if ($this->TalentsHub->delete($talentsHub)) {
            $this->Flash->success(__('The talent hub has been deleted.'));
        } else {
            $this->Flash->error(__('The talent hub could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
