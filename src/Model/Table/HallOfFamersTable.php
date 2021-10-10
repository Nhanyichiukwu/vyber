<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * HallOfFamers Model
 *
 * @method \App\Model\Entity\HallOfFamer newEmptyEntity()
 * @method \App\Model\Entity\HallOfFamer newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\HallOfFamer[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\HallOfFamer get($primaryKey, $options = [])
 * @method \App\Model\Entity\HallOfFamer findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\HallOfFamer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\HallOfFamer[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\HallOfFamer|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\HallOfFamer saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\HallOfFamer[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\HallOfFamer[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\HallOfFamer[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\HallOfFamer[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class HallOfFamersTable extends Table
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

        $this->setTable('hall_of_famers');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users');
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
            ->scalar('user_refid')
            ->maxLength('user_refid', 20)
            ->requirePresence('user_refid', 'create')
            ->notEmptyString('user_refid');

        $validator
            ->scalar('status')
            ->allowEmptyString('status', null, 'create');

        return $validator;
    }
}
