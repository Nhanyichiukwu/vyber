<?php
namespace App\View\Cell;

use Cake\ORM\Query;
use Cake\View\Cell;
use Cake\Datasource\Paginator;
use Cake\Utility\Text;
use Cake\Utility\Inflector;

/**
 * Counter cell
 */
class NotificationsCell extends Cell
{

    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    /**
     * Initialization logic run at the end of object construction.
     *
     * @return void
     */
    public function initialize()
    {
    }

    /**
     * Default display method.
     *
     * @return void
     */
    public function display()
    {

    }

    public function count($data_type, $user)
    {
        $data_type = Inflector::camelize($data_type, '_');
        $getData = '_' . $data_type;
        $data = $this->$getData($user);

        $this->set('dataCount', $data->count());
    }

    public function listItems($data_type, $user, $quantity = 5)
    {
        $dataType = Inflector::camelize($data_type, '_');
        $getItems = '_' . $dataType;
        $result = $this->$getItems($user);
        $settings = [ 'limit' => $quantity, 'maxLimit' => 100 ];
        $items = (new Paginator())->paginate($result, $settings)->toArray();

        array_walk($items, function (&$value, $index) {
            $value->sender = $this->getTableLocator()
                    ->get('Users')
                    ->getUser($value->initiator_refid);
        });

//        $this->viewBuilder()->setTemplate('list_' . $data_type);
        $this->set(['items' => $items, 'data_type' => $data_type]);
    }


}
