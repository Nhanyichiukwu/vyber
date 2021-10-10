<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Categories Model
 *
 * @method \App\Model\Entity\Category get($primaryKey, $options = [])
 * @method \App\Model\Entity\Category newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Category[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Category|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Category|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Category patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Category[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Category findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BkpCategoriesTable extends Table
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

        $this->setTable('categories');
        $this->setDisplayField('name');
        $this->setPrimaryKey('refid');

        $this->addBehavior('Timestamp');

        $this->hasMany('Items', [
            'foreignKey' => 'category_refid',
            'className' => 'CategoryItems'
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
            ->requirePresence('id', 'create')
            ->allowEmptyString('id', null);

        $validator
            ->scalar('refid')
            ->maxLength('refid', 20)
            ->allowEmptyString('refid', 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->allowEmptyString('name', null);

        $validator
            ->scalar('slug')
            ->maxLength('slug', 255)
            ->requirePresence('slug', 'create')
            ->allowEmptyString('slug', null);

        $validator
            ->scalar('description')
            ->maxLength('description', 16777215)
            ->allowEmptyString('description');

        $validator
            ->scalar('parent')
            ->maxLength('parent', 20)
            ->allowEmptyString('parent');

        $validator
            ->scalar('type')
            ->requirePresence('type', 'create')
            ->allowEmptyString('type', null);

        $validator
            ->scalar('thumbnail')
            ->maxLength('thumbnail', 255)
            ->allowEmptyString('thumbnail');

        $validator
            ->integer('views')
            ->allowEmptyString('views');

        return $validator;
    }

    public function findByType(Query $query, array $options)
    {
        return $query->where(['Categories.type' => $options['type']]);
    }

    /**
     * Count total items in each category in the resultset
     *
     * @param Query $query
     * @return Query
     */
    public function getItemsCount(Query $query)
    {
        $query->select(['items_count' => $query->func()->count('Items.id')])
            ->leftJoinWith('Items')
            ->enableAutoFields(true);
        return $query;
    }
}
