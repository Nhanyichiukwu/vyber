<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * GroupMedias Model
 *
 * @property \App\Model\Table\GroupsTable&\Cake\ORM\Association\BelongsTo $Groups
 *
 * @method \App\Model\Entity\GroupMedia newEmptyEntity()
 * @method \App\Model\Entity\GroupMedia newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\GroupMedia[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\GroupMedia get($primaryKey, $options = [])
 * @method \App\Model\Entity\GroupMedia findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\GroupMedia patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\GroupMedia[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\GroupMedia|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\GroupMedia saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\GroupMedia[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\GroupMedia[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\GroupMedia[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\GroupMedia[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class GroupMediasTable extends Table
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

        $this->setTable('group_medias');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Groups', [
            'foreignKey' => 'group_id',
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

        $validator
            ->scalar('user_refid')
            ->maxLength('user_refid', 20)
            ->requirePresence('user_refid', 'create')
            ->notEmptyString('user_refid');

        $validator
            ->scalar('media_path')
            ->maxLength('media_path', 255)
            ->requirePresence('media_path', 'create')
            ->notEmptyString('media_path');

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
        $rules->add($rules->existsIn(['group_id'], 'Groups'), ['errorField' => 'group_id']);

        return $rules;
    }
}
