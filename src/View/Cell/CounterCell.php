<?php
namespace App\View\Cell;

use Cake\Utility\Inflector;
use Cake\View\Cell;

/**
 * Counter cell
 */
class CounterCell extends Cell
{
    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    /**
     * @param string $what
     * @param array $args
     */
    public function count(string $what, array $args)
    {
        $method = Inflector::camelize($what);
        $contentLoader = new ContentLoaderCell($this->request, $this->response);
        $result = call_user_func_array([$contentLoader, $method], $args);
        $count = null;
        if (!is_null($result)) {
            $count = $result->count();
        }

        $this->set('count', $count);
    }


}
