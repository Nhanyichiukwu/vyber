<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Genres Model
 *
 * @method \App\Model\Entity\Genre newEmptyEntity()
 * @method \App\Model\Entity\Genre newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Genre[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Genre get($primaryKey, $options = [])
 * @method \App\Model\Entity\Genre findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Genre patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Genre[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Genre|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Genre saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Genre[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Genre[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Genre[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Genre[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class GenresTable extends Table
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

        $this->setTable('genres');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ParentGenres', [
            'className' => 'Genres',
            'foreignKey' => 'parent_refid',
        ]);

        $this->hasMany('ChildGenres', [
            'className' => 'Genres',
            'foreignKey' => 'parent_refid',
        ]);

        $this->belongsTo('Industries', [
            'foreignKey' => 'industry_id',
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
            ->nonNegativeInteger('id')
            ->requirePresence('id', 'create')
            ->notEmptyString('id');

        $validator
            ->scalar('refid')
            ->maxLength('refid', 20)
            ->allowEmptyString('refid', null, 'create');

        $validator
            ->scalar('parent_refid')
            ->maxLength('parent_refid', 20)
            ->allowEmptyString('parent_refid');

        $validator
            ->scalar('name')
            ->maxLength('name', 45)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('slug')
            ->maxLength('slug', 100)
            ->requirePresence('slug', 'create')
            ->notEmptyString('slug');

        $validator
            ->scalar('description')
            ->maxLength('description', 16777215)
            ->allowEmptyString('description');

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
        $rules->add($rules->existsIn(['parent_refid'], 'ParentGenres'), ['errorField' => 'parent_refid']);
        $rules->add($rules->existsIn(['industry_id'], 'Industries'), ['errorField' => 'industry_id']);

        return $rules;
    }

    public function findByIndustry(Query $query, array $options = null)
    {
        return $query->matching('Industries', function (Query $q)
        use ($options) {
            return $q->where([
                'Industries.slug' => $options['industry']
            ]);
        });
    }
}
