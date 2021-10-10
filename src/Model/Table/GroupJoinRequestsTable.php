<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * GroupJoinRequests Model
 *
 * @property \App\Model\Table\GroupsTable&\Cake\ORM\Association\BelongsTo $Groups
 *
 * @method \App\Model\Entity\GroupJoinRequest newEmptyEntity()
 * @method \App\Model\Entity\GroupJoinRequest newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\GroupJoinRequest[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\GroupJoinRequest get($primaryKey, $options = [])
 * @method \App\Model\Entity\GroupJoinRequest findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\GroupJoinRequest patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\GroupJoinRequest[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\GroupJoinRequest|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\GroupJoinRequest saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\GroupJoinRequest[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\GroupJoinRequest[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\GroupJoinRequest[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\GroupJoinRequest[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class GroupJoinRequestsTable extends Table
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

        $this->setTable('group_join_requests');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Groups', [
            'foreignKey' => 'group_id',
            'joinType' => 'INNER',
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
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('user_refid')
            ->maxLength('user_refid', 20)
            ->requirePresence('user_refid', 'create')
            ->notEmptyString('user_refid');

        $validator
            ->scalar('status')
            ->allowEmptyString('status');

        $validator
            ->scalar('message')
            ->maxLength('message', 255)
            ->allowEmptyString('message');

        $validator
            ->scalar('appeal')
            ->maxLength('appeal', 255)
            ->allowEmptyString('appeal');

        $validator
            ->scalar('approved_by')
            ->maxLength('approved_by', 20)
            ->allowEmptyString('approved_by');

        $validator
            ->dateTime('approved_at')
            ->allowEmptyDateTime('approved_at');

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
        $rules->add($rules->existsIn(['group_id'], 'Groups'), ['errorField' => 'group_id']);

        return $rules;
    }
}
