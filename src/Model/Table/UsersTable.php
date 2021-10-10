<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\Email;
use App\Model\Entity\Phone;
use Cake\Collection\Collection;
use Cake\Database\Expression\QueryExpression;
use Cake\Event\Event;
use Cake\ORM\Locator\TableLocator;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Utility\Inflector;
use Cake\Utility\Security;
use Cake\Validation\Validation;
use Cake\Validation\Validator;
use function PHPUnit\Framework\matches;

/**
 * Users Model
 *
 * @method \App\Model\Entity\User newEmptyEntity()
 * @method \App\Model\Entity\User newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
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

        $this->setTable('users');
        $this->setDisplayField('refid');
        $this->setPrimaryKey('refid');

        $this->addBehavior('Timestamp');

        $this->hasMany('Posts', [
            'foreignKey' => 'author_refid',
            'joinType' => 'INNER',
            'className' => 'Posts'
        ]);
        $this->hasMany('Phones', [
            'foreignKey' => 'user_refid',
//            'joinType' => 'INNER'
        ]);
        $this->hasMany('Emails', [
            'foreignKey' => 'user_refid',
            'joinType' => 'INNER'
        ]);
        $this->hasOne('Profiles', [
            'foreignKey' => 'user_refid',
            'joinType' => 'INNER'
        ]);
//        $this->hasOne('MusicProfiles', [
//            'foreignKey' => 'user_refid',
//            'joinType' => 'INNER'
//        ]);
//        $this->hasOne('MovieProfiles', [
//            'foreignKey' => 'actor_refid',
//            'joinType' => 'INNER'
//        ]);
        $this->hasMany('ENews', [
            'foreignKey' => 'author',
            'joinType' => 'INNER'
        ]);

        $this->hasMany('Connections', [
            'foreignKey' => 'user_refid'
        ]);

        $this->hasMany('Followers', [
            'foreignKey' => 'followee_refid',
            'joinType' => 'INNER',
            'className' => 'Follows'
        ]);

        $this->hasMany('Followings', [
            'foreignKey' => 'follower_refid',
            'joinType' => 'INNER',
            'className' => 'Follows'
        ]);

        $this->hasMany('Photos', [
            'foreignKey' => 'author_refid',
            'joinType' => 'INNER'
        ]);

        $this->hasMany('Videos', [
            'foreignKey' => 'author_refid',
            'joinType' => 'INNER',
            'className' => 'Medias'
        ])->setConditions([
            'media_type' => 'video',
            'classification !=' => 'movie'
        ]);

        $this->hasMany('Songs', [
            'foreignKey' => 'author_refid',
            'joinType' => 'INNER',
            'className' => 'Medias'
        ])->setConditions([
            'media_type' => 'audio',
            'classification' => 'song'
        ]);

        $this->hasMany('Audios', [
            'foreignKey' => 'author_refid',
            'joinType' => 'INNER',
            'className' => 'Medias'
        ])->setConditions([
            'media_type' => 'audio',
            'classification !=' => 'song'
        ]);

        $this->hasMany('Commenters', [
            'foreignKey' => 'refid',
            'className' => 'Users'
        ]);

        $this->hasMany('Movies', [
            'foreignKey' => 'author_refid',
            'joinType' => 'INNER',
            'className' => 'Medias'
        ])->setConditions(['classification' => 'movie']);

        $this->hasMany('Albums', [
            'foreignKey' => 'owner_refid',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Awards', [
            'foreignKey' => 'user_refid',
            'joinType' => 'INNER'
        ]);

        $this->hasMany('Nominations', [
            'foreignKey' => 'user_refid',
            'joinType' => 'INNER'
        ]);

        $this->hasMany('Achievements', [
            'foreignKey' => 'user_refid',
            'joinType' => 'INNER'
        ]);

        $this->hasOne('ShowsProfiles', [
            'foreignKey' => 'user_refid',
            'joinType' => 'INNER'
        ]);
//        $this->hasOne('ComediansProfiles', [
//            'foreignKey' => 'actor_refid',
//            'joinType' => 'INNER'
//        ]);
        $this->hasMany('Likes', [
            'foreignKey' => 'actor',
            'joinType' => 'INNER'
        ]);

        $this->hasMany('Events', [
            'foreignKey' => 'user_refid',
            'joinType' => 'INNER'
        ]);

        $this->hasMany('Activities', [
            'foreignKey' => 'actor_refid',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Messages', [
            'foreignKey' => 'author_refid'
        ]);

        $this->hasMany('Conversations', [
            'foreignKey' => 'sender_refid'
        ]);

        $this->hasOne('HallOfFamers');

        $this->hasMany('UsersRatings', [
            'foreignKey' => 'user_refid'
        ]);

        $this->hasMany('SentRequests', [
            'foreignKey' => 'sender_refid',
            'className' => 'Requests'
        ]);

        $this->hasMany('ReceivedRequests', [
            'foreignKey' => 'recipient_refid',
            'className' => 'Requests'
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
            ->nonNegativeInteger('id')
//            ->requirePresence('id', 'create')
//            ->notEmptyString('id')
            ->add('id', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('refid')
            ->maxLength('refid', 20)
            ->requirePresence('refid', 'create')
            ->notEmptyString('refid', null, 'create');

        $validator
            ->scalar('firstname')
            ->maxLength('firstname', 45)
            ->requirePresence('firstname', 'create')
            ->notEmptyString('firstname');

        $validator
            ->scalar('othernames')
            ->maxLength('othernames', 255)
            ->allowEmptyString('othernames');

        $validator
            ->scalar('lastname')
            ->maxLength('lastname', 45)
            ->requirePresence('lastname', 'create')
            ->notEmptyString('lastname');

        $validator
            ->scalar('username')
            ->maxLength('username', 15)
            ->requirePresence('username', 'create')
            ->notEmptyString('username')
            ->add('username', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->requirePresence('password', 'create')
            ->notEmptyString('password');

        $validator
            ->scalar('gender')
            ->allowEmptyString('gender');

        $validator
            ->scalar('account_type')
            ->allowEmptyString('account_type');

        $validator
            ->scalar('account_status')
            ->allowEmptyString('account_status');

        $validator
            ->boolean('activated')
            ->allowEmptyString('activated');

        $validator
            ->boolean('is_hall_of_famer')
            ->allowEmptyString('is_hall_of_famer');

        $validator
            ->scalar('time_zone')
            ->maxLength('time_zone', 45)
            ->allowEmptyString('time_zone');

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
        $rules->add($rules->isUnique(['username']), ['errorField' => 'username']);
        $rules->add($rules->isUnique(['id']), ['errorField' => 'id']);
        $rules->add($rules->isUnique(['refid']), ['errorField' => 'refid']);

        return $rules;
    }


    /**
     * @param \App\Model\Entity\User $user
     * @return bool
     */
    public function register(\App\Model\Entity\User $user)
    {
        if ($user->hasErrors()) {
            return false;
        }
        if ($this->save($user)) {
            $event = new Event('Model.User.afterRegistration', $this, ['user' => $user]);
            $this->getEventManager()->dispatch($event);
            return true;
        }
        return false;
    }


    /**
     * Finds users similar to a given user
     *
     * @param \Cake\ORM\Query $query
     * @param array $options
     * @return \Cake\ORM\Query The modified query object
     */
    public function findUsersSimilarTo( Query $query, array $options )
    {
        $query = $query->contain([
            'Profiles',
//            'Emails',
//            'Phones'
        ]);
        $query = $this->findPeopleWithSameNameAs($query, $options);
        $query = $this->findPeopleWithSameBioAs($query, $options);
        $query = $this->findPeopleInSameCountryAs($query, $options);
        $query = $this->findPeopleInSameProvinceAs($query, $options);
        $query = $this->findPeopleInSameCityAs($query, $options);

        return $query;
    }
    /**
     * Finds users similar to a given user
     *
     * @param \Cake\ORM\Query $query
     * @param array $options
     * @return \Cake\ORM\Query The modified query object
     */
    public function findPeopleWithSameNameAs( Query $query, array $options ) {
        $user = $options['user'];
//        $query = $query->where([
//                    'OR' => [
//                        "MATCH(Users.firstname) AGAINST('" . $user->getFirstname()
//                        . "' IN BOOLEAN MODE)",
//                        "MATCH(Users.lastname) AGAINST('"
//                        . $user->getLastname() . "' IN BOOLEAN MODE)",
//                        "MATCH(Users.othernames) AGAINST('"
//                        . $user->getOthernames() . "' IN BOOLEAN MODE)"
//                    ]
//                ]);
        $query = $query->where([
            'OR' => [
                'Users.firstname LIKE' => '%' . $user->getFirstname() . '%',
                'Users.lastname LIKE' => '%' . $user->getLastname() . '%'
            ]
        ]);
        if (! empty($user->getOthernames())) {
            $query = $query->where([
                'OR' => [
                    'Users.othernames LIKE' => '%'.$user->getOthernames().'%'
                ]
            ]);
        }

        return $query;
    }
    /**
     * Finds users similar to a given user
     *
     * @param \Cake\ORM\Query $query
     * @param array $options
     * @return \Cake\ORM\Query The modified query object
     */
    public function findPeopleWithSameBioAs( Query $query, array $options ) {
        $user = $options['user'];
        if (! empty($user->profile->getBio())) {
            $query = $query->where([
                'MATCH(Profiles.about) AGAINST(\'' . addslashes($user->profile->getBio())
                . '\' IN BOOLEAN MODE)'
            ]);
        }

        return $query;
    }
    /**
     * Finds users similar to a given user
     *
     * @param \Cake\ORM\Query $query
     * @param array $options
     * @return \Cake\ORM\Query The modified query object
     */
    public function findPeopleInSameCountryAs( Query $query, array $options ) {
        $user = $options['user'];
        $newQuery = clone $query;
        if (!empty($user->profile->getCountryOfResidence())) {
            $newQuery = $newQuery->where([
                'OR' => [
                    "MATCH(Profiles.country_of_residence) AGAINST('+"
                    . $user->profile->getCountryOfResidence()
                    . "' IN BOOLEAN MODE)"
                ]
            ]);
        }

        return $newQuery;
    }

    /**
     * Finds users similar to a given user
     *
     * @param \Cake\ORM\Query $query
     * @param array $options
     * @return \Cake\ORM\Query The modified query object containing users who
     * live in same city as the given user
     */
    public function findPeopleInSameCityAs( Query $query, array $options ) {
        $user = $options['user'];
        $newQuery = clone $query;
        if (! empty($user->profile->getCurrentCity())) {
            $newQuery = $newQuery->where([
                'OR' => [
                    "MATCH(Profiles.current_city) AGAINST('+"
                    . $user->profile->getCurrentCity()
                    . "' IN BOOLEAN MODE)"
                ]
            ]);
        }

        return $newQuery;
    }
    /**
     * Finds users similar to a given user
     *
     * @param \Cake\ORM\Query $query
     * @param array $options
     * @return \Cake\ORM\Query The modified query object
     */
    public function findPeopleInSameProvinceAs( Query $query, array $options ) {
        $user = $options['user'];
        $newQuery = clone $query;
        if (! empty($user->profile->getStateOfResidence())) {
            $newQuery = $newQuery->where([
                'OR' => [
                    "MATCH(Profiles.state_of_residence) AGAINST('+"
                    . $user->profile->getStateOfResidence()
                    . "' IN BOOLEAN MODE)"
                ]
            ]);
        }

        return $newQuery;
    }

    /**
     * Find users who are trending for the day, week, or season, based on
     * the number of people talking about them
     * @param Query $query
     * @param array $options
     * @return Query
     */
    public function findTrending(Query $query, array $options = null)
    {
        $newQuery = clone $query;
        return $newQuery;
    }

    /**
     * Find users who are popular on the site based on their search appearances,
     * number of followers and/or number of people talking about them
     * @param Query $query
     * @param array $options
     * @return Query
     */
    public function findPopular(Query $query, $options = []): Query
    {
        $newQuery = clone $query;

        return $newQuery;
    }

    /**
     * Find users with the highest ratings
     *
     * @param Query $query
     * @param array $options
     * @return Query
     */
    public function findTopRated(Query $query, $options = []): Query
    {
        $newQuery = clone $query;
//        $newQuery = $newQuery->select([
//            'rating' => $newQuery->func()->sum('UsersRatings.rating'),
////            'topRated' => $newQuery->func()->max('rating')
//        ])
        $newQuery = $newQuery->contain(
            'UsersRatings', function (Query $q) {
                return $q;
//            $q->where(function (QueryExpression $exp, Query $query) {
//                $query->map(function ($row, $index, $iterator) {
//                    $row['ratings']
//                });
//                return $exp->addCase(
//                    [
//                        // Top rated
//                        $query->map(function ($row, $index, $iterator) {
//
//                        })
//                    ],
//                    ['topRated'],
//                    ['string']
//                );
//            });
        });
//        ->leftJoinWith('UsersRatings')
//            ->enableAutoFields(true)
//            ->orderAsc('rating')
//            ->where(function (QueryExpression $exp, Query $query) {
//                return $exp->addCase(
//                    [
//                        // Top rated
//                        $query->map(function ($row, $index, $iterator) {
//
//                        })
//                    ],
//                    ['topRated'],
//                    ['string']
//                );
//            })
//            ->limit(24);

        return $newQuery;
    }

    /**
     * @param Query $query
     * @param array|null $options
     * @return Query
     */
    public function fetchArtists(Query $query, array $options = null)
    {




        return $query;
    }

    public function fetch(array $filters = null)
    {
        $query = $this->find()->contain([
            'Profiles' => [
                'UserGenres' => ['Genres'],
                'UserRoles' => ['Roles'],
                'UserIndustries' => ['Industries']
            ]
        ]);

        if (isset($filters['_i'])) {
            $industry = unserialize(
                base64_decode($filters['_i'])
            );
            $query = $query->filter(function ($row) use($industry) {
                $thisUserIndustries = (array) \collection($row->profile->user_industries)->extract(
                    function ($userGenreObj) {
                        return $userGenreObj->industry->slug;
                    }
                )
                    ->toArray();
                $result = in_array($industry, $thisUserIndustries);
                return $result;
            });
        }

        if (count($filters)) {
            $query = $this->applyFilters($query, $filters);
        }

        return $query;
    }

    private function applyFilters($query, array $filterParams)
    {
        if (isset($filterParams['genre'])) {
            $query = $query->filter(function ($row) use ($filterParams) {
                $result = false;
                if (count($row->profile->user_genres)) {
                    $thisUserRoles = (array) \collection($row->profile->user_genres)->extract(
                        function ($userGenreObj) {
                            return $userGenreObj->genre->slug;
                        }
                    )
                        ->toArray();
                    $result = in_array($filterParams['genre'], $thisUserRoles);
                }
                return $result;
            });
        }
        if (isset($filterParams['category'])) {
//            $query = $query->filter(function ($row) use ($filterParams) {
//                $result = false;
//                if (count($row->profile->user_genres)) {
//                    $thisUserRoles = (array) \collection($row->profile->user_genres)->extract(
//                        function ($item) {
//                            return $item->slug;
//                        }
//                    )
//                        ->toArray();
//                    $result = in_array($filterParams['genre'], $thisUserRoles);
//                }
//                return $result;
//            });
        }
        if (isset($filterParams['role'])) {
            $query = $query->filter(function ($row) use ($filterParams) {
                $result = false;
                if (count($row->profile->user_roles)) {
                    $thisUserRoles = (array) \collection($row->profile->user_roles)->extract(
                        function ($userRoleObj) {
                            return $userRoleObj->role->slug;
                        }
                    )
                        ->toArray();
                    $result = in_array($filterParams['role'], $thisUserRoles);
                }

                return $result;
            });
        }

        return $query;
    }

    public function suggestPossibleConnections(array $bases, $user = null, $profile = null)
    {
        $suggestions = [];
        $connections = (new TableLocator())->get('Connections');

        if (in_array('recent_connections', $bases) && $user) {
            $query = $connections->getUserConnections($user->refid)
                ->orderDesc('Connections.created')
                ->getIterator()->shuffle()->take(5, 0);

            $connectionsOfConnections = $connections->connectionsOfConnections(null, $query);
            (new Collection($connectionsOfConnections))->each(function ($row) use (&$suggestions) {
                $suggestions[] = $row->correspondent;
            });
        }

        // Offers suggestions to a user based on his/her personality
        // For example: if the user is a song writer, suggested users could
        // include producers, recording artists, etc.
        // This is a very complex suggestion algorythme
        if(in_array('personality', $bases)) {

        }

        // Offers suggestions based on people who share some level of similarity
        // with a given user
        if (in_array('similar_users', $bases) && $profile) {
            $query = $this->find('usersSimilarTo', ['user' => $profile]);
            $query = $query->getIterator()->shuffle()->take(5, 0);
            if (! $query->isEmpty()) {
                $suggestions += $query->toArray();
            }
        }

        // Offer suggestions from a given user's connections list
        if (in_array('profile_connections', $bases) && $profile) {
            $userConnections = $connections->getUserConnections($profile->refid)
                ->orderDesc('Connections.created')
                ->getIterator()->shuffle()->take(5, 0);

            $userConnections->each(function($row) use ($suggestions) {
                $suggestions += $row->correspondent;
            });
        }

        return $suggestions;
    }

    /**
     *
     * @param \Cake\ORM\Query $query
     * @param array $options
     * @return \Cake\ORM\Query $query
     */
    public function getConnectedTo($user)
    {
        $ConxTbl = (new TableLocator())->get('connections');
//        $query = $ConxTbl->find()->selectAllExcept($ConxTbl, ['actor_refid'])
        $query = $this->find()
            ->select(['refid'])
            ->where([
                'Users.refid' => $user
            ])
            ->contain(['Connections']);
        return $query;
    }

    /**
     * @param Query $query
     * @param array $options
     * @return array
     */
    public function findConnections( \Cake\ORM\Query $query, array $options)
    {
        $user = $options['user'];
        $contains = [
            'Connections' => [
                'Correspondents' => ['Profiles']
            ]
        ];
        $query = $this->findUser($query, ['user' => $user], $contains, true);

        return $query->extract('connections')->first();
    }


    /**
     * Fetches a list of users who are not connected to the given user
     *
     * @param string $user
     * @return Query
     */
    public function findNonConnections( $user )
    {
        $Connections = (new TableLocator())->get('Connections');
        $Requests = (new TableLocator())->get('Requests');

        $connections = (array) $this->find('connections', ['user' => $user]);
        $outstandingRequests = (array) $Requests->getOutstandingRequests($user);
//        $connectedUsersIds = [];

        // First, exclude the user from the list of users in the result
        $users = $this
            ->find()
            ->where([
                'Users.refid !=' => $user
            ]);

        // Skip any user who is already connected to the user
        array_map(function ($row) use (&$users) {
            $users = $users->where([
                ['Users.refid !=' => $row->actor_refid],
                ['Users.refid !=' => $row->correspondent_refid]
            ]);
        }, $connections);

        // Skip any user who has already sent or recieved a request to/from
        // this user
        array_map(function ($row) use (&$users) {
            $users = $users->where([
                ['Users.refid !=' => $row->actor_refid],
                ['Users.refid !=' => $row->correspondent_refid]
            ]);
        }, $outstandingRequests);

        return $users;
    }

    /**
     *
     * @param Query $query
     * @param array $options
     * @param array $contains
     * @param bool $overwriteContain
     * @return Query
     */
    public function findUser($query, $options = []): Query
    {
        $credential = $options['user'];
        $locator = new TableLocator();

        if (Validation::email($credential)) {
            $Emails = $locator->get('Emails');
            if ($Emails->exists(['address' => $credential])) {
                $email = $Emails->find('all')
                    ->where(['address' => $credential])
                    ->first();
                if ($email instanceof Email) {
                    $credential = $email->get('user_refid');
                }
            }
        }
        if (is_numeric($credential)) {
            $Phones = $locator->get('Phones');
            if ($Phones->exists(['number' => $credential])) {
                $phone = $Phones->find('all')
                    ->where(['number' => $credential])
                    ->first();
                if ($phone instanceof Phone) {
                    $credential = $phone->get('user_refid');
                }
            }
        }

        $query = $query->where([
            'OR' => [
                ['refid' => $credential],
                ['username' => $credential]
            ]
        ]);

        return $query;
    }

    /**
     *
     * @param string $credential
     * @param array $contain
     * @param boolean $overwriteContain
     * @return array|\App\Model\Entity\User|null
     */
    public function getUser(
        $credential,
        $contains = [],
        $overwriteContain = false
    ): ?\App\Model\Entity\User
    {
        $defaultContain = [
            'Profiles',
            'Phones',
            'Emails'
        ];
        if (empty($contains)) {
            $contains = $defaultContain;
        }
        else {
            if (false === $overwriteContain) {
                $contains = array_merge($defaultContain, $contains);
            }
        }

        $query = $this->find();
        $query = $this->findUser($query, ['user' => $credential])
            ->contain($contains);

        return $query->first();
    }

    /**
     * Runs through connections list of two users to see if they have any
     * mutual connections. If an operator and a number are provided, the
     * method will compare the number of connections returned against the
     * given number using the operator
     *
     * @param \App\Model\Table\User $user1
     * @param \App\Model\Table\User $user2
     * @param string $operator valid operators are '>' and '<';
     * @param int $number
     * @return boolean
     */
    public function haveMutualConnections(
        \App\Model\Entity\User $user1,
        \App\Model\Entity\User $user2,
        string $operator = null,
        int $number = null
    ) {
        $Connections = (new TableLocator())->get('Connections');

        $mutuals = $Connections->getMutualConnections($user1, $user2);

        if ($mutuals === null) {
            return false;
        }

        if ($operator && $number) {
            if ($operator === '>' && count($mutuals) > $number) {
                return true;
            }
            elseif ($operator === '<' && count($mutuals) < $number) {
                return true;
            }

            return false;
        }

        if (count($mutuals)) {
            return true;
        }
    }
}
