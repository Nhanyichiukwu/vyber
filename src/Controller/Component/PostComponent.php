<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;

/**
 * Post component
 */
class PostComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    
    public function pull() 
    {
        $postID;
    }
    
    /**
     * This method runs upon initialisation, to read the request query parameters  
     * and validates its values, before any method is called/executed
     * 
     * @return $this
     * @throws BadRequestException
     * @throws RecordNotFoundException
     */
    protected function _queryParamsHook() 
    {
        $request = $this->getController()->getRequest();
        $base64_encoded = $request->getQuery('token');
        if ($base64_encoded == null) {
            throw new BadRequestException();
        }
        $base64_decode = base64_decode($base64_encoded);
        $strToArr = explode('_', $base64_decode);
        $userid = substr($strToArr[1], 0, 20);
        
        try {
            $profile = $this->Users->getUser($userid);
        } catch (RecordNotFoundException $ex) {
            throw $ex;
        }
        
        $this->_postID = $postID;
        
        return $this;
    }
}
