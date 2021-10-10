<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ContentShare Controller
 *
 * @property \App\Controller\Component\PostsManagerComponent $PostsManager The post manager component
 *
 * @method \App\Model\Entity\ContentShare[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ContentsController extends AppController
{

    public function initialize() {
        parent::initialize();
        
        $this->loadComponent('PostsManager');
        $this->loadComponent('Status');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index(...$path)
    {
        $this->autoRender = false;
        $request = $this->getRequest();
    }
    
    public function share()
    {
        $user = $this->getActiveUser();
        $request = $this->getRequest();
        $intent = $this->getRequest()->getQuery('intent');
        $action = '_' . $intent;
        if ($this->hasAction($action)) {
            return $this->$action();
        }
        
        // http://localhost/musicsound/contents/share?intent=share&type=page&text=This+is+an+exerpt+of+the+post&url=http://example.com/news/politics/all-about-the-death-of-the-nigerian-president
    }
    
    protected function _adopt()
    {
        $this->autoRender = false;
        $request = $this->getRequest();
        $response = $this->getResponse();
        $pID = $request->getQuery('p_id');
        $permalink = $request->getAttribute('base') . '/post/' . $pID . '?_vm=contained';
        $referer = $request->referer();
        $shareSrc = $request->getQuery('s_src');
        $sharedPost = $this->PostsManager->getPost($pID);
        
        $msg = '';
        $msgType = 'success';
        if ($this->Status->sharePost($sharedPost)) {
            $msg = ucfirst($sharedPost->type) . ' shared to your wall...'; //$this->Flash->success(__());
        } else {
            $msg = 'Oops! Something went wrong. Could not share post.'; //$this->Flash->success(__());
            $msgType = 'error';
        }
        
        if ($request->is('ajax')) {
            $data = [];
            $data[$msgType] = $msg;
            $jsonData = json_encode($data);
            return $response->withType('json')->withStringBody($jsonData);
        }
        
        $this->Flash->{$msgType}(__($msg));
        return $this->redirect($referer . '#' . $shareSrc);
    }

    protected function _post()
    {
        $request = $this->getRequest();
        //$request->allowMethod(['post','put']);
        $referer = (object) parse_url($request->referer(true));

        if (property_exists($referer, 'host') && property_exists($referer, 'scheme')) {
            if ($referer->host !== 'localhost' && $referer->scheme !== 'https') {
                throw new \Cake\Http\Exception\ForbiddenException('Request not accepted from sites with no trusted ssl. Only sites with https protocol are allowed.');
            }
        }
        
        $statusText = $request->getQuery('text');
        $url = $request->getQuery('url');
        
        $this->set(compact('statusText', 'url'));
    }

    protected function _message()
    {
        
    }
    
    protected function _shareWithComment()
    {
        
    }
    
    protected function _quote()
    {
        
    }
    
    protected function _cite()
    {
        
    }

    /**
     * View method
     *
     * @param string|null $id Content Share id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $contentShare = $this->ContentShare->get($id, [
            'contain' => []
        ]);

        $this->set('contentShare', $contentShare);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $contentShare = $this->ContentShare->newEntity();
        if ($this->request->is('post')) {
            $contentShare = $this->ContentShare->patchEntity($contentShare, $this->request->getData());
            if ($this->ContentShare->save($contentShare)) {
                $this->Flash->success(__('The content share has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The content share could not be saved. Please, try again.'));
        }
        $this->set(compact('contentShare'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Content Share id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $contentShare = $this->ContentShare->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $contentShare = $this->ContentShare->patchEntity($contentShare, $this->request->getData());
            if ($this->ContentShare->save($contentShare)) {
                $this->Flash->success(__('The content share has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The content share could not be saved. Please, try again.'));
        }
        $this->set(compact('contentShare'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Content Share id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $contentShare = $this->ContentShare->get($id);
        if ($this->ContentShare->delete($contentShare)) {
            $this->Flash->success(__('The content share has been deleted.'));
        } else {
            $this->Flash->error(__('The content share could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
