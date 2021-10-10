<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * UserAuthenticators Model
 *
 * @method \App\Model\Entity\UserAuthenticator get($primaryKey, $options = [])
 * @method \App\Model\Entity\UserAuthenticator newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\UserAuthenticator[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\UserAuthenticator|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UserAuthenticator|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UserAuthenticator patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\UserAuthenticator[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\UserAuthenticator findOrCreate($search, callable $callback = null, $options = [])
 */
class UserAuthenticatorsTable extends Table
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

        $this->setTable('user_authenticators');
        $this->setDisplayField('user_id');
        $this->setPrimaryKey('user_id');
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
            ->allowEmptyString('user_id', 'create');

        $validator
            ->email('email')
            ->allowEmptyString('email');

        $validator
            ->scalar('phone')
            ->maxLength('phone', 20)
            ->allowEmptyString('phone');

        $validator
            ->scalar('username')
            ->maxLength('username', 15)
            ->requirePresence('username', 'create')
            ->allowEmptyString('username', null);

        $validator
            ->scalar('password')
            ->maxLength('password', 100)
            ->requirePresence('password', 'create')
            ->allowEmptyString('password', null);

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
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->isUnique(['username']));

        return $rules;
    }
}
