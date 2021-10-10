<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MessageBoxes Model
 *
 * @method \App\Model\Entity\MessageBox get($primaryKey, $options = [])
 * @method \App\Model\Entity\MessageBox newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MessageBox[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MessageBox|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MessageBox|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MessageBox patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MessageBox[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MessageBox findOrCreate($search, callable $callback = null, $options = [])
 */
class MessageBoxesTable extends Table
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

        $this->setTable('message_boxes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
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
            ->scalar('refid')
            ->maxLength('refid', 20)
            ->requirePresence('refid', 'create')
            ->allowEmptyString('refid', null)
            ->add('refid', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

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
            ->scalar('box')
            ->requirePresence('box', 'create')
            ->allowEmptyString('box', null);

        $validator
            ->boolean('is_seen')
            ->allowEmptyString('is_seen');

        $validator
            ->boolean('is_read')
            ->allowEmptyString('is_read');

        $validator
            ->boolean('is_trashed')
            ->allowEmptyString('is_trashed');

        $validator
            ->boolean('is_spam')
            ->allowEmptyString('is_spam');

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
        $rules->add($rules->isUnique(['refid']));

        return $rules;
    }

    public function findUnreadMessages(Query $query, array $options)
    {
        return $query->where(
                [
                    'recipient_refid' => $options['recipient'],
                    'box' => 'received',
                    'is_read' => 0,
                    'is_trashed' => 0,
                    'archived' => 0
                ]);
    }
}
