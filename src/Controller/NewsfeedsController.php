<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Newsfeeds Controller
 *
 *
 * @method \App\Model\Entity\Newsfeed[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class NewsfeedsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $newsfeeds = $this->Newsfeed->getStream($this->getActiveUser()->refid);

        $this->set(compact('newsfeeds'));
    }

    /**
     * View method
     *
     * @param string|null $id Newsfeed id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $newsfeed = $this->Newsfeeds->get($id, [
            'contain' => []
        ]);

        $this->set('newsfeed', $newsfeed);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $newsfeed = $this->Newsfeeds->newEntity();
        if ($this->request->is('post')) {
            $newsfeed = $this->Newsfeeds->patchEntity($newsfeed, $this->request->getData());
            if ($this->Newsfeeds->save($newsfeed)) {
                $this->Flash->success(__('The newsfeed has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The newsfeed could not be saved. Please, try again.'));
        }
        $this->set(compact('newsfeed'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Newsfeed id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $newsfeed = $this->Newsfeeds->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $newsfeed = $this->Newsfeeds->patchEntity($newsfeed, $this->request->getData());
            if ($this->Newsfeeds->save($newsfeed)) {
                $this->Flash->success(__('The newsfeed has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The newsfeed could not be saved. Please, try again.'));
        }
        $this->set(compact('newsfeed'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Newsfeed id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $newsfeed = $this->Newsfeeds->get($id);
        if ($this->Newsfeeds->delete($newsfeed)) {
            $this->Flash->success(__('The newsfeed has been deleted.'));
        } else {
            $this->Flash->error(__('The newsfeed could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
