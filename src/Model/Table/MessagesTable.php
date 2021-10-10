<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Messages Model
 *
 * @method \App\Model\Entity\Message get($primaryKey, $options = [])
 * @method \App\Model\Entity\Message newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Message[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Message|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Message|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Message patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Message[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Message findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MessagesTable extends Table
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

        $this->setTable('messages');
        $this->setDisplayField('refid');
        $this->setPrimaryKey('refid');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Authors', [
            'foreignKey' => 'author_refid',
            'joinType' => 'INNER',
            'className' => 'Users'
        ]);

        $this->belongsTo('Chats', [
            'foreignKey' => 'chat_refid',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('OriginalMessages', [
            'foreignKey' => 'original_message_refid',
            'joinType' => 'LEFT',
            'className' => 'Messages'
        ]);

        $this->hasMany('Replies', [
            'foreignKey' => 'refid',
            'bindingKey' => 'original_message_refid',
            'joinType' => 'LEFT',
            'className' => 'Messages'
        ]);

        $this->hasMany('Conversations', [
            'foreignKey' => 'message_refid'
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
            ->allowEmptyString('refid', false);

        $validator
            ->scalar('chat_refid')
            ->maxLength('chat_refid', 20)
            ->requirePresence('chat_refid', 'create')
            ->allowEmptyString('chat_refid', false);

        $validator
            ->scalar('author_refid')
            ->maxLength('author_refid', 20)
            ->requirePresence('author_refid', 'create')
            ->allowEmptyString('author_refid', false);

        $validator
            ->scalar('author_ip')
            ->maxLength('author_ip', 45)
            ->allowEmptyString('author_ip');

        $validator
            ->scalar('author_location')
            ->maxLength('author_location', 255)
            ->allowEmptyString('author_location');

        $validator
            ->scalar('text')
            ->maxLength('text', 16777215)
            ->allowEmptyString('text');

        $validator
            ->scalar('original_message_refid')
            ->maxLength('original_message_refid', 20)
            ->allowEmptyString('original_message_refid');

        $validator
            ->boolean('has_attachment')
            ->allowEmptyString('has_attachment');

        $validator
            ->dateTime('message_time')
            ->requirePresence('message_time', 'create')
            ->allowEmptyDateTime('message_time', false);

        $validator
            ->scalar('is_seen')
            ->allowEmptyString('is_seen');

        $validator
            ->boolean('is_read')
            ->allowEmptyString('is_read');

        $validator
            ->boolean('is_reply')
            ->allowEmptyString('is_reply');

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
        $rules->add($rules->existsIn('author_refid', 'Users'));
        $rules->add($rules->existsIn('chat_refid', 'Chats'));

        return $rules;
    }



    public function findRead(Query $query, array $options) {
        return $query = $query
                ->contain(['Conversations' => ['Senders']])
                ->matching('Conversations', function ($q) use ($options) {
                    return $q->where([
                        'recipient_refid =' => $options['recipient'],
                        'Conversations.is_read =' => '1'
                    ]);
                });
    }

    public function findUnread(Query $query, array $options) {
        return $query = $query
                ->contain(['Conversations' => ['Senders']])
                ->matching('Conversations', function ($q) use ($options) {
                    return $q->where([
                        'recipient_refid' => $options['recipient'],
                        'Conversations.is_read' => '0',
                        'Conversations.is_trashed' => '0'
                    ]);
                });
    }

    public function findTrashed(Query $query, array $options) {
        return $query = $query
                ->contain(['Conversations' => ['Senders']])
                ->matching('Conversations', function ($q) use ($options) {
                    return $q->where([
                        'recipient_refid' => $options['recipient'],
                        'Conversations.is_trashed' => '1'
                    ]);
                });

    }

    public function findUntrashed(Query $query, array $options) {
        return $query = $query
                ->contain(['Conversations' => ['Senders']])
                ->matching('Conversations', function ($q) use ($options) {
                    return $q->where([
                        'recipient_refid' => $options['recipient'],
                        'Conversations.is_trashed' => '0'
                    ]);
                });
    }

    public function findArchived(Query $query, array $options) {
        return $query = $query
                ->contain(['Conversations' => ['Senders']])
                ->matching('Conversations', function ($q) use ($options) {
                    return $q->where([
                        'recipient_refid' => $options['recipient'],
                        'Conversations.archived' => '1'
                    ]);
                });
    }

    public function findUnarchived(Query $query, array $options) {
        return $query = $query
                ->contain(['Conversations' => ['Senders']])
                ->matching('Conversations', function ($q) use ($options) {
                    return $q->where([
                        'recipient_refid' => $options['recipient'],
                        'Conversations.archived' => '0'
                    ]);
                });
    }

    public function findSpam(Query $query, array $options) {
        return $query = $query
                ->contain(['Conversations' => ['Senders']])
                ->matching('Conversations', function ($q) use ($options) {
                    return $q->where([
                        'recipient_refid' => $options['recipient'],
                        'flag' => 'spam'
                    ]);
                });
    }

}
