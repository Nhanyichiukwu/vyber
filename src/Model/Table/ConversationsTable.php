<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Conversations Model
 *
 * @method \App\Model\Entity\Conversation get($primaryKey, $options = [])
 * @method \App\Model\Entity\Conversation newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Conversation[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Conversation|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Conversation|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Conversation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Conversation[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Conversation findOrCreate($search, callable $callback = null, $options = [])
 */
class ConversationsTable extends Table
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

        $this->setTable('conversations');
        $this->setDisplayField('refid');
        $this->setPrimaryKey('refid');

        $this->belongsTo('Chats', [
            'foreignKey' => 'chat_refid',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('Messages', [
            'foreignKey' => 'message_refid',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('Senders', [
            'foreignKey' => 'sender_refid',
            'joinType' => 'INNER',
            'className' => 'Users'
        ]);

        $this->belongsTo('Recipients', [
            'foreignKey' => 'recipient_refid',
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
            ->allowEmptyString('id')
            ->add('id', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('refid')
            ->maxLength('refid', 20)
            ->requirePresence('refid', 'create')
            ->allowEmptyString('refid', 'create');
//            ->add('refid', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('chat_refid')
            ->maxLength('chat_refid', 20)
            ->requirePresence('chat_refid', 'create')
            ->allowEmptyString('chat_refid', null);

        $validator
            ->scalar('message_refid')
            ->maxLength('message_refid', 20)
            ->requirePresence('message_refid', 'create')
            ->allowEmptyString('message_refid', null);

        $validator
            ->scalar('sender_refid')
            ->maxLength('sender_refid', 20)
            ->requirePresence('sender_refid', 'create')
            ->allowEmptyString('sender_refid', null);

        $validator
            ->scalar('recipient_refid')
            ->maxLength('recipient_refid', 20)
            ->allowEmptyString('recipient_refid');

        $validator
            ->boolean('is_read')
            ->allowEmptyString('is_read');

        $validator
            ->boolean('is_trashed')
            ->allowEmptyString('is_trashed');

        $validator
            ->scalar('flag')
            ->allowEmptyString('flag');

        $validator
            ->boolean('archived')
            ->allowEmptyString('archived');

        $validator
            ->dateTime('message_time')
            ->requirePresence('message_time', 'create')
            ->allowEmptyDateTime('message_time', null);

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
//        $rules->add($rules->isUnique(['refid']));
        $rules->add($rules->isUnique(['id']));

        return $rules;
    }
}
