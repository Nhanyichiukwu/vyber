<?php
declare(strict_types=1);

namespace App\Model\Behavior;

use Cake\Database\Expression\QueryExpression;
use Cake\ORM\Behavior;
use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Utility\Inflector;

/**
 * Common behavior
 */
class CommonBehavior extends Behavior
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

//    public function initialize(array $config): void
//    {
//        parent::initialize($config);
//    }

    /**
     *
     * @param \Cake\ORM\Query $query
     * @param string $datefield
     * @return \Cake\ORM\Query $query
     */
    public function dateFormat(Query $query, $datefield = 'created')
    {
        $datetime = $query
                ->func()
                ->date_format([
                    "{$datefield}" => 'identifier',
                    "'%Y-%m-%d %H:%i:%s'" => 'literal'
                ]);
        $year = $query
                ->func()
                ->year([
                    "{$datefield}" => 'identifier'
                ]);
        $month = $query
                ->func()
                ->date_format([
                    "{$datefield}" => 'identifier',
                    "'%m'" => 'literal'
                ]);
        $day = $query
                ->func()
                ->date_format([
                    "{$datefield}" => 'identifier',
                    "'%d'" => 'literal'
                ]);
        $time = $query
                ->func()
                ->date_format([
                    "{$datefield}" => 'identifier',
                    "'%H:%i:%s'" => 'literal'
                ]);
        $query = $query
                ->select([
                    'date' => $datetime,
                    'year' => $year,
                    'month' => $month,
                    'day' => $day,
                    'time' => $time
                ]);
        $query = $query->enableAutoFields();

        return $query;
    }

    public function applyFilter(Query $query, $filter)
    {
        switch ($filter)
        {
            case 'read':
                $query = $query->where(['read' => '1', 'trashed' => '0']);
                break;
            case 'unread':
                $query = $query->where(['read' => '0', 'trashed' => '0']);
                break;
            case 'trashed':
                $query = $query->where(['trashed' => '1']);
                break;
            case 'trashed_read':
                $query = $query->where(['trashed' => '1', 'read' => '1']);
                break;
            case 'trashed_unread':
                $query = $query->where(['trashed' => '1', 'read' => '0']);
                break;
            case 'seen':
                $query = $query->where(['seen' => '1', 'trashed' => '0']);
                break;
            case 'has_attachment':
                $query = $query->where(['has_attachment' => '1', 'trashed' => '0']);
                break;
            case 'has_attachment_trashed':
                $query = $query->where(['has_attachment' => '1', 'trashed' => '1']);
                break;
            default:
                throw new Exception('Invalid filter parameter supplied to Table::applyFilter()');
        }

        return $query;
    }

    public function sortByDateCreated(array $result_set, $field_name = null)
    {
        if ($field_name === null)
            $field_name = 'created';
        return usort($result_set, function($a, $b) {
            $date1 = strtotime($a->{$field_name});
            $date2 = strtotime($b->{$field_name});

            return $date1 <=> $date2;
        });
    }

    public function findByField( Query $query, array $options)
    {
//        return $query->where([__('{table}.{field}', ['table' => $Table, 'field' => $options['field']]) => $options['value']]);
        $Table = get_called_class();
        return $query->where([__('{table}.{field}', ['table' => $Table, 'field' => $options['field']]) => $options['value']]);
    }

//    public function findByRefid($refid)
//    {
//        $result = $this->find('all')->where(['refid' => $refid])->limit(1);
//        if ($result->count() < 1) {
//            throw new \Cake\Datasource\Exception\RecordNotFoundException();
//        }
//        return $result->toArray()[0];
//    }

    public function findByRefid(Query $query, array $options = [])
    {
        $query = $query->where(['refid' => $options['refid']]);

        return $query;
    }


    public function findByUser(Query $query, array $options = [])
    {
        ;
    }


    public function sortByDateModified(array $result_set)
    {
        return usort($result_set, function($a, $b) {
            $date1 = strtotime($a->modified);
            $date2 = strtotime($b->modified);

            return $date1 <=> $date2;
        });
    }

    public function loopThrough(array $values, $operator, $field)
    {
        $result = [];
        foreach ($values as $value) {
            $result[$field . ' ' . $operator] = $value;
        }

        return $result;
    }

}
