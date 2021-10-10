<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Newsfeeds Model
 *
 * @method \App\Model\Entity\Newsfeed get($primaryKey, $options = [])
 * @method \App\Model\Entity\Newsfeed newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Newsfeed[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Newsfeed|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Newsfeed|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Newsfeed patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Newsfeed[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Newsfeed findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class NewsfeedsTable extends Table
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

        $this->setTable('newsfeeds');
        $this->setDisplayField('feed_refid');
        $this->setPrimaryKey('feed_refid');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_refid',
            'joinType' => 'INNER'
        ]);

        $this->hasMany('Posts', [
            'foreignKey' => 'feed_refid',
            'joinType' => 'INNER'
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
            ->allowEmptyString('id', 'create');

        $validator
            ->scalar('feed_refid')
            ->maxLength('feed_refid', 20)
            ->requirePresence('feed_refid', 'create')
            ->allowEmptyString('feed_refid', null);

        $validator
            ->scalar('user_refid')
            ->maxLength('user_refid', 20)
            ->requirePresence('user_refid', 'create')
            ->allowEmptyString('user_refid', null);

        $validator
            ->scalar('content_type')
            ->allowEmptyString('content_type');

        return $validator;
    }
}
