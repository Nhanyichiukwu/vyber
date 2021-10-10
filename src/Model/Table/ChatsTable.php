<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Chats Model
 *
 * @method \App\Model\Entity\Chat get($primaryKey, $options = [])
 * @method \App\Model\Entity\Chat newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Chat[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Chat|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Chat|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Chat patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Chat[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Chat findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ChatsTable extends Table
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

        $this->setTable('chats');
        $this->setDisplayField('refid');
        $this->setPrimaryKey('refid');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Initiators', [
            'foreignKey' => 'initiator_refid',
            'joinType' => 'INNER',
            'className' => 'Users'
        ]);

        $this->hasMany('Messages', [
            'foreignKey' => 'chat_refid',
            'joinType' => 'INNER'
        ]);

        $this->hasMany('Participants', [
            'foreignKey' => 'chat_refid',
//            'bindingKey' => 'chat_refid',
            'joinType' => 'INNER',
            'className' => 'ChatParticipants'
        ]);

        $this->hasOne('LastActiveParticipants', [
            'foreignKey' => 'refid',
            'bindingKey' => 'last_active_participant_refid',
            'joinType' => 'INNER',
            'className' => 'Users'
        ])
                ->setProperty('lastActiveParticipant');

        $this->hasOne('MostRecentMessages', [
            'foreignKey' => 'chat_refid',
            'joinType' => 'LEFT',
            'className' => 'Messages'
        ])
                ->setProperty('mostRecentMessage')
                ->find()
                ->orderDesc('MostRecentMessages.message_time')
                ->first();
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
            ->allowEmptyString('id')
            ->add('id', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('refid')
            ->maxLength('refid', 20)
            ->requirePresence('refid', 'create')
            ->allowEmptyString('refid', null);

        $validator
            ->scalar('title')
            ->maxLength('title', 255)
            ->allowEmptyString('title');

        $validator
            ->scalar('slug')
            ->maxLength('slug', 255)
            ->allowEmptyString('slug');

        $validator
            ->scalar('description')
            ->maxLength('description', 255)
            ->allowEmptyString('description');

        $validator
            ->scalar('initiator_refid')
            ->maxLength('initiator_refid', 20)
            ->requirePresence('initiator_refid', 'create')
            ->allowEmptyString('initiator_refid', null);

        $validator
            ->dateTime('start_time')
            ->requirePresence('start_time', 'create')
            ->allowEmptyDateTime('start_time', null);

        $validator
            ->dateTime('last_active_time')
            ->allowEmptyDateTime('last_active_time');

        $validator
            ->scalar('last_active_participant_refid')
            ->maxLength('last_active_participant_refid', 20)
            ->allowEmptyString('last_active_participant_refid');

        $validator
            ->scalar('chattype')
            ->requirePresence('chattype', 'create')
            ->allowEmptyString('chattype', null);

        $validator
            ->scalar('avatar')
            ->maxLength('avatar', 255)
            ->allowEmptyString('avatar');

        $validator
            ->scalar('group_accessibility')
            ->allowEmptyString('group_accessibility');

        $validator
            ->scalar('group_scalability')
            ->allowEmptyString('group_scalability');

        $validator
            ->integer('max_participants')
            ->allowEmptyString('max_participants');

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
        $rules->add($rules->isUnique(['id']));

        return $rules;
    }
}
