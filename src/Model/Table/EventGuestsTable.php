<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EventGuests Model
 *
 * @property \App\Model\Table\EventVenuesTable&\Cake\ORM\Association\BelongsTo $EventVenues
 *
 * @method \App\Model\Entity\EventGuest newEmptyEntity()
 * @method \App\Model\Entity\EventGuest newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\EventGuest[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EventGuest get($primaryKey, $options = [])
 * @method \App\Model\Entity\EventGuest findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\EventGuest patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EventGuest[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\EventGuest|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EventGuest saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EventGuest[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\EventGuest[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\EventGuest[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\EventGuest[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class EventGuestsTable extends Table
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

        $this->setTable('event_guests');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Venues', [
            'foreignKey' => 'event_venue_id',
            'joinType' => 'INNER',
            'className' => 'EventVenues'
        ]);

        $this->belongsTo('Users', [
            'foreignKey' => 'guest_refid',
        ]);

        $this->belongsTo('Events', [
            'foreignKey' => 'event_refid',
            'joinType' => 'INNER'
        ]);

//        $this->belongsTo('EventsVenues', [
//            'foreignKey' => 'event_venue_id',
//            'joinType' => 'INNER'
//        ]);

        $this->belongsTo('Inviters', [
            'foreignKey' => 'inviter_refid',
            'joinType' => 'INNER',
            'className' => 'Users'
        ]);

//        $this->belongsTo('Invitees', [
//            'foreignKey' => 'guest_refid',
//            'joinType' => 'INNER',
//            'className' => 'Users'
//        ])->setProperty('guest');
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
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('event_refid')
            ->maxLength('event_refid', 20)
            ->requirePresence('event_refid', 'create')
            ->notEmptyString('event_refid');

        $validator
            ->scalar('guest_refid')
            ->maxLength('guest_refid', 20)
            ->requirePresence('guest_refid', 'create')
            ->notEmptyString('guest_refid');

        $validator
            ->scalar('inviter_refid')
            ->maxLength('inviter_refid', 20)
            ->allowEmptyString('inviter_refid');

        $validator
            ->dateTime('date_invited')
            ->allowEmptyDateTime('date_invited');

        $validator
            ->boolean('event_seen')
            ->allowEmptyString('event_seen');

        $validator
            ->dateTime('date_seen')
            ->allowEmptyDateTime('date_seen');

        $validator
            ->dateTime('invite_response_date')
            ->allowEmptyDateTime('invite_response_date');

        $validator
            ->scalar('response')
            ->allowEmptyString('response');

        $validator
            ->scalar('event_status')
            ->notEmptyString('event_status');

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
        $rules->add($rules->existsIn(['event_venue_id'], 'EventVenues'), ['errorField' => 'event_venue_id']);

        return $rules;
    }

    public function findRecent(Query $query, array $options) {
        return $query->where(['guest_refid' => $options['guest'], 'event_seen' => '0']);
    }

    public function findDueEvents(Query $query, array $options = [])
    {
        $timeframe = $options['timeframe'] ?? '+7 days';
        $user = $options['user'];

        $query = $query
            ->matching('Venues', function (Query $q) use ($timeframe) {
//                return $q->where([
//                    'Venues.start_date <= ' => new \DateTime($timeframe)
//                ]);
                return $q->newExpr()
                    ->between('Venues.start_date', new \DateTime('now'), new \DateTime($timeframe));
            })
            ->contain([
                'Venues' => [
                    'Guests'
                ]
            ])
            ->where([
                'Guests.guest_refid' => $user
            ]);

        return $query;
    }
}
