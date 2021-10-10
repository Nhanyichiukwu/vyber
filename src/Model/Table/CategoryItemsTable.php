<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\Collection\Collection;
use Cake\Collection\CollectionInterface;
use Cake\Datasource\ResultSetInterface;
use Cake\ORM\Locator\TableLocator;
use Cake\ORM\Query;
use Cake\ORM\ResultSet;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Utility\Inflector;
use Cake\Validation\Validator;

/**
 * CategoryItems Model
 *
 * @method \App\Model\Entity\CategoryItem get($primaryKey, $options = [])
 * @method \App\Model\Entity\CategoryItem newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CategoryItem[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CategoryItem|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CategoryItem|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CategoryItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CategoryItem[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CategoryItem findOrCreate($search, callable $callback = null, $options = [])
 */
class CategoryItemsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config):void
    {
        parent::initialize($config);

        $this->setTable('category_items');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Categories', [
            'foreignKey' => 'refid'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', 'create');

        $validator
            ->scalar('category_refid')
            ->maxLength('category_refid', 20)
            ->requirePresence('category_refid', 'create')
            ->allowEmptyString('category_refid', null);

        $validator
            ->scalar('item_foreign_key')
            ->maxLength('item_foreign_key', 20)
            ->requirePresence('item_foreign_key', 'create')
            ->allowEmptyString('item_foreign_key', null);

        $validator
            ->scalar('item_table_name')
            ->maxLength('item_table_name', 255)
            ->requirePresence('item_table_name', 'create')
            ->allowEmptyString('item_table_name', null);

        $validator
            ->scalar('item_type')
            ->maxLength('item_type', 45)
            ->requirePresence('item_type', 'create')
            ->allowEmptyString('item_type', null);

        $validator
            ->dateTime('date_added')
            ->requirePresence('date_added', 'create')
            ->allowEmptyDateTime('date_added', null);

        return $validator;
    }

    /**
     * Fetch all items for a single category and return their corresponding objects
     * This operation should return an instance of Cake\Collection\Iterator\ReplaceIterator
     * or CollectionInterface
     *
     * @param Query|ResultSetInterface $query
     * @return \Cake\Collection\Iterator\ReplaceIterator|CollectionInterface
     */
    public function getItemsInCategory($query)
    {
        return $query->map(function ($row) {
            $tableAlias = Inflector::camelize($row->item_table_name);
            $table = (new TableLocator())->get($tableAlias);
            $actualItem = $table->get($row->item_foreign_key);
            $row->set('item', $actualItem);
            return $row;
        });
    }
}
