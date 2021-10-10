<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * GroupMembers Model
 *
 * @property \App\Model\Table\GroupsTable&\Cake\ORM\Association\BelongsTo $Groups
 *
 * @method \App\Model\Entity\GroupMember newEmptyEntity()
 * @method \App\Model\Entity\GroupMember newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\GroupMember[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\GroupMember get($primaryKey, $options = [])
 * @method \App\Model\Entity\GroupMember findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\GroupMember patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\GroupMember[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\GroupMember|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\GroupMember saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\GroupMember[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\GroupMember[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\GroupMember[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\GroupMember[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class GroupMembersTable extends Table
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

        $this->setTable('group_members');

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
            ->scalar('user_refid')
            ->maxLength('user_refid', 20)
            ->requirePresence('user_refid', 'create')
            ->notEmptyString('user_refid');

        $validator
            ->scalar('invited_by')
            ->maxLength('invited_by', 20)
            ->allowEmptyString('invited_by');

        $validator
            ->scalar('status')
            ->allowEmptyString('status');

        $validator
            ->dateTime('invited_at')
            ->allowEmptyDateTime('invited_at');

        $validator
            ->scalar('approved_by')
            ->maxLength('approved_by', 20)
            ->allowEmptyString('approved_by');

        $validator
            ->dateTime('approved_at')
            ->allowEmptyDateTime('approved_at');

        $validator
            ->boolean('is_admin')
            ->allowEmptyString('is_admin');

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
