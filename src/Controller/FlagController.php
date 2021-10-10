<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Utility\Inflector;

/**
 * Flag Controller
 *
 *
 * @method \App\Model\Entity\Flag[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FlagController extends AppController
{
    /**
     * Unread Flag method
     * - Flags a given record as unread
     * 
     * @param type $id
     * @return \Cake\Http\Response|void with json encoded string
     */
    public function index($id = null)
    {
        $tableName = Inflector::camelize($this->getRequest()->getQuery('_tn'));
        $scope = $this->getRequest()->getQuery('_scope');
        $flag = $this->getRequest()->getQuery('f');
        $response = $this->getResponse();
        $response = $response->withType('json');
        
        if ($id) {
            if ($this->_markAs($flag, $tableName, $id)) {
                $msg = ['status' => 'success'];
            } else {
                $msg = ['status' => 'error'];
            }
        }
        elseif ($tableName && $scope === 'all') {
            if ($this->_markAllAs($flag, $tableName)) {
                $msg = ['status' => 'success'];
            } else {
                $msg = ['status' => 'error'];
            }
        }
        $response = $response->withStringBody(json_encode($msg));
        
        return $response;
    }
    
    /**
     * Unread Flag method
     * - Flags a given record as unread
     *
     * @return \Cake\Http\Response|void
     */
//    public function unread($id = null)
//    {
//        $tableName = Inflector::classify($this->getRequest()->getQuery('_tn'));
//        $scope = $this->getRequest()->getQuery('_scope');
//        $user = $this->getActiveUser();
//        
//        if ($id) {
//            return $this->_markAs('unread', $tableName, $id);
//        }
//        if ($tableName && $scope === 'all') {
//            if ($this->_markAllAs('unread', $tableName)) {
//                return $this->redirect();
//            }
//        }
//    }

    protected function _markAs($type, $tableName, $id)
    {
        $types = [
            'read' => 1,
            'unread' => 0
        ];
        
        $Model = $this->getTableLocator()->get($tableName);
        $query = $Model->find('byRefid', ['refid' => $id])->limit(1);
        $result = $query->all()->toArray();
        $entity = $result[0];
        $entity = $Model->patchEntity($entity, ['is_read' => $types[$type]]);
        if ($Model->save($entity)) {
            return true;
        }
        
        return false;
    }
    
    protected function _markAllAs($type, $tableName)
    {
        $types = [
            'read' => 1,
            'unread' => 0
        ];
        $user = $this->getActiveUser();
        $Model = $this->getTableLocator()->get($tableName);
        $query = $Model->find('byUser', ['user' => $user->refid]);
        $entities = $query->toArray();
        
        $data = ['is_read' => $types[$type]];
        $callback = function(&$value, $index) use ($Model, $data) {
            $value = $Model->patchEntity($value, $data);
            
            // If any entity has errors that could stop it from saving,
            // then all should be stopped. It's either all saves or none.
            if ($value->hasErrors()) {
                return false;
            }
        };
        array_walk($entities, $callback);
        if ($Model->saveMany($entities)) {
            return true;
        }
        return false;
    }
}
