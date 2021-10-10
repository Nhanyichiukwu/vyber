<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\Collection\CollectionInterface;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use App\Model\Table\AppTable;

/**
 * Follows Model
 *
 * @method \App\Model\Entity\Follow get($primaryKey, $options = [])
 * @method \App\Model\Entity\Follow newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Follow[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Follow|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Follow|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Follow patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Follow[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Follow findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class FollowsTable extends AppTable
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

        $this->setTable('follows');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsToMany('Followings', [
            'foreignKey' => 'follower_refid',
            'joinType' => 'INNER',
            'className' => 'Users'
        ]);

        $this->belongsToMany('Followers', [
            'foreignKey' => 'refid',
            'bindingKey' => 'followee_refid',
            'joinType' => 'INNER',
            'className' => 'Users'
        ]);

//        $this->belongsTo('Followers', [
//            'foreignKey' => 'followee_refid',
//            'bindingKey' => 'refid',
//            'joinType' => 'INNER'
//        ]);
//
//        $this->hasMany('Followings', [
//            'foreignKey' => 'follower_refid',
//            'bindingKey' => 'refid',
//            'joinType' => 'LEFT'
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
            ->scalar('follower_refid')
            ->maxLength('follower_refid', 20)
            ->requirePresence('follower_refid', 'create')
            ->allowEmptyString('follower_refid', null);

        $validator
            ->scalar('followee_refid')
            ->maxLength('followee_refid', 20)
            ->requirePresence('followee_refid', 'create')
            ->allowEmptyString('followee_refid', null);

        return $validator;
    }

    /**
     * @param Query $query
     * @param array $options
     * @return Query|null
     */
    public function findFollowings( Query $query, array $options): ?Query
    {
        $follower = $options['user'];
        return $query->where(['Follows.follower_refid' => $follower])
            ->contain([
                'Followings' => ['Profiles']
            ]);
    }

    /**
     * @param Query $query
     * @param array $options
     * @return Query|null
     */
    public function findFollowers( Query $query, array $options): ?Query
    {
        $followee = $options['user'];
        return $query->where(['Follows.followee_refid' => $followee])
            ->contain([
                'Followers' => ['Profiles']
            ]);
    }

}
