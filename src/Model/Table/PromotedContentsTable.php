<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PromotedContents Model
 *
 * @method \App\Model\Entity\PromotedContent newEmptyEntity()
 * @method \App\Model\Entity\PromotedContent newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\PromotedContent[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PromotedContent get($primaryKey, $options = [])
 * @method \App\Model\Entity\PromotedContent findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\PromotedContent patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PromotedContent[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\PromotedContent|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PromotedContent saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PromotedContent[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PromotedContent[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\PromotedContent[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PromotedContent[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PromotedContentsTable extends Table
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

        $this->setTable('promoted_contents');
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
            ->scalar('content_refid')
            ->maxLength('content_refid', 20)
            ->requirePresence('content_refid', 'create')
            ->notEmptyString('content_refid')
            ->add('content_refid', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('promoter_refid')
            ->maxLength('promoter_refid', 20)
            ->requirePresence('promoter_refid', 'create')
            ->notEmptyString('promoter_refid');

        $validator
            ->scalar('content_type')
            ->maxLength('content_type', 255)
            ->requirePresence('content_type', 'create')
            ->notEmptyString('content_type');

        $validator
            ->scalar('content_repository')
            ->maxLength('content_repository', 255)
            ->requirePresence('content_repository', 'create')
            ->notEmptyString('content_repository');

        $validator
            ->dateTime('published')
            ->allowEmptyDateTime('published');

        $validator
            ->scalar('status')
            ->allowEmptyString('status');

        $validator
            ->scalar('audience_age_bracket')
            ->allowEmptyString('audience_age_bracket');

        $validator
            ->scalar('audience_gender')
            ->allowEmptyString('audience_gender');

        $validator
            ->scalar('audience_locations')
            ->maxLength('audience_locations', 4294967295)
            ->allowEmptyString('audience_locations');

        $validator
            ->dateTime('start_date')
            ->allowEmptyDateTime('start_date');

        $validator
            ->scalar('end_date')
            ->maxLength('end_date', 255)
            ->allowEmptyString('end_date');

        $validator
            ->scalar('budget_currency')
            ->maxLength('budget_currency', 5)
            ->allowEmptyString('budget_currency');

        $validator
            ->numeric('budget_amount')
            ->notEmptyString('budget_amount');

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
        $rules->add($rules->isUnique(['content_refid']), ['errorField' => 'content_refid']);

        return $rules;
    }
}
