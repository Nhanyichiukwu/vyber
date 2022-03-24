<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\Database\Expression\QueryExpression;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EventVenues Model
 *
 * @property \App\Model\Table\EventGuestsTable&\Cake\ORM\Association\HasMany $EventGuests
 * @property \App\Model\Table\EventInviteesTable&\Cake\ORM\Association\HasMany $EventInvitees
 *
 * @method \App\Model\Entity\EventVenue newEmptyEntity()
 * @method \App\Model\Entity\EventVenue newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\EventVenue[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EventVenue get($primaryKey, $options = [])
 * @method \App\Model\Entity\EventVenue findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\EventVenue patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EventVenue[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\EventVenue|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EventVenue saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EventVenue[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\EventVenue[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\EventVenue[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\EventVenue[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class EventVenuesTable extends Table
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

        $this->setTable('event_venues');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->belongsTo('Events', [
            'foreignKey' => 'event_refid'
        ]);
        $this->hasMany('Guests', [
            'foreignKey' => 'event_venue_id',
            'className' => 'EventGuests',
        ]);
        $this->hasMany('Invitees', [
            'foreignKey' => 'event_venue_id',
            'className' => 'EventInvitees'
        ]);
        $this->hasMany('Dates', [
            'foreignKey' => 'venue_id',
            'className' => 'EventVenueDates'
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
            ->scalar('event_refid')
            ->maxLength('event_refid', 20)
            ->requirePresence('event_refid', 'create')
            ->notEmptyString('event_refid');

        $validator
            ->scalar('title')
            ->maxLength('title', 255)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->scalar('description')
            ->maxLength('description', 255)
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

        $validator
            ->allowEmptyFile('media');

        $validator
            ->scalar('country_region')
            ->maxLength('country_region', 255)
            ->requirePresence('country_region', 'create')
            ->notEmptyString('country_region');

        $validator
            ->scalar('state_province')
            ->maxLength('state_province', 255)
            ->requirePresence('state_province', 'create')
            ->notEmptyString('state_province');

        $validator
            ->scalar('city')
            ->maxLength('city', 255)
            ->requirePresence('city', 'create')
            ->notEmptyString('city');

        $validator
            ->scalar('address')
            ->maxLength('address', 255)
            ->requirePresence('address', 'create')
            ->notEmptyString('address');

//        $validator
//            ->dateTime('start_date')
//            ->notEmptyDateTime('start_date');
//
//        $validator
//            ->dateTime('end_date')
//            ->notEmptyDateTime('end_date');

        $validator
            ->scalar('status')
            ->allowEmptyString('status');

        return $validator;
    }

    public function findWhereUserIsGuest(Query $query, array $options = [])
    {
        $timeframe = $options['timeframe'] ?? '+7 days';
        $user = $options['user'];
        $guestsAssoc = $this->getAssociation('Guests')->getTarget();
        $attending = $guestsAssoc->subquery()
            ->select(['event_venue_id'])
            ->distinct()
            ->where(['guest_refid' => $user]);

        $query = $query
            ->where(['Venues.id IN' => $attending])
            ->contain([
                'Events' => ['Authors' => ['Profiles']],
                'Guests' => ['Users' => ['Profiles']]
            ]);

        return $query;
    }

    public function findDueEvents(Query $query, array $options = [])
    {
        $timeframe = $options['timeframe'] ?? '+7 days';
        $user = $options['user'];
//        $query = $query
//            ->where([
//                'Events.user_refid' => $user
//            ])
//            ->contain([
//                'Events' => [
//                    ''
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
//                            'Invitees' => ['Profiles']
//                        ],
//                    ])
//                    ->matching('Guests', function (Query $q) use ($user) {
//                        return $q->where([
//                            'OR' => [
//                                ['Guests.inviter_refid' => $user],
//                                ['Guests.guest_refid' => $user]
//                            ]
//                        ]);
//                    });
//                return $q;
//            });
//        $query = $query->where([
//            'Venues.start_date >= ' => new \DateTime($timeframe)
//        ])
//            ->contain([
//                'Events' => [
//                    'Authors' => ['Profiles']
//                ],
//                'Guests' => [
//                    'Inviters' => ['Profiles'],
//                    'Invitees' => ['Profiles']
//                ],
//            ])
//            ->matching('Guests', function (Query $q) use ($user) {
//                return $q->where([
//                    'OR' => [
//                        ['Guests.inviter_refid' => $user],
//                        ['Guests.guest_refid' => $user]
//                    ]
//                ]);
//            });
        pr($query->toArray());
        exit;

        return $query;
    }
}
