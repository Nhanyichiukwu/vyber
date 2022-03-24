<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{

    private $__account;
    public function initialize(): void
    {
        parent::initialize();

        $this->Auth->allow();
//        $this->loadComponent('UserActivities');
//        $this->loadComponent('User');
//        $this->loadModel('s');
//        $this->viewBuilder()->setLayout('profile');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function profile(string $username, ... $path)
    {
        $request = $this->getRequest();
        $isAjax = $request->is('ajax');

        if ($isAjax) {
            $this->viewBuilder()->setLayout('ajax');
        }

        // Prevent illegal dots in the path
        if (in_array('..', $path, true) || in_array('.', $path, true)) {
            throw new ForbiddenException();
        }

        // Find the user by the given username
        if (! $this->Users->exists(['username' => $username])) {
            return $this->unknownUser($username);
        }
//        $profile = $account = $this->Users->getUser($username, [
//            'Followers',
//            'Followings',
//            'Connections',
//            'Posts'
//        ], false);
        $profile = $account = $this->Users->getUser($username, [], true);

        $this->__account = $account;
        $page = $subpage = null;

        if (!empty($path[0])) {
            $page = $path[0];
        }
        if (!empty($path[1])) {
            $subpage = $path[1];
        }

        $pageTitle = $subpage ? ucfirst($subpage) : ucfirst($page);

        $this->set(compact('page','subpage','pageTitle','profile', 'path','account'));
        $this->set('_serialize', 'account');
        $this->set(['page_layout' => 'off-canvas-collapsed','sidebar_visibility' => 'desktop']);

        if (empty($path)) {
            array_unshift($path, 'index');
        }

        if (count($path)) {
            try {
                $this->viewBuilder()->setTemplate(implode(DS, $path));
            } catch (\Exception $exception) {
                if (Configure::read('debug')) {
                    debug($exception->getTrace());
                }
                throw new NotFoundException();
            }
        }
        $this->viewBuilder()->setTemplatePath('Users' . DS . 'profile');
    }
}
