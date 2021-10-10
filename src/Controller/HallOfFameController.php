<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\EventInterface;

/**
 * HallOfFame Controller
 *
 *
 * @method \App\Model\Entity\HallOfFame[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class HallOfFameController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();

//        $this->viewBuilder()->setLayout('has_sidebar');
    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        $user = $this->getActiveUser();
        if ($user && !$user->isAHallOfFamer()) {
            $this->Flash->error(__('You are not yet a Hall of Famer.'));
            return $this->redirect('/support/hall-of-fame/how-to-become-a-member');
        }
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
//        $hallOfFame = $this->paginate($this->HallOfFame);
//
//        $this->set(compact('hallOfFame'));
    }

    /**
     * View method
     *
     * @param string|null $id Hall Of Fame id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $hallOfFame = $this->HallOfFame->get($id, [
            'contain' => []
        ]);

        $this->set('hallOfFame', $hallOfFame);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $hallOfFame = $this->HallOfFame->newEntity();
        if ($this->request->is('post')) {
            $hallOfFame = $this->HallOfFame->patchEntity($hallOfFame, $this->request->getData());
            if ($this->HallOfFame->save($hallOfFame)) {
                $this->Flash->success(__('The hall of fame has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The hall of fame could not be saved. Please, try again.'));
        }
        $this->set(compact('hallOfFame'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Hall Of Fame id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $hallOfFame = $this->HallOfFame->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $hallOfFame = $this->HallOfFame->patchEntity($hallOfFame, $this->request->getData());
            if ($this->HallOfFame->save($hallOfFame)) {
                $this->Flash->success(__('The hall of fame has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The hall of fame could not be saved. Please, try again.'));
        }
        $this->set(compact('hallOfFame'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Hall Of Fame id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $hallOfFame = $this->HallOfFame->get($id);
        if ($this->HallOfFame->delete($hallOfFame)) {
            $this->Flash->success(__('The hall of fame has been deleted.'));
        } else {
            $this->Flash->error(__('The hall of fame could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
