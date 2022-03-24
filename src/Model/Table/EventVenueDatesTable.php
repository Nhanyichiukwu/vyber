<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EventVenueDates Model
 *
 * @property \App\Model\Table\EventVenuesTable&\Cake\ORM\Association\BelongsTo $EventVenues
 *
 * @method \App\Model\Entity\EventVenueDate newEmptyEntity()
 * @method \App\Model\Entity\EventVenueDate newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\EventVenueDate[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EventVenueDate get($primaryKey, $options = [])
 * @method \App\Model\Entity\EventVenueDate findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\EventVenueDate patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EventVenueDate[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\EventVenueDate|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EventVenueDate saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EventVenueDate[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\EventVenueDate[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\EventVenueDate[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\EventVenueDate[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class EventVenueDatesTable extends Table
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

        $this->setTable('event_venue_dates');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Venues', [
            'foreignKey' => 'event_venue_id',
            'joinType' => 'INNER',
            'className' => 'EventVenues',
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
            ->allowEmptyString('id', null, 'create');

        $validator
            ->date('day')
            ->notEmptyDate('day');

        $validator
            ->time('starts_at')
            ->notEmptyTime('starts_at');

        $validator
            ->time('ends_at')
            ->notEmptyTime('ends_at');

        $validator
            ->scalar('detail')
            ->maxLength('detail', 16777215)
            ->allowEmptyString('detail');

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
}
