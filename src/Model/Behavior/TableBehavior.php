<?php
namespace App\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\ORM\Table;

/**
 * Table behavior
 */
class TableBehavior extends Behavior
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    
    public function initialize(array $config) {
        parent::initialize($config);
    }
    
    
}
