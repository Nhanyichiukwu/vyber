<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\Database\Expression\QueryExpression;
use Cake\ORM\Locator\TableLocator;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Events Model
 *
 * @property \App\Model\Table\EventTypesTable&\Cake\ORM\Association\BelongsTo $EventTypes
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Authors
 *
 * @method \App\Model\Entity\Event newEmptyEntity()
 * @method \App\Model\Entity\Event newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Event[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Event get($primaryKey, $options = [])
 * @method \App\Model\Entity\Event findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Event patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Event[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Event|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Event saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Event[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Event[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Event[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Event[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EventsTable extends Table
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

        $this->setTable('events');
        $this->setDisplayField('title');
        $this->setPrimaryKey('refid');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Authors', [
            'foreignKey' => 'user_refid',
            'className' => 'Users'
        ]);
        $this->belongsTo('EventTypes', [
            'foreignKey' => 'event_type_id',
        ]);
        $this->hasMany('Venues', [
            'foreignKey' => 'event_refid',
            'className' => 'EventVenues'
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
            ->nonNegativeInteger('id', null)
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('refid')
            ->maxLength('refid', 20)
            ->requirePresence('refid','create')
            ->notEmptyString('refid', null, 'create');

        $validator
            ->scalar('title')
            ->maxLength('title', 255)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->scalar('description')
            ->maxLength('description', 16777215)
            ->allowEmptyString('description');

        $validator
            ->scalar('privacy')
            ->allowEmptyString('privacy');

        $validator
            ->scalar('media')
            ->maxLength('media', 255)
            ->allowEmptyFile('media');

        $validator
            ->scalar('user_refid')
            ->maxLength('user_refid', 20)
            ->requirePresence('user_refid', 'create')
            ->notEmptyString('user_refid');

        $validator
            ->scalar('hostname')
            ->maxLength('hostname', 255)
            ->requirePresence('hostname', 'create')
            ->notEmptyString('hostname');

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
        $rules->add($rules->existsIn(['event_type_id'], 'EventTypes'), ['errorField' => 'event_type_id']);

        return $rules;
    }

    public function findAllForUser(Query $query, array $options = [])
    {
        $venueAssoc = $this->getAssociation('Venues')->getTarget();
        $whereUserIsGuest = $venueAssoc->find('whereUserIsGuest', $options)
            ->select(['event_refid'])
            ->distinct();
        $userEvents = $query
            ->where([
                'OR' => [
                    'Events.refid IN' => $whereUserIsGuest,
                    'Events.user_refid' => $options['user'],
                ],
                'Events.status' => 'published',
            ])
            ->contain([
                'Authors' => ['Profiles'],
                'Venues' => [
                    'Guests' => ['Users' => ['Profiles']]
                ]
            ]);

        return $userEvents;
    }


//    public function findDueEvents(Query $query, array $options = [])
//    {
//        $timeframe = $options['timeframe'] ?? '+7 days';
//        $user = $options['user'];
//        $authoredEvents = $query
//            ->where(['Events.user_refid' => $user])
//            ->contain([
//                'Venues' => [
//                    'Guests' => [
//                        'Inviters' => ['Profiles'],
////                        'Invitees' => ['Profiles']
//                    ],
//                ]
//            ])
//            ->matching('Venues', function (Query $q) use ($timeframe, $user) {
////                $expr = $q->newExpr()->between('Venues.start_date', new \DateTime('now'), new \DateTime($timeframe));
//                $q = $q->where([
//                    'Venues.start_date >= ' => new \DateTime($timeframe)
//                ])
//                    ->contain([
//                        'Guests' => [
//                            'Inviters' => ['Profiles'],
////                            'Invitees' => ['Profiles']
//                        ],
//                    ]);
////                    ->matching('Guests', function (Query $q) use ($user) {
////                        return $q->where([
////                            'OR' => [
////                                ['Guests.guest_refid' => $user],
////                            ]
////                        ]);
////                    });
//                return $q;
//            });
//
//        $attendingEvents = $this->Venues->Guests->find('dueEvents', $options);
////        debug($attendingEvents);
//        pr($attendingEvents);
//        exit;
//
//        return $query;
//    }

    public function findDueEvents(Query $query, array $options = null)
    {
        $timeframe = $options['timeframe'] ?? '+7 days';
        $user = $options['user'];

        $whereIsGuest = $this->Venues->find('whereUserIsGuest', ['user' => $user])
            ->where(function (QueryExpression $exp, Query $q) use ($timeframe) {
                return $exp->between(
                    'start_date',
                    new \DateTime('now') ,
                    new \DateTime($timeframe)
                );
            });

        $userOwnEvents = $query->where(['user_refid' => $user]);
        $result = $userOwnEvents->unionAll($whereIsGuest);

//        $venuesAssoc  = $this->getAssociation('Venues')->getTarget();
//        $guestsAssoc = $venuesAssoc->getAssociation('Guests')->getTarget();
//        $attending = $guestsAssoc->subquery()
//            ->select(['event_venue_id'])
//            ->distinct()
//            ->where(['guest_refid' => $user]);
//
//        $matchingVenues = $venuesAssoc->find()
//            ->select(['event_refid'])
//            ->distinct()
//            ->where(['id IN' => $attending])
//            ->where(function (QueryExpression $exp, Query $q) use ($timeframe) {
//                return $exp->between('start_date', new \DateTime('now') , new \DateTime($timeframe));
//            })
//            ->contain([
//                'Events',
//                'Guests' => [
//                    'Users' => ['Profiles']
//                ]
//            ]);

//        $query = $query->where(['refid IN' => $matchingVenues])
//            ->contain([
//                'Venues' => [
//                    'Guests' => [
//                        'Users' => ['Profiles']
//                    ]
//                ]
//            ]);
//        pr($query->toArray());
//        exit;

        return $result;
    }
    public function findInvites(Query $query, array $options)
    {
        $query = $query->matching('Guests', function ($q) use ($options) {
            $actor = $options['actor'];
            $filter = '';
            if (array_key_exists('filter', $options)) {
                $filter = $options['filter'];
            }

            $q = $q->whereNull('response')
                ->contain([
                    'Inviters' => ['Profiles'],
                    'Invitees' => ['Profiles']
                ]);

            switch ($filter) {
                case 'sent':
                    $q = $q->andWhere(['inviter_refid' => $actor]);
                    break;

                case 'received':
                    $q = $q->andWhere(['guest_refid' => $actor]);
                    break;

                default:
                    $q = $q->andWhere([
                        'OR' => [
                            ['inviter_refid' => $actor],
                            ['guest_refid' => $actor]
                        ]
                    ]);
                    break;
            }

            return $q;
        });

        return $query;
    }

    public function findByUser(Query $query, array $options)
    {
        return $query->where(['user_refid' => $options['user']]);
    }
}
