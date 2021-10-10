<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Table\BkpCategoriesTable;
use App\Utility\CustomMessages;
use Cake\Controller\Exception\MissingActionException;
use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\InternalErrorException;
use Cake\Http\Exception\NotFoundException;
use Cake\ORM\Query;
use Cake\Utility\Inflector;
use Cake\View\Exception\MissingTemplateException;

/**
 * Music Controller
 *
 *
// * @method \App\Model\Entity\Video[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
// * @method \App\Model\Entity\Audio[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
// * @method \App\Model\Entity\Category[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
// * @method \App\Model\Entity\CategoryItem[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array$settings =[])
 *
 * @property \App\Model\Table\BkpCategoriesTable $Categories;
 * @property \App\Model\Table\CategoryItemsTable $CategoryItems;
 * @property \App\Model\Table\VideosTable $Videos;
 * @property \App\Model\Table\AudiosTable $Audios;
 * @property \App\Model\Table\GenresTable $Genres;
 */
class MusicController extends AppController
{

    public function initialize(): void
    {
        parent::initialize();

        $this->loadModel('Audios');
        $this->loadModel('Videos');
        $this->loadModel('Categories');
        $this->loadModel('CategoryItems');

        $this->viewBuilder()->setTemplatePath('Medias/Music');

    }

    /**
     * Music listings
     * Includes audios and videos of both the current user's music and those of
     * their connections and those they follow and are connected to
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
//        $this->set('pageTitle','Hello');
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

        $pageTitle = ucfirst($page) . ' ' . ucfirst($subpage);

        $this->set(compact('page', 'subpage','pageTitle'));

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

    public function myMusic(...$path)
    {
        if (in_array('.', $path) || in_array('..', $path)) {
            throw new ForbiddenException();
        }
        $request = $this->getRequest();
        $tpl = Inflector::dasherize($request->getAttribute('params')['action']);

        if (count($path)) {
            $tpl .= '/' . implode('/', $path);
            try {
                $this->viewBuilder()->setTemplate($tpl);
            } catch (MissingTemplateException $templateError) {
                if (Configure::read('debug')) {
                    throw $templateError;
                }
                $msg = 'Oops! We looked everywhere, but could not find the page
                your looking for.';
                throw new NotFoundException($msg);
            } catch (\Exception $unknownError) {
                if (Configure::read('debug')) {
                    throw $unknownError;
                }
                $msg = 'We\'re so, so sorry! Looks like something went wrong
                while trying to process your request. Our engineers' .
                    ' have been notified of this error, and will fix it as soon
                    as possible';
                throw new InternalErrorException($msg);
            }
        }
    }

    /**
     * List of music categories
     *
     * @return void
     */
    public function categories():void
    {
        $query = $this->Categories->find('byType', ['type' => 'music']);
        $categories = $this->Categories->getItemsCount($query);

        $categories = $this->paginate($categories);
        $this->set(compact('categories'));
    }

    public function listCategoryItems($categorySlug)
    {
        try {
            $category = $this->Categories->find()->where(['slug' => $categorySlug])->firstOrFail();
        } catch (\Exception $exception) {
            if (Configure::read('debug')) {
                throw new $exception('Category Not Found');
            }
            throw new NotFoundException();
        }

        $query = $this->CategoryItems->find()
            ->where(['CategoryItems.category_refid' => $category->refid]);
        $resultSet = $this->paginate($query);

        $categoryItems = $this->CategoryItems->getItemsInCategory($resultSet)->toArray();

        $this->set(compact('category','categoryItems'));
    }

    public function artists()
    {

    }

    public function albums()
    {

    }

    public function genres()
    {

    }

    public function trends()
    {

    }

    public function discover()
    {

    }

    public function producers()
    {

    }

    public function directors()
    {

    }

    public function choreographers()
    {

    }

    public function lyricists()
    {

    }

    public function songWriters()
    {

    }

    /**
     * View method
     *
     * @param string|null $id Music id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $music = $this->Music->get($id, [
            'contain' => []
        ]);

        $this->set('music', $music);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $music = $this->Music->newEntity();
        if ($this->request->is('post')) {
            $music = $this->Music->patchEntity($music, $this->request->getData());
            if ($this->Music->save($music)) {
                $this->Flash->success(__('The music has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The music could not be saved. Please, try again.'));
        }
        $this->set(compact('music'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Music id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $music = $this->Music->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $music = $this->Music->patchEntity($music, $this->request->getData());
            if ($this->Music->save($music)) {
                $this->Flash->success(__('The music has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The music could not be saved. Please, try again.'));
        }
        $this->set(compact('music'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Music id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $music = $this->Music->get($id);
        if ($this->Music->delete($music)) {
            $this->Flash->success(__('The music has been deleted.'));
        } else {
            $this->Flash->error(__('The music could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    private function delegateRequest(array $path, $whereTo = 'action')
    {
        if (in_array('.', $path) || in_array('..', $path)) {
            throw new NotFoundException('Page Not Found!');
        }
        if ($whereTo === 'action') {
            $action = Inflector::camelize($path[0]);
            $action = lcfirst($action);
            if (!$this->hasAction($action)) {
                throw new NotFoundException();
            }
            return $this->setAction($action);
        }

    }
}
