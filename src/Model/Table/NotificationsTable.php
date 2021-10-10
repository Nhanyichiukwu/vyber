<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\Database\Expression\QueryExpression;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Notifications Model
 *
 * @method \App\Model\Entity\Notification get($primaryKey, $options = [])
 * @method \App\Model\Entity\Notification newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Notification[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Notification|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Notification|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Notification patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Notification[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Notification findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class NotificationsTable extends Table
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

        $this->setTable('notifications');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_refid'
        ]);
        $this->belongsTo('Initiators', [
            'foreignKey' => 'initiator_refid',
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
            ->requirePresence('id', 'create')
            ->allowEmptyString('id', null)
            ->add('id', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('refid')
            ->maxLength('refid', 20)
            ->requirePresence('refid', 'create')
            ->allowEmptyString('refid', null)
            ->add('refid', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('type')
            ->requirePresence('type', 'create')
            ->allowEmptyString('type', null);

        $validator
            ->scalar('user_refid')
            ->maxLength('user_refid', 20)
            ->requirePresence('user_refid', 'create')
            ->allowEmptyString('user_refid', null);

        $validator
            ->scalar('initiator_refid')
            ->maxLength('initiator_refid', 20)
            ->allowEmptyString('initiator_refid');

        $validator
            ->scalar('subject_source')
            ->maxLength('subject_source', 255)
            ->allowEmptyString('subject_source');

        $validator
            ->scalar('subject_refid')
            ->maxLength('subject_refid', 20)
            ->allowEmptyString('subject_refid');

        $validator
            ->scalar('subject_permalink')
            ->maxLength('subject_permalink', 255)
            ->allowEmptyString('subject_permalink');

        $validator
            ->scalar('message')
            ->maxLength('message', 255)
            ->requirePresence('message', 'create')
            ->allowEmptyString('message', null);

        $validator
            ->boolean('is_read')
            ->allowEmptyString('is_read');

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
        $rules->add($rules->isUnique(['refid']));
        $rules->add($rules->existsIn('initiator_refid', 'Users'));
        $rules->add($rules->existsIn('user_refid', 'Users'));

        return $rules;
    }

    /**
     *
     * @param Query $query
     * @param array $options
     * @return Query
     */
    public function findRead(Query $query, array $options = null)
    {
        return $query->where([
            'AND' => [
                'user_refid' => $options['for'],
                'is_read' => '1'
            ]
        ]);
    }

    /**
     *
     * @param Query $query
     * @param array $options
     * @return Query
     */
    public function findUnread(Query $query, array $options = null)
    {
        return $query->where([
            'AND' => [
                'user_refid' => $options['for'],
                'is_read' => '0'
            ]
        ]);
    }

    public function findAllForUser(Query $query, array $options)
    {
        $query = $query->where([
            'user_refid' => $options['for']
        ]);
        unset($options['for']);
        $query = $query->applyOptions($options);
        return $query;
    }

    /**
     * Organize results into three categories of unread, recent and older
     *
     * @param Query|null $query
     * @return Query
     */
    public function categorize(Query $query = null)
    {
        if (!$query) {
            $query = $this->find();
        }
        $query = $query->andWhere(function (QueryExpression $exp, Query $q) {
            return $exp->addCase(
                [
                    //  Unread notifications
                    $q->newExpr()->eq('Notifications.is_read', 0),

                    // Created between now and 4 days back, that has been read
                    $q->newExpr()->between(
                        'Notifications.created',
                        new \DateTime('now'),
                        new \DateTime('-4 days')
                    ),

                    // Older than 4 days back
                    $q->newExpr()->lt('Notifications.created', new \DateTime('-4 days'))
                ],
                ['unread', 'recent', 'older'],
                ['string', 'string', 'string']
            );
        });

//        //  Unread notifications
//        $unread = $query->newExpr()->eq('Notifications.is_read', 0, 'string');
//
//        // Recent notifications
//        $recent = $query->newExpr()->between(
//            'Notifications.created',
//            new \DateTime('now'),
//            new \DateTime('-4 days')
//        );
//
//        // Older notification
//        $older = $query->newExpr()->lt('Notifications.created', new \DateTime('-4 days'));
//        $query->select([
//            'unread' => $unread,
//            'recent' => $recent,
//            'older' => $older
//        ])
//            ->addDefaultTypes($this);
        return $query;
    }
}
