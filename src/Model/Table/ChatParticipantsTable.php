<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ChatParticipants Model
 *
 * @method \App\Model\Entity\ChatParticipant get($primaryKey, $options = [])
 * @method \App\Model\Entity\ChatParticipant newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ChatParticipant[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ChatParticipant|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ChatParticipant|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ChatParticipant patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ChatParticipant[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ChatParticipant findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ChatParticipantsTable extends Table
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

        $this->setTable('chat_participants');
        $this->setDisplayField('chat_refid');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Correspondents', [
            'foreignKey' => 'participant_refid',
//            'bindingKey' => 'participant_refid',
            'joinType' => 'INNER',
            'className' => 'Users'
        ]);

        $this->belongsTo('Chats', [
            'foreignKey' => 'chat_refid',
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
            ->allowEmptyString('id');

        $validator
            ->scalar('chat_refid')
            ->maxLength('chat_refid', 20)
            ->requirePresence('chat_refid', 'create')
            ->allowEmptyString('chat_refid', null);

        $validator
            ->scalar('participant_refid')
            ->maxLength('participant_refid', 20)
            ->requirePresence('participant_refid', 'create')
            ->allowEmptyString('participant_refid', null);

        $validator
            ->scalar('added_by')
            ->maxLength('added_by', 20)
            ->allowEmptyString('added_by');

        $validator
            ->dateTime('date_added')
            ->allowEmptyDateTime('date_added');

        $validator
            ->boolean('is_admin')
            ->allowEmptyString('is_admin');

        $validator
            ->boolean('previously_engaged_in')
            ->allowEmptyString('previously_engaged_in');

        return $validator;
    }

    public function findUserParticipatedChats(Query $query, array $options) {
        return $query->where(['participant_refid' => $options['user']]);
    }
}
