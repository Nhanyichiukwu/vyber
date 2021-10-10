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
 * @property |\Cake\ORM\Association\BelongsTo $EventVenues
 *
 * @method \App\Model\Entity\EventInvitee get($primaryKey, $options = [])
 * @method \App\Model\Entity\EventInvitee newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EventInvitee[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EventInvitee|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EventInvitee|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EventInvitee patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EventInvitee[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EventInvitee findOrCreate($search, callable $callback = null, $options = [])
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

        $this->belongsTo('Events', [
            'foreignKey' => 'event_refid',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('EventVenues', [
            'foreignKey' => 'event_venue_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('Inviters', [
            'foreignKey' => 'inviter_refid',
            'joinType' => 'INNER',
            'className' => 'Users'
        ]);

        $this->belongsTo('Invitees', [
            'foreignKey' => 'guest_refid',
            'joinType' => 'INNER',
            'className' => 'Users'
        ])->setProperty('guest');

//        $this->hasOne('Invitees', [
//            'foreignKey' => 'refid',
//            'targetForeignKey' => 'guest_refid',
//            'joinType' => 'LEFT',
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
            ->allowEmptyString('id');

        $validator
            ->scalar('event_refid')
            ->maxLength('event_refid', 20)
            ->requirePresence('event_refid', 'create')
            ->allowEmptyString('event_refid', null);

        $validator
            ->scalar('guest_refid')
            ->maxLength('guest_refid', 20)
            ->requirePresence('guest_refid', 'create')
            ->allowEmptyString('guest_refid', null);

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
            ->requirePresence('event_status', 'create')
            ->allowEmptyString('event_status', null);

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
        $rules->add($rules->existsIn(['event_venue_id'], 'EventVenues'));

        return $rules;
    }

    public function findRecent(Query $query, array $options) {
        return $query->where(['guest_refid' => $options['guest'], 'event_seen' => '0']);
    }
}
