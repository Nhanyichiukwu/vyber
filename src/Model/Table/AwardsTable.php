<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Awards Model
 *
 * @method \App\Model\Entity\Award get($primaryKey, $options = [])
 * @method \App\Model\Entity\Award newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Award[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Award|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Award|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Award patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Award[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Award findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AwardsTable extends Table
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

        $this->setTable('awards');
        $this->setDisplayField('title');
        $this->setPrimaryKey('refid');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_refid',
            'joinType' => 'INNER',
            'className' => 'Users'
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
            ->allowEmptyString('id');

        $validator
            ->scalar('refid')
            ->maxLength('refid', 20)
            ->requirePresence('refid', 'create')
            ->allowEmptyString('refid', 'create');

        $validator
            ->scalar('user_refid')
            ->maxLength('user_refid', 20)
            ->requirePresence('user_refid', 'create')
            ->allowEmptyString('user_refid', null);

        $validator
            ->scalar('title')
            ->maxLength('title', 255)
            ->requirePresence('title', 'create')
            ->allowEmptyString('title', null);

        $validator
            ->scalar('description')
            ->maxLength('description', 255)
            ->allowEmptyString('description');

        $validator
            ->dateTime('date')
            ->requirePresence('date', 'create')
            ->allowEmptyDateTime('date', null);

        $validator
            ->scalar('awarded_by')
            ->maxLength('awarded_by', 255)
            ->requirePresence('awarded_by', 'create')
            ->allowEmptyString('awarded_by', null);

        $validator
            ->scalar('subject')
            ->maxLength('subject', 255)
            ->requirePresence('subject', 'create')
            ->allowEmptyString('subject', null);

        return $validator;
    }
}
