<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * LiveFeed Controller
 *
 *
 * @method \App\Model\Entity\LiveFeed[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class bkp extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $liveFeed = $this->paginate($this->LiveFeed);

        $this->set(compact('liveFeed'));
    }

    public function task($task)
    {
        print_r($task);
    }

    protected function _postEngagements()
    {

    }

    protected function _newsfeed()
    {

    }

    protected function _checkUpdate()
    {

    }

    protected function _adsPipeline()
    {

    }

    protected function _boxOffice()
    {

    }

    protected function _notifications()
    {

    }

    protected function _billBoard()
    {

    }

    protected function _suggestions()
    {

    }

    /**
     * View method
     *
     * @param string|null $id Live Feed id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $liveFeed = $this->LiveFeed->get($id, [
            'contain' => []
        ]);

        $this->set('liveFeed', $liveFeed);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $liveFeed = $this->LiveFeed->newEntity();
        if ($this->request->is('post')) {
            $liveFeed = $this->LiveFeed->patchEntity($liveFeed, $this->request->getData());
            if ($this->LiveFeed->save($liveFeed)) {
                $this->Flash->success(__('The live feed has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The live feed could not be saved. Please, try again.'));
        }
        $this->set(compact('liveFeed'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Live Feed id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $liveFeed = $this->LiveFeed->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $liveFeed = $this->LiveFeed->patchEntity($liveFeed, $this->request->getData());
            if ($this->LiveFeed->save($liveFeed)) {
                $this->Flash->success(__('The live feed has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The live feed could not be saved. Please, try again.'));
        }
        $this->set(compact('liveFeed'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Live Feed id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $liveFeed = $this->LiveFeed->get($id);
        if ($this->LiveFeed->delete($liveFeed)) {
            $this->Flash->success(__('The live feed has been deleted.'));
        } else {
            $this->Flash->error(__('The live feed could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
