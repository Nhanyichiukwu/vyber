<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CategoryTypes Model
 *
 * @method \App\Model\Entity\CategoryType newEmptyEntity()
 * @method \App\Model\Entity\CategoryType newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\CategoryType[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CategoryType get($primaryKey, $options = [])
 * @method \App\Model\Entity\CategoryType findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\CategoryType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CategoryType[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\CategoryType|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CategoryType saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CategoryType[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CategoryType[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\CategoryType[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CategoryType[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CategoryTypesTable extends Table
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

        $this->setTable('category_types');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 100)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('slug')
            ->maxLength('slug', 150)
            ->requirePresence('slug', 'create')
            ->notEmptyString('slug');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        return $validator;
    }
}
