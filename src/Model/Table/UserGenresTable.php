<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * UserGenres Model
 *
 * @property \App\Model\Table\ProfilesTable&\Cake\ORM\Association\BelongsTo $Profiles
 * @property \App\Model\Table\GenresTable&\Cake\ORM\Association\BelongsTo $Genres
 *
 * @method \App\Model\Entity\UserGenre newEmptyEntity()
 * @method \App\Model\Entity\UserGenre newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\UserGenre[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\UserGenre get($primaryKey, $options = [])
 * @method \App\Model\Entity\UserGenre findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\UserGenre patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\UserGenre[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\UserGenre|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UserGenre saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UserGenre[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\UserGenre[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\UserGenre[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\UserGenre[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UserGenresTable extends Table
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

        $this->setTable('user_genres');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Profiles', [
            'foreignKey' => 'profile_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Genres', [
            'foreignKey' => 'genre_id',
            'joinType' => 'INNER',
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
        $rules->add($rules->existsIn(['profile_id'], 'Profiles'), ['errorField' => 'profile_id']);
        $rules->add($rules->existsIn(['genre_id'], 'Genres'), ['errorField' => 'genre_id']);

        return $rules;
    }
}
