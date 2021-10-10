<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * UsersRatings Model
 *
 * @method \App\Model\Entity\UsersRating newEmptyEntity()
 * @method \App\Model\Entity\UsersRating newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\UsersRating[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\UsersRating get($primaryKey, $options = [])
 * @method \App\Model\Entity\UsersRating findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\UsersRating patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\UsersRating[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\UsersRating|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UsersRating saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UsersRating[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\UsersRating[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\UsersRating[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\UsersRating[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersRatingsTable extends Table
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

        $this->setTable('users_ratings');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->scalar('user_refid')
            ->maxLength('user_refid', 20)
            ->requirePresence('user_refid', 'create')
            ->notEmptyString('user_refid');

        $validator
            ->scalar('actor_refid')
            ->maxLength('actor_refid', 20)
            ->requirePresence('actor_refid', 'create')
            ->notEmptyString('actor_refid');

        $validator
            ->integer('rating')
            ->notEmptyString('rating');

        $validator
            ->scalar('review')
            ->maxLength('review', 16777215)
            ->allowEmptyString('review');

        return $validator;
    }
}
