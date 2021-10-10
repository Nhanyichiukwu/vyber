<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MovieMakersProfiles Model
 *
 * @method \App\Model\Entity\MovieMakersProfile get($primaryKey, $options = [])
 * @method \App\Model\Entity\MovieMakersProfile newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MovieMakersProfile[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MovieMakersProfile|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MovieMakersProfile|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MovieMakersProfile patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MovieMakersProfile[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MovieMakersProfile findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MovieMakersProfilesTable extends Table
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

        $this->setTable('movie_makers_profiles');
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
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', 'create');

        $validator
            ->scalar('user_refid')
            ->maxLength('user_refid', 20)
            ->requirePresence('user_refid', 'create')
            ->allowEmptyString('user_refid', null);

        $validator
            ->scalar('role_refid')
            ->maxLength('role_refid', 20)
            ->requirePresence('role_refid', 'create')
            ->allowEmptyString('role_refid', null);

        $validator
            ->scalar('popular_name')
            ->maxLength('popular_name', 255)
            ->requirePresence('popular_name', 'create')
            ->allowEmptyString('popular_name', null);

        $validator
            ->date('debut')
            ->allowEmptyDate('debut');

        $validator
            ->scalar('debut_movie')
            ->maxLength('debut_movie', 20)
            ->allowEmptyString('debut_movie');

        $validator
            ->nonNegativeInteger('number_of_movies')
            ->allowEmptyString('number_of_movies');

        $validator
            ->scalar('skills')
            ->allowEmptyString('skills');

        $validator
            ->scalar('instruments_known')
            ->allowEmptyString('instruments_known');

        $validator
            ->scalar('spoken_languages')
            ->maxLength('spoken_languages', 16777215)
            ->allowEmptyString('spoken_languages');

        $validator
            ->scalar('story')
            ->allowEmptyString('story');

        $validator
            ->scalar('manager')
            ->maxLength('manager', 255)
            ->allowEmptyString('manager');

        $validator
            ->scalar('debut_movie_role')
            ->maxLength('debut_movie_role', 100)
            ->allowEmptyString('debut_movie_role');

        return $validator;
    }
}
