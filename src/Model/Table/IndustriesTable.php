<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Industries Model
 *
 * @property \App\Model\Table\IndustriesTable&\Cake\ORM\Association\BelongsTo $ParentIndustries
 * @property \App\Model\Table\GenresTable&\Cake\ORM\Association\HasMany $Genres
 * @property \App\Model\Table\IndustriesTable&\Cake\ORM\Association\HasMany $ChildIndustries
 * @property \App\Model\Table\RolesTable&\Cake\ORM\Association\HasMany $Roles
 * @property \App\Model\Table\TalentHubTable&\Cake\ORM\Association\HasMany $TalentHub
 *
 * @method \App\Model\Entity\Industry newEmptyEntity()
 * @method \App\Model\Entity\Industry newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Industry[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Industry get($primaryKey, $options = [])
 * @method \App\Model\Entity\Industry findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Industry patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Industry[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Industry|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Industry saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Industry[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Industry[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Industry[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Industry[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class IndustriesTable extends Table
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

        $this->setTable('industries');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ParentIndustries', [
            'className' => 'Industries',
            'foreignKey' => 'parent_id',
        ]);
        $this->hasMany('Genres', [
            'foreignKey' => 'industry_id',
        ]);
        $this->hasMany('ChildIndustries', [
            'className' => 'Industries',
            'foreignKey' => 'parent_id',
        ]);
        $this->hasMany('Roles', [
            'foreignKey' => 'industry_id',
        ]);
        $this->hasMany('TalentHub', [
            'foreignKey' => 'industry_id',
        ]);
        $this->belongsToMany('Profiles', [
            'joinTable' => 'profiles_industries'
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
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('slug')
            ->maxLength('slug', 255)
            ->requirePresence('slug', 'create')
            ->notEmptyString('slug');

        $validator
            ->scalar('description')
            ->maxLength('description', 16777215)
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

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
        $rules->add($rules->existsIn(['parent_id'], 'ParentIndustries'), ['errorField' => 'parent_id']);

        return $rules;
    }

    public function findByName(string $name)
    {
        return $this->find('all')->where(['name' => $name]);
    }
}
