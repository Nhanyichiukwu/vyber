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
 * @property \App\Model\Table\CategoryTypesTable&\Cake\ORM\Association\BelongsTo $CategoryTypes
 *
 * @method \App\Model\Entity\Category newEmptyEntity()
 * @method \App\Model\Entity\Category newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Category[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Category get($primaryKey, $options = [])
 * @method \App\Model\Entity\Category findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Category patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Category[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Category|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Category saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Category[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Category[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Category[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Category[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CategoriesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('categories');
        $this->setDisplayField('name');
        $this->setPrimaryKey('refid');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ParentCategories', [
            'className' => 'Categories',
            'foreignKey' => 'parent_refid',
        ]);

        $this->hasMany('ChildCategories', [
            'className' => 'Categories',
            'foreignKey' => 'parent_refid',
        ]);

        $this->belongsTo('CategoryTypes', [
            'foreignKey' => 'type_id',
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
            ->notEmptyString('id');

        $validator
            ->scalar('refid')
            ->maxLength('refid', 20)
            ->allowEmptyString('refid', null, 'create');

        $validator
            ->scalar('parent_refid')
            ->maxLength('parent_refid', 20)
            ->allowEmptyString('parent_refid');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('slug')
            ->maxLength('slug', 255)
            ->requirePresence('slug', 'create')
            ->notEmptyString('slug');

        $validator
            ->scalar('description')
            ->maxLength('description', 16777215)
            ->allowEmptyString('description');

        $validator
            ->scalar('thumbnail')
            ->maxLength('thumbnail', 255)
            ->allowEmptyString('thumbnail');

        $validator
            ->integer('views')
            ->allowEmptyString('views');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['parent_refid'], 'ParentCategories'), ['errorField' => 'parent_refid']);
        $rules->add($rules->existsIn(['type_id'], 'CategoryTypes'), ['errorField' => 'type_id']);

        return $rules;
    }

    public function findByType(Query $query, array $options)
    {
        return $query->matching('CategoryTypes', function (Query $q)
        use ($options) {
            return $q->where([
                'CategoryTypes.slug' => $options['type']
            ]);
        });
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
