<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Achievements Model
 *
 * @method \App\Model\Entity\Achievement get($primaryKey, $options = [])
 * @method \App\Model\Entity\Achievement newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Achievement[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Achievement|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Achievement|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Achievement patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Achievement[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Achievement findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AchievementsTable extends Table
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

        $this->setTable('achievements');
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
            ->allowEmptyString('id', null);

        $validator
            ->scalar('refid')
            ->maxLength('refid', 20)
            ->requirePresence('refid', 'create')
            ->allowEmptyString('refid', null);

        $validator
            ->scalar('refkey')
            ->maxLength('refkey', 8)
            ->requirePresence('refkey', 'create')
            ->allowEmptyString('refkey', null);

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
            ->scalar('assisted_by')
            ->maxLength('assisted_by', 255)
            ->allowEmptyString('assisted_by');

        return $validator;
    }
}
