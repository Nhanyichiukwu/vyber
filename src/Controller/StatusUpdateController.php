<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * StatusUpdate Controller
 *
 *
 * @method \App\Model\Entity\StatusUpdate[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class StatusUpdateController extends AppController
{

    public function initialize() {
        parent::initialize();
        
        $this->loadModel('Posts');
        //$this->loadModel('ost_attachments');
        
//        $this->loadComponent('User', [
//            'user' => $this->getActiveUser()
//        ]);
        $this->loadComponent('Status', [
            'user' => $this->getActiveUser(),
            'Posts' => $this->Posts
        ]);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     * ?utm_submit_type=sync&utm_source=mobile&has_attach=false
     */
    public function index()
    {
        $request = $this->getRequest();
        $session = $request->getSession();
        
        $request->allowMethod(['post','ajax']);

        $this->autoRender = false;
        if ($request->is('ajax'))
        {
            return $this->_useAjax();
        } else {
            return $this->_useDefault();
        }
        
        // $this->set(compact('statusUpdate'));
    }
    
    private function _useAjax()
    {
        $response = $this->getResponse();
        $response = $response->withType('json');
        $msg = [];
        $responseCode = 404;
        
        if ( !$this->Status->publish()) {
            $msg = [
                'message' => $this->Status->getPostError() . ' ' . $this->Status->getAttachmentsError()
            ];
            $responseCode = 304;
        } else {
            $msg = [
                'message' => $this->Status->getPostError() . ' ' . $this->Status->getAttachmentsError()
            ];
            $responseCode = 200;
        }
        
        $json_str = json_encode($msg);
        $response = $response
                ->withStatus($responseCode, $msg['message'])
                ->withStringBody($json_str);

        return $response;
    }
    
    private function _useDefault()
    {
        $request = $this->getRequest();
        $response = $this->getResponse();
        
        if ( !$this->Status->publish() )
            $this->Flash->error(__($this->Status->getMessage()));
        else
            $this->Flash->success(__($this->Status->getMessage()));

        return $this->redirect($request->referer(true));
    }
}
