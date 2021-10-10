<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Utility\CustomMessages;
use Cake\Controller\Exception\MissingActionException;
use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Utility\Inflector;
use Cake\View\Exception\MissingTemplateException;

/**
 * People Controller
 *
 *
 * @method \App\Model\Entity\Person[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PeopleController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->viewBuilder()->setTemplatePath('Users');
    }

    /**
     * Get a list of people based on the value specified in category.
     * If category is set to null or not provided, it will default to
     * all, which will invoke the Discover::allPeople()
     * @param string|null $category
     * @throws \Exception
     * @throws MissingActionException
     * @throws NotFoundException
     */
    public function display(...$path)
    {
        if (in_array('..', $path, true) || in_array('.', $path, true)) {
            throw new ForbiddenException();
        }
        $page = $subpage = null;

        if (!empty($path[0])) {
            $page = $path[0];
        }
        if (!empty($path[1])) {
            $subpage = $path[1];
        }

        $this->set(compact('page', 'subpage'));

//        array_unshift($path, 'people');
//        $tplPath = array_map(function ($item) {
//            return str_replace('-','_', $item);
//        }, $path);

        $templatePath = implode('/', $path);
        $templatePath = str_replace('-','_', $templatePath);

        try {
            $this->viewBuilder()->setTemplate($templatePath);
        } catch (MissingTemplateException $exception) {
            if (Configure::read('debug')) {
                throw $exception;
            }
            throw new NotFoundException(
                CustomMessages::getMissingPageMessage()
            );
        }

        if (method_exists($this, $page)) {
            $this->{$page}($subpage, $path);
        }
    }



    /**
     * View method
     *
     * @param string|null $id Person id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $person = $this->People->get($id, [
            'contain' => []
        ]);

        $this->set('person', $person);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $person = $this->People->newEntity();
        if ($this->request->is('post')) {
            $person = $this->People->patchEntity($person, $this->request->getData());
            if ($this->People->save($person)) {
                $this->Flash->success(__('The person has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The person could not be saved. Please, try again.'));
        }
        $this->set(compact('person'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Person id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $person = $this->People->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $person = $this->People->patchEntity($person, $this->request->getData());
            if ($this->People->save($person)) {
                $this->Flash->success(__('The person has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The person could not be saved. Please, try again.'));
        }
        $this->set(compact('person'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Person id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $person = $this->People->get($id);
        if ($this->People->delete($person)) {
            $this->Flash->success(__('The person has been deleted.'));
        } else {
            $this->Flash->error(__('The person could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
