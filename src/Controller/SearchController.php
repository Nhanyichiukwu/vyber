<?php
declare(strict_types=1);

namespace App\Controller;

use App\Utility\ServiceMessages;
use Cake\Controller\Component;
use Cake\Core\Configure;
use Cake\Http\Exception\BadRequestException;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\ORM\Locator\TableLocator;
use Cake\Utility\Inflector;

/**
 * Search Controller
 *
 * @method \App\Model\Entity\Search[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SearchController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $search = $this->paginate($this->Search);

        $this->set(compact('search'));
    }

    /**
     * View method
     *
     * @param string|null $id Search id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $search = $this->Search->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('search'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $search = $this->Search->newEmptyEntity();
        if ($this->request->is('post')) {
            $search = $this->Search->patchEntity($search, $this->request->getData());
            if ($this->Search->save($search)) {
                $this->Flash->success(__('The search has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The search could not be saved. Please, try again.'));
        }
        $this->set(compact('search'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Search id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $search = $this->Search->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $search = $this->Search->patchEntity($search, $this->request->getData());
            if ($this->Search->save($search)) {
                $this->Flash->success(__('The search has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The search could not be saved. Please, try again.'));
        }
        $this->set(compact('search'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Search id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $search = $this->Search->get($id);
        if ($this->Search->delete($search)) {
            $this->Flash->success(__('The search has been deleted.'));
        } else {
            $this->Flash->error(__('The search could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


    public function typeHint(...$path)
    {
        if (!count($path)) {
            throw new BadRequestException();
        }
        // Prevent illegal dots in the path
        if (
            in_array('..', $path, true) ||
            in_array('.', $path, true)) {
            throw new ForbiddenException();
        }
        if ($this->isAutoRenderEnabled()) {
            $this->disableAutoRender();
        }

        $componentName = Inflector::camelize($path[0],'_');
        $componentName = Inflector::camelize($componentName,'-');
        array_shift($path);
        $queryParams = $this->getRequest()->getQueryParams();

        $action = lcfirst($componentName);
        try {
            $result = $this->{$action}($path, $queryParams);
        } catch (\Throwable $exception) {
            try {
                $component = $this->loadComponent($componentName);
            } catch (\Throwable $componentException) {
                if (Configure::read('debug')) {
                    die($exception->getTraceAsString());
                }
                throw new NotFoundException(
                    ServiceMessages::getMissingPageMessage()
                );
            }
        }

        if (isset($component) &&
            is_subclass_of($component, Component::class)) {
            $result = $component->handle($path, $queryParams);
        }

        $response = $this->getResponse();
        $response = $response->withStringBody(
            json_encode($result)
        );

        return $response;
    }

}
