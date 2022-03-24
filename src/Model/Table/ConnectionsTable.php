<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\User;
use Cake\Collection\Collection;
use Cake\Database\Connection;
use Cake\Database\Exception\DatabaseException;
use Cake\I18n\Date;
use Cake\ORM\Locator\TableLocator;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use App\Model\Table\AppTable;
use Cake\Validation\Validator;

/**
 * Connections Model
 *
 * @method \App\Model\Entity\Connection get($primaryKey, $options = [])
 * @method \App\Model\Entity\Connection newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Connection[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Connection|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Connection|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Connection patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Connection[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Connection findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ConnectionsTable extends AppTable
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config):void
    {
        parent::initialize($config);

        $this->setTable('connections');
        $this->setPrimaryKey('id');
        $this->setDisplayField('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users');

        $this->hasOne('Correspondents', [
            'foreignKey' => 'refid',
            'bindingKey' => 'correspondent_refid',
            'joinType' => 'INNER',
            'className' => 'Users'
        ]);
//        $this->hasMany('Connections', [
//            'foreignKey' => 'refid',
//            'targetForeignKey' => 'correspondent_refid',
//            'joinType' => 'INNER',
//            'className' => 'Users'
//        ]);
//        $this->hasOne('SuggestedUsers', [
//            'foreignKey' => 'refid',
//            'targetForeignKey' => 'suggested_user_refid',
//            'joinType' => 'LEFT',
//            'className' => 'Users'
//        ]);

//        $this->belongsTo('Users', [
//            'foreignKey' => 'user_refid',
//            'joinType' => 'INNER'
//        ]);
//        $this->hasMany('Users', [
//            'foreignKey' => 'refid'
//        ])
//            ->setClassName('Users')
//            ->setProperty('connection');
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
            ->allowEmptyString('id', null);

        $validator
            ->scalar('user_refid')
            ->maxLength('user_refid', 20)
            ->requirePresence('user_refid', 'create')
            ->allowEmptyString('user_refid', null);

        $validator
            ->scalar('correspondent_refid')
            ->maxLength('correspondent_refid', 20)
            ->requirePresence('correspondent_refid', 'create')
            ->allowEmptyString('correspondent_refid', null);

        return $validator;
    }


    /**
     * Fetches a list of a user's connections
     *
     * @param $user
     * @return Query
     */
    public function findForUser(Query $query, array $options)
    {
        $user = $options['user'];
//        $query = $query->where([
//                'OR' => [
//                    ['Connections.user_refid IS' => $user],
//                    ['Connections.correspondent_refid IS' => $user]
//                ]
//            ])
//            ->contain([
//                'Actors' => [
//                    'Profiles',
//                    'Connections' => [
//                        'Actors' => ['Profiles'],
//                        'Correspondents' => ['Profiles']
//                    ]
//                ],
//                'Correspondents' => [
//                    'Profiles',
//                    'Connections' => [
//                        'Actors' => ['Profiles'],
//                        'Correspondents' => ['Profiles']
//                    ]
//                ]
//            ]);
        return $query->where([
                'Connections.user_refid' => $user
            ])
            ->contain([
                'Correspondents' => [
                    'Profiles' => ['Roles','Genres','Industries'],
//                    'Connections' => [
//                        'Correspondents' => ['Profiles']
//                    ]
                ]
            ]);
    }
//
//    public function findSentRequests(Query $query, array $options = [])
//    {
//        return $query->where(['Connections.user_refid' => $options['actor'], 'status' => 'pending']);
//    }
//
//    public function findPendingRequests(Query $query, array $options = [])
//    {
//
//        return $query->where(['Connections.correspondent_refid' => $options['actor'], 'status' => 'pending']);
//    }





    /**
     * @param $user
     * @param array $except
     * @return array
     * @deprecated Use findUserConnections instead
     */

//    public function getUserConnections($user, array $except = [])
//    {
//        $query = $this
//            ->find()
//            ->where([
//                'OR' => [
//                    'user_refid' => $user,
//                    'correspondent_refid' => $user
//                ]
//            ]);
//
//        if (!empty($except)) {
//            $query = $query->where([
//                'user_refid !=' => $except['user'],
//                'correspondent_refid !=' => $except['user']
//            ]);
//        }
//
//        $results = [];
//        foreach ($query as $item)
//        {
//            $result = new \stdClass();
//            $result->dateConnected = $item->created;
//            if ($item->user_refid === $user) {
//                $result->refid = $item->correspondent_refid;
//            } else {
//                $result->refid = $item->user_refid;
//            }
//            $results[] = $result;
//        }
//
//        return $results;
//    }

    /**
     *
     * @param App/Model/Entity/User|string $user_one
     * @param App/Model/Entity/User|string $user_two
     * @return bool
     */
    public function existsBetween($user_one, $user_two)
    {
        if ($user_one instanceof User) {
            $a = $user_one->get('refid');
        } else {
            $a = $user_one;
        }

        if ($user_two instanceof User) {
            $b = $user_two->get('refid');
        } else {
            $b = $user_two;
        }

        return $this->exists([
            'user_refid' => $a,
            'correspondent_refid' => $b
        ]);
    }

    public function getConnectionDate($user1, $user2)
    {
        $query = $this->find()
            ->where([
                'user_refid' => $user1,
                'correspondent_refid' => $user2
            ])
            ->extract('created');

        return $query->toArray();
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
        $rules->add($rules->isUnique(['id']));
//        $rules->add($rules->existsIn('correspondent_refid', 'Users'));
//        $rules->add($rules->existsIn('user_refid', 'Users'));

        return $rules;
    }

    public function disconnect($actor, $connection)
    {
        if (! $this->existsBetween($actor, $connection))
            return true;

        if ($this->deleteAll([
            'OR' => [
                [
                    'user_refid' => $actor,
                    'correspondent_refid' => $connection
                ],
                [
                    'user_refid' => $connection,
                    'correspondent_refid' => $actor
                ]
            ]
        ])) {
            return true;
        }

        return false;
    }

    public function connect(string $user1, string $user2)
    {
        if ($this->existsBetween($user1, $user2)) {
            return true;
        }
        $now = Date::now();
        $connection = $this->newEntities([
            [
                'user_refid' => $user1,
                'correspondent_refid' => $user2,
                'created' => $now,
                'modified' => $now,
            ],
            [
                'user_refid' => $user2,
                'correspondent_refid' => $user1,
                'created' => $now,
                'modified' => $now,
            ]
        ]);

        try {
            $result = $this->saveManyOrFail($connection);
        } catch (\Throwable $e) {
            throw $e;
        }
        return $result;
    }
}
