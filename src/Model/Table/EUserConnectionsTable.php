<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * UserConnections Model
 *
 * @method \App\Model\Entity\UserConnection get($primaryKey, $options = [])
 * @method \App\Model\Entity\UserConnection newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\UserConnection[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\UserConnection|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UserConnection|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UserConnection patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\UserConnection[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\UserConnection findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UserConnectionsTable extends Table
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

        $this->setTable('e_user_connections');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_refid',
            'targetForeignKey' => 'refid',
            'joinTable' => 'e_users'
        ]);
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
            ->allowEmptyString('id', 'create');

        $validator
            ->scalar('party_a')
            ->maxLength('party_a', 20)
            ->requirePresence('party_a', 'create')
            ->allowEmptyString('party_a', false);

        $validator
            ->scalar('party_b')
            ->maxLength('party_b', 20)
            ->requirePresence('party_b', 'create')
            ->allowEmptyString('party_b', false);

        return $validator;
    }


    /**
     *
     * @param \Cake\ORM\Query $query
     * @param array $options
     * @return \Cake\ORM\Query $query
     */
    public function findUserConnections( Query $query, array $options )
    {
        $connections = [];
        $user = $options['user'];
//        $query = $query->where(['OR' => [
//                        'party_a' => $user,
//                        'party_b' => $user
//                    ]
//                ]);
        $query = $query
                ->selectAllExcept($this, ['party_b'])
                ->where([
                    'party_b' => $user
                ])
                ->selectAllExcept($this, ['party_a'])
                ->where(['party_a' => $user]);

        return $query;
    }

    public function getUserConnections($user, array $except = null)
    {
        $query = $this
                ->find()
                ->where([
                    'OR' => [
                        'party_a' => $user,
                        'party_b' => $user
                    ]
                ]);

        if ($except !== null) {
            $query = $query->where([
                'party_a !=' => $except['user'],
                'party_b !=' => $except['user']
            ]);
        }

        $results = [];
        foreach ($query as $item)
        {
            $result = new \stdClass();
            $result->dateConnected = $item->created;
            if ($item->party_a === $user) {
                $result->refid = $item->party_b;
            } else {
                $result->refid = $item->party_a;
            }
            $results[] = $result;
        }

        return $results;
    }

    public function findUnconnectedWith( Query $query, array $options )
    {
//        $UsersTbl = TableRegistry::getTableLocator()->get('Users');
//        $users = $UsersTbl->find('all');
//        $connectionsArray = $connections->toArray();
//        $connectionsIds = [$options['user']];
//
//        foreach ($connectionsArray as $connection )
//        {
//            $id = '';
//            if ( $options['user'] === $result->party_a )
//                $id = $result->party_b;
//            elseif ( $options['user'] === $result->party_b )
//                $id = $result->party_a;
//            $connectionsIds[] = $id; // $this->find('byRefid', ['refid' => $id]);
//        }
//
//        $query = $query->where(['AND' => $this->loopThrough($connectionsIds, '!=', 'Users.refid')]);
//
//        return $query;
        $query = $query
                ->select('id')
                ->where([
                    'OR' => [
                        'Connections.party_a' => $options['user'],
                        'Connections.party_b' => $options['user']
                    ]
                ])
                ->notMatching('Connections', function ($q) {
                    return $q->where([
                        'Connections.party_a != ' => 'Users.refid',
                        'Connections.party_b != ' => 'Users.refid'
                    ]);
                });
//                ->join([
//                    'u' => [
//                        'table' => 'users',
//                        'type' => 'INNER',
//                        'conditions' => 'u.refid != connections.party_a AND u.refid != connections.party_b'
//                    ]
//                ]);
//                ->join(['unconnectedUsers' => ['table' => 'Users', 'type' => 'RIGHT']])
//                ->where([
//                    'AND' => [
//                        'Users.refid !=' => 'Connections.party_a',
//                        'Users.refid !=' => 'Connections.party_b',
//                        'Users.refid !=' => $options['user']
//                    ]
//                ]);
        return $query;
    }

    public function isAlreadyConnected($user, $target_account)
    {
        return $this->exists([
            'OR' => [
                        [
                            'party_a' => $user,
                            'party_b' => $target_account
                        ],
                        [
                            'party_a' => $target_account,
                            'party_b' => $user
                        ]
                    ]
            ]);
    }

    public function getConnectionDate($user1, $user2)
    {
        $query = $this->find()
                ->where([
                    'OR' => [
                        [
                            'party_a' => $user1,
                            'party_b' => $user2
                        ],
                        [
                            'party_a' => $user2,
                            'party_b' => $user1
                        ]
                    ]
                ])->extract('created');

        return $query->toArray();
    }
}
