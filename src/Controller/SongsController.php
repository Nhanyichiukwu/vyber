<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Songs Controller
 *
 * @property \App\Model\Table\SongsTable $Songs
 *
 * @method \App\Model\Entity\Song[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 * @method \App\Model\Entity\Audio[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SongsController extends AppController
{

    public function initialize() {
        parent::initialize();

        $this->loadModel('Audios');

        $this->loadComponent('User');
    }

    public function beforeRender(\Cake\Event\Event $event) {

        parent::beforeRender($event);

        $this->viewBuilder()->setLayout('no_sidebar');
        if ($this->getRequest()->getQuery('request_origin') === 'container') {
            $this->viewBuilder()
                    ->setLayoutPath('/')
                    ->setLayout('blank');
        }
        if ($this->getRequest()->is('ajax')) {
            $this->viewBuilder()
                    ->setLayoutPath('/')
                    ->setLayout('ajax');
        }
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $request = $this->getRequest();
//        $this->Newsfeed->getFeedSources();
        $songs = $this->Audios->find('music')->orderDesc('created');


        if ($request->getQuery('filter'))
        {
            $songs = $this->applyFiltering($songs);
        }
        if ($request->getQuery('sort'))
        {
            $songs = $this->applySorting($songs);
        }

        $songs = $this->paginate($songs);
        $songs = $songs->toArray();

        $this->set(compact('songs'));
    }

    /**
     *
     * @param string|null $id Song id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $song = $this->Medias->get($id, [
            'contain' => []
        ]);

        $this->set('media', $song);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $song = $this->Songs->newEntity();
        if ($this->request->is('post')) {
            $song = $this->Songs->patchEntity($song, $this->request->getData());
            if ($this->Songs->save($song)) {
                $this->Flash->success(__('The song has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The song could not be saved. Please, try again.'));
        }
        $this->set(compact('song'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Song id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $song = $this->Songs->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $song = $this->Songs->patchEntity($song, $this->request->getData());
            if ($this->Songs->save($song)) {
                $this->Flash->success(__('The song has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The song could not be saved. Please, try again.'));
        }
        $this->set(compact('song'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Song id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $song = $this->Songs->get($id);
        if ($this->Songs->delete($song)) {
            $this->Flash->success(__('The song has been deleted.'));
        } else {
            $this->Flash->error(__('The song could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
