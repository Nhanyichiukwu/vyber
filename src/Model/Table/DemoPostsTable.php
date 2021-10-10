<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DemoPosts Model
 *
 * @method \App\Model\Entity\DemoPost get($primaryKey, $options = [])
 * @method \App\Model\Entity\DemoPost newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DemoPost[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DemoPost|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DemoPost|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DemoPost patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DemoPost[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DemoPost findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class DemoPostsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('demo_posts');
        $this->setDisplayField('refid');
        $this->setPrimaryKey('refid');

        $this->addBehavior('Timestamp');
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
            ->nonNegativeInteger('id')
            ->requirePresence('id', 'create')
            ->allowEmptyString('id', false)
            ->add('id', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('refid')
            ->maxLength('refid', 20)
            ->allowEmptyString('refid', 'create');

        $validator
            ->scalar('author_refid')
            ->maxLength('author_refid', 20)
            ->requirePresence('author_refid', 'create')
            ->allowEmptyString('author_refid', false);

        $validator
            ->scalar('original_author_refid')
            ->maxLength('original_author_refid', 20)
            ->requirePresence('original_author_refid', 'create')
            ->allowEmptyString('original_author_refid', false);

        $validator
            ->scalar('post_text')
            ->allowEmptyString('post_text');

        $validator
            ->scalar('original_post_refid')
            ->maxLength('original_post_refid', 20)
            ->allowEmptyString('original_post_refid');

        $validator
            ->scalar('shared_post_refid')
            ->maxLength('shared_post_refid', 20)
            ->allowEmptyString('shared_post_refid');

        $validator
            ->scalar('shared_post_referer')
            ->maxLength('shared_post_referer', 255)
            ->allowEmptyString('shared_post_referer');

        $validator
            ->scalar('attachment_refkey')
            ->maxLength('attachment_refkey', 8)
            ->allowEmptyString('attachment_refkey');

        $validator
            ->scalar('type')
            ->allowEmptyString('type');

        $validator
            ->allowEmptyString('tags');

        $validator
            ->scalar('location')
            ->maxLength('location', 255)
            ->allowEmptyString('location');

        $validator
            ->scalar('privacy')
            ->allowEmptyString('privacy');

        $validator
            ->scalar('status')
            ->allowEmptyString('status');

        $validator
            ->scalar('year_published')
            ->allowEmptyString('year_published');

        $validator
            ->dateTime('date_published')
            ->allowEmptyDateTime('date_published');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['id']));

        return $rules;
    }
}
