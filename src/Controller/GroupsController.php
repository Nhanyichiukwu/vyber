<?php
declare(strict_types=1);

namespace App\Controller;

use App\Utility\CustomString;
use Cake\Utility\Hash;
use Cake\Utility\Inflector;
use Cake\Utility\Text;

/**
 * Groups Controller
 *
 * @property \App\Model\Table\GroupsTable $Groups
 * @method \App\Model\Entity\Group[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class GroupsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $groups = $this->paginate($this->Groups);

        $this->set(compact('groups'));
    }

    /**
     * View method
     *
     * @param string|null $id Group id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $group = $this->Groups->get($id, [
            'contain' => ['GroupInvites', 'GroupJoinRequests', 'GroupMedias', 'GroupMembers', 'GroupPosts'],
        ]);

        $this->set(compact('group'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function newGroup()
    {
        $group = $this->Groups->newEmptyEntity();
        if ($this->request->is('post')) {
            $request = $this->getRequest();
            $data = [];
            foreach ($request->getData() as $key => $value) {
                if (
                    str_starts_with($key, '_') ||
                    is_null($value) ||
                    !is_string($value)
                ) {
                    continue;
                }
                $data[$key] = CustomString::sanitize($value);
            }
            $data['slug'] = mb_strtolower(Text::slug($data['name']));
            $group = $this->Groups->patchEntity($group, $data);

            if ($this->Groups->save($group)) {
                $this->Flash->success(__('The group has been saved.'));
                if ($request->is('ajax')) {
                    /** @noinspection PhpComposerExtensionStubsInspection */
                    $response = $this->getResponse()->withStringBody(
                        json_encode([
                            'status' => 'success',
                            'message' => 'Your group has been created.'
                        ])
                    );

                    return $response;
                }
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The group could not be saved. Please, try again.'));
        }
        $this->set(compact('group'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Group id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $group = $this->Groups->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $group = $this->Groups->patchEntity($group, $this->request->getData());
            if ($this->Groups->save($group)) {
                $this->Flash->success(__('The group has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The group could not be saved. Please, try again.'));
        }
        $this->set(compact('group'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Group id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $group = $this->Groups->get($id);
        if ($this->Groups->delete($group)) {
            $this->Flash->success(__('The group has been deleted.'));
        } else {
            $this->Flash->error(__('The group could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
