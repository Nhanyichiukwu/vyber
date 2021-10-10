<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Groups Model
 *
 * @property \App\Model\Table\GroupInvitesTable&\Cake\ORM\Association\HasMany $GroupInvites
 * @property \App\Model\Table\GroupJoinRequestsTable&\Cake\ORM\Association\HasMany $GroupJoinRequests
 * @property \App\Model\Table\GroupMediasTable&\Cake\ORM\Association\HasMany $GroupMedias
 * @property \App\Model\Table\GroupMembersTable&\Cake\ORM\Association\HasMany $GroupMembers
 * @property \App\Model\Table\GroupPostsTable&\Cake\ORM\Association\HasMany $GroupPosts
 *
 * @method \App\Model\Entity\Group newEmptyEntity()
 * @method \App\Model\Entity\Group newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Group[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Group get($primaryKey, $options = [])
 * @method \App\Model\Entity\Group findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Group patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Group[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Group|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Group saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Group[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Group[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Group[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Group[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class GroupsTable extends Table
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

        $this->setTable('groups');
        $this->setDisplayField('refid');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('GroupInvites', [
            'foreignKey' => 'group_id',
        ]);
        $this->hasMany('GroupJoinRequests', [
            'foreignKey' => 'group_id',
        ]);
        $this->hasMany('GroupMedias', [
            'foreignKey' => 'group_id',
        ]);
        $this->hasMany('GroupMembers', [
            'foreignKey' => 'group_id',
        ]);
        $this->hasMany('GroupPosts', [
            'foreignKey' => 'group_id',
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
            ->scalar('refid')
            ->maxLength('refid', 20)
            ->requirePresence('refid', 'create')
            ->notEmptyString('refid');

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
            ->allowEmptyString('description');

        $validator
            ->scalar('group_image')
            ->maxLength('group_image', 255)
            ->allowEmptyFile('group_image');

        $validator
            ->scalar('author')
            ->maxLength('author', 20)
            ->requirePresence('author', 'create')
            ->notEmptyString('author');

        return $validator;
    }

    /**
     * @param Query $query
     * @param array $options
     * @return Query
     */
    public function findForUser(Query $query, array $options)
    {
        $userID = $options['user'];
        $query = $query->matching(
            'GroupMembers',
            function (Query $q) use ($userID) {
                $q = $q->where(['user_refid' => $userID]);
                return $q;
            }
        );

        return $query;
    }
}
