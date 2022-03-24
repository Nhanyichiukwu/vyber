<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\Notification;
use Cake\Core\Configure;
use Cake\Database\Expression\QueryExpression;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Behavior\TimestampBehavior;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use DateTime;

/**
 * Notifications Model
 *
 * @method Notification get($primaryKey, $options = [])
 * @method Notification newEntity($data = null, array $options = [])
 * @method Notification[] newEntities(array $data, array $options = [])
 * @method Notification|bool save(EntityInterface $entity, $options = [])
 * @method Notification|bool saveOrFail(EntityInterface $entity, $options = [])
 * @method Notification patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method Notification[] patchEntities($entities, array $data, array $options = [])
 * @method Notification findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin TimestampBehavior
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
     * @param Validator $validator Validator instance.
     * @return Validator
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

        $validator
            ->boolean('is_seen')
            ->allowEmptyString('is_seen');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param RulesChecker $rules The rules object to be modified.
     * @return RulesChecker
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
            'user_refid' => $options['user'],
            'is_read' => '1'
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
            'Notifications.user_refid' => $options['user'],
            'Notifications.is_read' => '0'
        ]);
    }

    /**
     *
     * @param Query $query
     * @param array $options
     * @return Query
     */
    public function findUnseen(Query $query, array $options = null)
    {
        return $query->where([
            'Notifications.user_refid' => $options['user'],
            'Notifications.is_seen' => '0'
        ]);
    }

    public function findAllForUser(Query $query, array $options)
    {
        $query = $query->where([
            'Notifications.user_refid' => $options['user']
        ]);
        unset($options['user']);
        $query = $query->applyOptions($options);
        return $query;
    }

    /**
     * Organize results into three categories of unread, recent and older
     *
     * @param Query|null $query
     * @return array
     */
    public function categorize(Query $query = null)
    {
        if (!$query) {
            $query = $this->find();
        }
        /**
         * First Approach: Requires reimplementation
         * Do not remove
         */
//        $query = $query->where(function (QueryExpression $exp, Query $q) {
//            return $exp->addCase(
//                [
//                    //  Unread notifications
//                    $q->newExpr()->eq('Notifications.is_read', 0),
//
//                    // Created between now and 4 days back, that has been read
//                    $q->newExpr()->between(
//                        'Notifications.created',
//                        new \DateTime('-4 days'),
//                        new \DateTime('now')
//                    ),
//
//                    // Older than 4 days back
//                    $q->newExpr()->lt('Notifications.created', new \DateTime('-4 days'))
//                ],
//                ['unread', 'recent', 'older'],
//                ['string', 'string', 'string']
//            );
//        });

        /*************** Second Approach ************/
//        //  Unread notifications
//        $unread = $query->newExpr()
//            ->eq('Notifications.is_read', 0, 'string');
//
//        // Recent notifications
//        $recent = $query->newExpr()->between(
//            'Notifications.created',
//            new \DateTime('now'),
//            new \DateTime('-4 days')
//        );
//
//        // Older notification
//        $older = $query->newExpr()
//            ->lt('Notifications.created', new \DateTime('-4 days'));
//        $query->select([
//            'unread' => $unread,
//            'recent' => $recent,
//            'older' => $older
//        ]);

        // Today notifications
        $hoursSinceMidnight = date('H');
        $recent = $query->newExpr()->between(
            'Notifications.created',
            new DateTime('now'),
            new DateTime("-{$hoursSinceMidnight} hours")
        );

        //  Yesterday notifications
        $yesterday = $query->newExpr()
            ->eq('Notifications.created', new DateTime('-1 day'));

        // Older notifications
        $older = $query->newExpr()
            ->lt('Notifications.created', new DateTime('-1 days'));

        $query->select([
            'today' => $recent,
            'yesterday' => $yesterday,
            'older' => $older
        ])
        ->limit(50);

        $query = $query->enableAutoFields();

        $categorizedNotifications = [];
        $query->each(function (Notification $row) use (&$categorizedNotifications) {
            if ($row->get('today') == 1) {
                $categorizedNotifications['today'][] = $row;
            }
            if ($row->get('yesterday') == 1) {
                $categorizedNotifications['yesterday'][] = $row;
            }
            if ($row->get('older') == 1) {
                $categorizedNotifications['older'][] = $row;
            }
        });

        return $categorizedNotifications;
    }

    public function findOld(?Query $query, array $options = [])
    {
        $newQuery = clone $query;
        if (!isset($options['start_date'])) {
            $options['start_date'] = new DateTime('-1 day');
        }
        $older = $newQuery->newExpr()
            ->lt('Notifications.created', $options['start_date']);
        $newQuery->select([
            'older' => $older
        ]);
        $newQuery = $newQuery->enableAutoFields();
//        return $newQuery->where(['Notifications.created < ', $options['start_date']]);
        return $newQuery;
    }

    public function findByTimeFrame(?Query $query, array $options = [])
    {
        $query->where(['Notifications.user_refid' => $options['user']]);
//        if (!isset($options['start_time'])) {
//            $options['start_time'] = 'now';
//        }
//        if (!isset($options['end_time'])) {
//            $hoursSinceMidnight = date('H');
//            $options['end_time'] = "-{$hoursSinceMidnight} hours";
//        }
        $matches = $query->newExpr()->between(
            'Notifications.created',
            new DateTime($options['between_time']),
            new DateTime($options['and_time'])
        );
        $query = $query->select(['matches' => $matches])
            ->enableAutoFields();
        unset($matches);
        unset($options);

        return $query;
    }
}
