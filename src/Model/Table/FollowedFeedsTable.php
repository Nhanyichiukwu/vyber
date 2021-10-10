<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FollowedFeeds Model
 *
 * @property \App\Model\Table\FolloweesTable|\Cake\ORM\Association\BelongsTo $Followees
 * @property \App\Model\Table\FollowersTable|\Cake\ORM\Association\BelongsTo $Followers
 *
 * @method \App\Model\Entity\FollowedFeed get($primaryKey, $options = [])
 * @method \App\Model\Entity\FollowedFeed newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\FollowedFeed[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FollowedFeed|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FollowedFeed|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FollowedFeed patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FollowedFeed[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\FollowedFeed findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class FollowedFeedsTable extends Table
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

        $this->setTable('followed_feeds');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

//        $this->belongsTo('Followees', [
//            'foreignKey' => 'followee_id',
//            'joinType' => 'INNER'
//        ]);
//        $this->belongsTo('Followers', [
//            'foreignKey' => 'follower_id',
//            'joinType' => 'INNER'
//        ]);
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
            ->scalar('followee_industry')
            ->requirePresence('followee_industry', 'create')
            ->allowEmptyString('followee_industry', null);

        $validator
            ->scalar('followee_role')
            ->maxLength('followee_role', 60)
            ->requirePresence('followee_role', 'create')
            ->allowEmptyString('followee_role', null);

        $validator
            ->scalar('follower_industry')
            ->requirePresence('follower_industry', 'create')
            ->allowEmptyString('follower_industry', null);

        $validator
            ->scalar('follower_role')
            ->maxLength('follower_role', 60)
            ->requirePresence('follower_role', 'create')
            ->allowEmptyString('follower_role', null);

        $validator
            ->scalar('follow_type')
            ->requirePresence('follow_type', 'create')
            ->allowEmptyString('follow_type', null);

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
//        $rules->add($rules->existsIn(['followee_id'], 'Followees'));
//        $rules->add($rules->existsIn(['follower_id'], 'Followers'));

        return $rules;
    }
}
