<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Profiles Model
 *
 * @property \App\Model\Table\ProfilesGenresTable&\Cake\ORM\Association\HasMany $UserGenres
 * @property \App\Model\Table\ProfilesIndustriesTable&\Cake\ORM\Association\HasMany $UserIndustries
 * @property \App\Model\Table\ProfilesRolesTable&\Cake\ORM\Association\HasMany $UserRoles
 *
 * @method \App\Model\Entity\Profile newEmptyEntity()
 * @method \App\Model\Entity\Profile newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Profile[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Profile get($primaryKey, $options = [])
 * @method \App\Model\Entity\Profile findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Profile patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Profile[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Profile|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Profile saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Profile[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Profile[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Profile[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Profile[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProfilesTable extends Table
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

        $this->setTable('profiles');
        $this->setDisplayField('user_refid');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_refid',
        ]);

        $this->belongsToMany('Industries', [
            'joinTable' => 'profiles_industries'
        ]);
        $this->belongsToMany('Roles', [
            'joinTable' => 'profiles_roles',
        ]);
        $this->belongsToMany('Genres', [
            'joinTable' => 'profiles_genres'
        ]);

        $this->hasMany('Languages', [
            'className' => 'ProfilesLanguages'
        ]);

        $this->hasMany('Educations', [
            'className' => 'ProfilesEducations'
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
            ->scalar('user_refid')
            ->maxLength('user_refid', 20)
            ->requirePresence('user_refid', 'create')
            ->notEmptyString('user_refid')
            ->add('user_refid', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);


        $validator
            ->scalar('gender')
            ->allowEmptyString('gender');

        $validator
            ->date('date_of_birth')
            ->allowEmptyString('date_of_birth');

        $validator
            ->scalar('relationship')
            ->allowEmptyString('relationship');

        $validator
            ->scalar('description')
            ->maxLength('description', 255)
            ->allowEmptyString('description');

        $validator
            ->scalar('bio')
//            ->maxLength('bio')
            ->allowEmptyString('bio');

//        $validator
//            ->scalar('industries')
////            ->maxLength('bio')
//            ->allowEmptyString('industries');
//
//        $validator
//            ->scalar('roles')
////            ->maxLength('bio')
//            ->allowEmptyString('roles');
//
//        $validator
//            ->scalar('genres')
////            ->maxLength('bio')
//            ->allowEmptyString('genres');

        $validator
            ->boolean('is_hall_of_famer')
            ->allowEmptyString('is_hall_of_famer');

        $validator
            ->scalar('country_of_origin')
            ->maxLength('country_of_origin', 45)
            ->allowEmptyString('country_of_origin');

        $validator
            ->scalar('state_of_origin')
            ->maxLength('state_of_origin', 100)
            ->allowEmptyString('state_of_origin');

        $validator
            ->scalar('lga_of_origin')
            ->maxLength('lga_of_origin', 150)
            ->allowEmptyString('lga_of_origin');

        $validator
            ->scalar('hometown')
            ->maxLength('hometown', 150)
            ->allowEmptyString('hometown');

        $validator
            ->scalar('country_of_residence')
            ->maxLength('country_of_residence', 255)
            ->allowEmptyString('country_of_residence');

        $validator
            ->scalar('state_of_residence')
            ->maxLength('state_of_residence', 255)
            ->allowEmptyString('state_of_residence');

        $validator
            ->scalar('lga_of_residence')
            ->maxLength('lga_of_residence', 255)
            ->allowEmptyString('lga_of_residence');

        $validator
            ->scalar('current_city')
            ->maxLength('current_city', 255)
            ->allowEmptyString('current_city');

        $validator
            ->scalar('address')
            ->maxLength('address', 255)
            ->allowEmptyString('address');

        $validator
            ->scalar('postcode')
            ->maxLength('postcode', 6)
            ->allowEmptyString('postcode');

        $validator
            ->scalar('location')
            ->allowEmptyString('location');

        $validator
            ->scalar('website')
            ->maxLength('website', 255)
            ->allowEmptyString('website');

        $validator
            ->scalar('skills')
            ->maxLength('skills', 255)
            ->allowEmptyString('skills');

        $validator
            ->scalar('profile_image_url')
            ->maxLength('profile_image_url', 255)
            ->allowEmptyFile('profile_image_url');

        $validator
            ->scalar('header_image_url')
            ->maxLength('header_image_url', 255)
            ->allowEmptyFile('header_image_url');

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
        $rules->add($rules->isUnique(['user_refid']), ['errorField' => 'user_refid']);

        return $rules;
    }
}
