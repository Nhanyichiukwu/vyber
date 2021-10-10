<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Guests Model
 *
 * @method \App\Model\Entity\Guest get($primaryKey, $options = [])
 * @method \App\Model\Entity\Guest newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Guest[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Guest|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Guest|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Guest patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Guest[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Guest findOrCreate($search, callable $callback = null, $options = [])
 */
class GuestsTable extends Table
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

        $this->setTable('guests');
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
            ->allowEmptyString('id', null);

        $validator
            ->scalar('registered_user_refid')
            ->maxLength('registered_user_refid', 20)
            ->allowEmptyString('registered_user_refid');

        $validator
            ->scalar('ip')
            ->maxLength('ip', 45)
            ->requirePresence('ip', 'create')
            ->allowEmptyString('ip', null);

        $validator
            ->scalar('device')
            ->maxLength('device', 20)
            ->requirePresence('device', 'create')
            ->allowEmptyString('device', null);

        $validator
            ->scalar('browser')
            ->maxLength('browser', 255)
            ->requirePresence('browser', 'create')
            ->allowEmptyString('browser', null);

        $validator
            ->scalar('os')
            ->maxLength('os', 45)
            ->allowEmptyString('os');

        $validator
            ->scalar('city')
            ->maxLength('city', 255)
            ->allowEmptyString('city');

        $validator
            ->scalar('state')
            ->maxLength('state', 255)
            ->allowEmptyString('state');

        $validator
            ->scalar('region')
            ->maxLength('region', 255)
            ->allowEmptyString('region');

        $validator
            ->scalar('country')
            ->maxLength('country', 255)
            ->allowEmptyString('country');

        $validator
            ->scalar('country_code')
            ->maxLength('country_code', 5)
            ->allowEmptyString('country_code');

        $validator
            ->scalar('continent')
            ->maxLength('continent', 255)
            ->allowEmptyString('continent');

        $validator
            ->scalar('continent_code')
            ->maxLength('continent_code', 2)
            ->allowEmptyString('continent_code');

        $validator
            ->scalar('currency_symbol')
            ->maxLength('currency_symbol', 20)
            ->allowEmptyString('currency_symbol');

        $validator
            ->scalar('currency_code')
            ->maxLength('currency_code', 5)
            ->allowEmptyString('currency_code');

        $validator
            ->numeric('currencey_converter')
            ->allowEmptyString('currencey_converter');

        $validator
            ->scalar('timezone')
            ->maxLength('timezone', 255)
            ->allowEmptyString('timezone');

        $validator
            ->scalar('longitude')
            ->maxLength('longitude', 255)
            ->allowEmptyString('longitude');

        $validator
            ->scalar('latitude')
            ->maxLength('latitude', 255)
            ->allowEmptyString('latitude');

        $validator
            ->dateTime('last_visit')
            ->allowEmptyDateTime('last_visit');

        return $validator;
    }

    public function findByIp(Query $query, array $options)
    {
        return $query->where(['ip' => $options['ip']]);
    }

    public function findByCountry(Query $query, array $options)
    {
        return $query->where(['country' => $options['country']]);
    }

    public function findByRegion(Query $query, array $options)
    {
        return $query->where(['region' => $options['region']]);
    }
}
