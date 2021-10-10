<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use App\Model\Table\AppTable;
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
class MessagesTable extends AppTable
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('messages');
        $this->setDisplayField('refid');
        $this->setPrimaryKey('refid');

        $this->addBehavior('Timestamp');
        
        $this->belongsTo('Users', [
            'foreignKey' => 'user_refid',
            'joinType' => 'INNER'
        ]);
        
        $this->belongsTo('Chats', [
            'foreignKey' => 'chat_refid',
            'joinType' => 'INNER'
        ]);
        
        $this->hasMany('MessageRecipients', [
            'foreignKey' => 'message_refid',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', true)
            ->add('id', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('refid')
            ->maxLength('refid', 20)
            ->requirePresence('refid', true)
            ->allowEmptyString('refid', 'create');

        $validator
            ->scalar('chat_refid')
            ->maxLength('chat_refid', 20)
            ->requirePresence('chat_refid', 'create')
            ->allowEmptyString('chat_refid', false);

        $validator
            ->scalar('recipients')
            ->maxLength('recipients', 4294967295)
            ->requirePresence('recipients', 'create')
            ->allowEmptyString('recipients', false);

        $validator
            ->scalar('user_refid')
            ->maxLength('user_refid', 20)
            ->requirePresence('user_refid', 'create')
            ->allowEmptyString('user_refid', false);

        $validator
            ->scalar('user_ip')
            ->maxLength('user_ip', 45)
            ->requirePresence('user_ip', 'create')
            ->allowEmptyString('user_ip', false);

        $validator
            ->scalar('user_location')
            ->maxLength('user_location', 255)
            ->allowEmptyString('user_location');

        $validator
            ->scalar('body')
            ->maxLength('body', 16777215)
            ->allowEmptyString('body');

        $validator
            ->scalar('has_attachment')
            ->requirePresence('has_attachment', 'create')
            ->allowEmptyString('has_attachment', false);

        $validator
            ->scalar('seen')
            ->allowEmptyString('seen');

        $validator
            ->scalar('is_read')
            ->allowEmptyString('is_read');

        $validator
            ->scalar('trashed_by')
            ->maxLength('trashed_by', 4294967295)
            ->allowEmptyString('trashed_by');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['id']));
        $rules->add($rules->existsIn('user_refid', 'Users'));
        $rules->add($rules->existsIn('chat_refid', 'Chats'));

        return $rules;
    }
}
