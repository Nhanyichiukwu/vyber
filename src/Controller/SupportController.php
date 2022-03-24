<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Utility\Inflector;

/**
 * Support Controller
 *
 * @method \App\Model\Entity\Support[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SupportController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
//        $support = $this->paginate($this->Support);
//
//        $this->set(compact('support'));
    }
    
    public function faqs($article = null) 
    {
        $this->viewBuilder()
                ->setTemplatePath($this->getName() . '/faqs')
                ->setTemplate('index');
        if (!is_null($article)) {
            // It means article id or slug has been requested for viewing
            // So we change the template to the view template and then 
            // fetch the article if it exist and pass it to the view,
            // otherwise, we tell say we couldn't find it.
            $this->viewBuilder()->setTemplate('view');
            
            $this->set('article', $article);
        }
    }

    /**
     * View method
     *
     * @param string|null $id Support id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $support = $this->Support->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('support'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $support = $this->Support->newEmptyEntity();
        if ($this->request->is('post')) {
            $support = $this->Support->patchEntity($support, $this->request->getData());
            if ($this->Support->save($support)) {
                $this->Flash->success(__('The support has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The support could not be saved. Please, try again.'));
        }
        $this->set(compact('support'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Support id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $support = $this->Support->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $support = $this->Support->patchEntity($support, $this->request->getData());
            if ($this->Support->save($support)) {
                $this->Flash->success(__('The support has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The support could not be saved. Please, try again.'));
        }
        $this->set(compact('support'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Support id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $support = $this->Support->get($id);
        if ($this->Support->delete($support)) {
            $this->Flash->success(__('The support has been deleted.'));
        } else {
            $this->Flash->error(__('The support could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
