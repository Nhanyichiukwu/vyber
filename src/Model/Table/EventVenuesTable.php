<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EventVenues Model
 *
 * @property \App\Model\Table\EventGuestsTable|\Cake\ORM\Association\HasMany $EventGuests
 *
 * @method \App\Model\Entity\EventVenue get($primaryKey, $options = [])
 * @method \App\Model\Entity\EventVenue newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EventVenue[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EventVenue|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EventVenue|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EventVenue patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EventVenue[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EventVenue findOrCreate($search, callable $callback = null, $options = [])
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
            'foreignKey' => 'event_refid',
            'joinType' => 'INNER'
        ]);

        $this->hasMany('Guests', [
            'foreignKey' => 'event_venue_id',
            'className' => 'EventGuests'
        ])->setProperty('guests');
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
            ->scalar('title')
            ->maxLength('title', 255)
            ->requirePresence('title', 'create')
            ->allowEmptyString('title', null);

        $validator
            ->scalar('description')
            ->maxLength('description', 255)
            ->requirePresence('description', 'create')
            ->allowEmptyString('description', null);

        $validator
            ->allowEmptyFile('image');

        $validator
            ->scalar('country_region')
            ->maxLength('country_region', 255)
            ->requirePresence('country_region', 'create')
            ->allowEmptyString('country_region', null);

        $validator
            ->scalar('state_province')
            ->maxLength('state_province', 255)
            ->requirePresence('state_province', 'create')
            ->allowEmptyString('state_province', null);

        $validator
            ->scalar('city')
            ->maxLength('city', 255)
            ->requirePresence('city', 'create')
            ->allowEmptyString('city', null);

        $validator
            ->scalar('address')
            ->maxLength('address', 255)
            ->requirePresence('address', 'create')
            ->allowEmptyString('address', null);

        $validator
            ->dateTime('start_date')
            ->requirePresence('start_date', 'create')
            ->allowEmptyDateTime('start_date', null);

        $validator
            ->dateTime('end_date')
            ->requirePresence('end_date', 'create')
            ->allowEmptyDateTime('end_date', null);

        $validator
            ->scalar('status')
            ->allowEmptyString('status');

        return $validator;
    }
}
