<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * GroupInvites Model
 *
 * @property \App\Model\Table\GroupsTable&\Cake\ORM\Association\BelongsTo $Groups
 *
 * @method \App\Model\Entity\GroupInvite newEmptyEntity()
 * @method \App\Model\Entity\GroupInvite newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\GroupInvite[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\GroupInvite get($primaryKey, $options = [])
 * @method \App\Model\Entity\GroupInvite findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\GroupInvite patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\GroupInvite[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\GroupInvite|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\GroupInvite saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\GroupInvite[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\GroupInvite[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\GroupInvite[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\GroupInvite[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class GroupInvitesTable extends Table
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

        $this->setTable('group_invites');
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
            ->scalar('sender_refid')
            ->maxLength('sender_refid', 20)
            ->requirePresence('sender_refid', 'create')
            ->notEmptyString('sender_refid');

        $validator
            ->scalar('invitee_refid')
            ->maxLength('invitee_refid', 20)
            ->requirePresence('invitee_refid', 'create')
            ->notEmptyString('invitee_refid');

        $validator
            ->scalar('status')
            ->allowEmptyString('status');

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
