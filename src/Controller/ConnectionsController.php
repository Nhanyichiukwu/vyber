<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Connections Controller
 *
 * @property \App\Model\Table\ConnectionsTable $Connections
 * @method \App\Model\Entity\Connection[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ConnectionsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Actors'],
        ];
        $connections = $this->paginate($this->Connections);

        $this->set(compact('connections'));
    }

    /**
     * View method
     *
     * @param string|null $id Connection id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $connection = $this->Connections->get($id, [
            'contain' => ['Actors', 'Correspondents'],
        ]);

        $this->set(compact('connection'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $connection = $this->Connections->newEmptyEntity();
        if ($this->request->is('post')) {
            $connection = $this->Connections->patchEntity($connection, $this->request->getData());
            if ($this->Connections->save($connection)) {
                $this->Flash->success(__('The connection has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The connection could not be saved. Please, try again.'));
        }
        $actors = $this->Connections->Actors->find('list', ['limit' => 200]);
        $this->set(compact('connection', 'actors'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Connection id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $connection = $this->Connections->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $connection = $this->Connections->patchEntity($connection, $this->request->getData());
            if ($this->Connections->save($connection)) {
                $this->Flash->success(__('The connection has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The connection could not be saved. Please, try again.'));
        }
        $actors = $this->Connections->Actors->find('list', ['limit' => 200]);
        $this->set(compact('connection', 'actors'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Connection id.
     * @return \Cake\Http\Response|null|void Redirects to index.
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
