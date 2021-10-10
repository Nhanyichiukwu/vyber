<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * MusicMakers Controller
 *
 * @property \App\Model\Table\MusicMakersTable $MusicMakers
 *
 * @method \App\Model\Entity\MusicMakers[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MusicMakersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $musicIndustry = $this->paginate($this->MusicMakers);

        $this->set(compact('musicIndustry'));
    }

    /**
     * View method
     *
     * @param string|null $id Music Industry id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $musicIndustry = $this->MusicMakers->get($id, [
            'contain' => []
        ]);

        $this->set('musicIndustry', $musicIndustry);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $musicIndustry = $this->MusicMakers->newEntity();
        if ($this->request->is('post')) {
            $musicIndustry = $this->MusicMakers->patchEntity($musicIndustry, $this->request->getData());
            if ($this->MusicMakers->save($musicIndustry)) {
                $this->Flash->success(__('The music industry has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The music industry could not be saved. Please, try again.'));
        }
        $this->set(compact('musicIndustry'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Music Industry id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $musicIndustry = $this->MusicMakers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $musicIndustry = $this->MusicMakers->patchEntity($musicIndustry, $this->request->getData());
            if ($this->MusicMakers->save($musicIndustry)) {
                $this->Flash->success(__('The music industry has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The music industry could not be saved. Please, try again.'));
        }
        $this->set(compact('musicIndustry'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Music Industry id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $musicIndustry = $this->MusicMakers->get($id);
        if ($this->MusicMakers->delete($musicIndustry)) {
            $this->Flash->success(__('The music industry has been deleted.'));
        } else {
            $this->Flash->error(__('The music industry could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
