<?php

namespace App\Controller;

use App\Controller\AppController;

/**
 * ShortUrls Controller
 *
 * @property \App\Model\Table\ShortUrlsTable $ShortUrls
 *
 * @method \App\Model\Entity\ShortUrl[] paginate($object = null, array $settings = [])
 */
class ShortUrlsController extends AppController {

    public function initialize() {
        parent::initialize();
        
        $this->loadModel('ShortUrls');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index() {
        $shortUrls = $this->paginate($this->ShortUrls);

        $this->set(compact('shortUrls'));
        $this->set('_serialize', ['shortUrls']);
    }

    /**
     * View method
     *
     * @param string|null $id Short Url id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $shortUrl = $this->ShortUrls->get($id, [
            'contain' => []
        ]);

        $this->set('shortUrl', $shortUrl);
        $this->set('_serialize', ['shortUrl']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $shortUrl = $this->ShortUrls->newEntity();
        if ($this->request->is('post')) {
            $shortUrl = $this->ShortUrls->patchEntity($shortUrl, $this->request->getData());
            if ($this->ShortUrls->save($shortUrl)) {
                $this->Flash->success(__('The short url has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The short url could not be saved. Please, try again.'));
        }
        $this->set(compact('shortUrl'));
        $this->set('_serialize', ['shortUrl']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Short Url id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $shortUrl = $this->ShortUrls->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $shortUrl = $this->ShortUrls->patchEntity($shortUrl, $this->request->getData());
            if ($this->ShortUrls->save($shortUrl)) {
                $this->Flash->success(__('The short url has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The short url could not be saved. Please, try again.'));
        }
        $this->set(compact('shortUrl'));
        $this->set('_serialize', ['shortUrl']);
    }

    /**
     * Delete method
     *
     * @param array|null $codes Short Urls short codes
     * @param string|null $id Short Url id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(array $codes = null, $id = null) {
        $this->request->allowMethod(['post', 'delete']);
        if (!empty($codes)) {
            foreach ($codes as $code) {
                $query = $this->ShortUrls->find('all')->where(['ShortUrls.short_code =' => $code]);
                $result = $query->all();
                $result = $result->toArray();
                $data = $resutl[0];

                $entity = $this->ShortUrls->get($data->id);
                $this->ShortUrls->delete($entity);
            }
        }

        $shortUrl = $this->ShortUrls->get($id);
        if ($this->ShortUrls->delete($shortUrl)) {
            $this->Flash->success(__('The short url has been deleted.'));
        } else {
            $this->Flash->error(__('The short url could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    

}
