<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use App\Model\Table\AppTable;
use Cake\Validation\Validator;

/**
 * UserInterests Model
 *
 * @method \App\Model\Entity\UserInterest get($primaryKey, $options = [])
 * @method \App\Model\Entity\UserInterest newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\UserInterest[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\UserInterest|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UserInterest|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UserInterest patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\UserInterest[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\UserInterest findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UserInterestsTable extends AppTable
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

        $this->setTable('user_interests');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_refid',
            'joinType' => 'INNER'
        ]);
        $this->hasOne('Posts', [
            'foreignKey' => 'object_refid',
            'joinType' => 'INNER',
            'joinType' => 'INNER'
        ]);
        $this->hasOne('Photos', [
            'foreignKey' => 'object_refid',
            'joinType' => 'INNER'
        ]);
        $this->hasOne('Videos', [
            'foreignKey' => 'object_refid',
            'joinType' => 'INNER'
        ]);
        $this->hasOne('Songs', [
            'foreignKey' => 'object_refid',
            'joinType' => 'INNER'
        ]);
        $this->hasOne('Movies', [
            'foreignKey' => 'object_refid',
            'joinType' => 'INNER'
        ]);
        $this->hasOne('Events', [
            'foreignKey' => 'object_refid',
            'joinType' => 'INNER'
        ]);
        $this->hasOne('Awards', [
            'foreignKey' => 'object_refid',
            'joinType' => 'INNER'
        ]);
        $this->hasOne('Nominations', [
            'foreignKey' => 'object_refid',
            'joinType' => 'INNER'
        ]);
        $this->hasOne('Achievements', [
            'foreignKey' => 'object_refid',
            'joinType' => 'INNER'
        ]);
        $this->hasOne('Albums', [
            'foreignKey' => 'object_refid',
            'joinType' => 'INNER'
        ]);
        $this->hasOne('Albums', [
            'foreignKey' => 'object_refid',
            'joinType' => 'INNER'
        ]);
        $this->hasOne('Albums', [
            'foreignKey' => 'object_refid',
            'joinType' => 'INNER'
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
            ->scalar('object_name')
            ->maxLength('object_name', 255)
            ->requirePresence('object_name', 'create')
            ->allowEmptyString('object_name', null);

        $validator
            ->scalar('object_refid')
            ->maxLength('object_refid', 20)
            ->requirePresence('object_refid', 'create')
            ->allowEmptyString('object_refid', null);

        $validator
            ->scalar('user_refid')
            ->maxLength('user_refid', 20)
            ->requirePresence('user_refid', 'create')
            ->allowEmptyString('user_refid', null);

        return $validator;
    }
}
