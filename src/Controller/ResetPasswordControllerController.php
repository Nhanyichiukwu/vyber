<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ResetPasswordController Controller
 *
 *
 * @method \App\Model\Entity\ResetPasswordController[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ResetPasswordControllerController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $resetPasswordController = $this->paginate($this->ResetPasswordController);

        $this->set(compact('resetPasswordController'));
    }

    /**
     * View method
     *
     * @param string|null $id Reset Password Controller id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $resetPasswordController = $this->ResetPasswordController->get($id, [
            'contain' => []
        ]);

        $this->set('resetPasswordController', $resetPasswordController);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $resetPasswordController = $this->ResetPasswordController->newEntity();
        if ($this->request->is('post')) {
            $resetPasswordController = $this->ResetPasswordController->patchEntity($resetPasswordController, $this->request->getData());
            if ($this->ResetPasswordController->save($resetPasswordController)) {
                $this->Flash->success(__('The reset password controller has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The reset password controller could not be saved. Please, try again.'));
        }
        $this->set(compact('resetPasswordController'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Reset Password Controller id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $resetPasswordController = $this->ResetPasswordController->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $resetPasswordController = $this->ResetPasswordController->patchEntity($resetPasswordController, $this->request->getData());
            if ($this->ResetPasswordController->save($resetPasswordController)) {
                $this->Flash->success(__('The reset password controller has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The reset password controller could not be saved. Please, try again.'));
        }
        $this->set(compact('resetPasswordController'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Reset Password Controller id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $resetPasswordController = $this->ResetPasswordController->get($id);
        if ($this->ResetPasswordController->delete($resetPasswordController)) {
            $this->Flash->success(__('The reset password controller has been deleted.'));
        } else {
            $this->Flash->error(__('The reset password controller could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
