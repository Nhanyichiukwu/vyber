<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\Email;
use App\Model\Entity\Phone;
use App\Model\Entity\User;
use App\Utility\CustomString;
use Cake\Collection\Collection;
use Cake\Database\Expression\QueryExpression;
use Cake\Datasource\Exception\RecordNotFoundException;
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
            ->scalar('account_type')
            ->allowEmptyString('account_type');

        $validator
            ->scalar('account_status')
            ->allowEmptyString('account_status');

        $validator
            ->boolean('activated')
            ->allowEmptyString('activated');

        $validator
            ->boolean('is_verified')
            ->allowEmptyString('is_verified');

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
        $targetUser = is_string($options['target_user'])
            ? $this->getUser($options['target_user'])
            : $options['target_user'];

        $appUser = null;
        if (isset($options['user'])) {
            $appUser = is_string($options['user'])
                ? $this->getUser($options['user'])
                : $options['user'];
        }

        $query = $query
//            ->whereNotNull(['country_of_residence', 'state_of_residence', 'current_city'])
            ->contain([
            'Profiles',
        ]);

        $mainConditions = $locationConditions = [];

        $profileAssoc = $this->getAssociation('Profiles')->getTarget();


        /********************************************************************************/
        /*** First criteria: the users must have at least a role or a genre in common ***/
        /********************************************************************************/
        // People with similar roles as the targetUser
        if ($targetUser->profile->hasValue('roles')) {
            $roles = \collection($targetUser->profile->getRoles())
                ->extract('slug')->toArray();
            $similarRoles = $profileAssoc->find()
                ->select(['user_refid'])
                ->distinct()
                ->matching('Roles', function (Query $q) use($roles) {
                    return $q->where(['Roles.slug IN' => $roles]);
                });

            $mainConditions[] = ['Users.refid IN' => $similarRoles];
        }

        // People with similar genres as the user
        if ($targetUser->profile->hasValue('genres')) {
            $genres = \collection($targetUser->profile->getGenres())
                ->extract('slug')->toArray();
            $similarGenres = $profileAssoc->find()
                ->select(['user_refid'])
                ->distinct()
                ->matching('Genres', function (Query $q) use ($genres) {
                    return $q->where(['Genres.slug IN' => $genres]);
                });
            $mainConditions[] = ['Users.refid IN' => $similarGenres];
        }

        if (!empty($mainConditions)) {
            $query = $query->where(['OR' => $mainConditions]);
        }


        /*************************************************************************************/
        /*** And, secondly they must at least live in the same country, province, or city. ***/
        /*************************************************************************************/

        // Profiles of people who live in the same country
        if ($targetUser->profile->hasValue('country_of_residence')) {
            $sameCountry = $profileAssoc->find()
                ->select(['user_refid'])
                ->distinct()
                ->where([
                    'country_of_residence' => $targetUser->profile->getCountryOfResidence()
                ]);
            $locationConditions[] = ['Users.refid IN' => $sameCountry];
        }

        // Profiles of people who live in the same state/province as the user
        if ($targetUser->profile->hasValue('state_of_residence')) {
            $sameProvince = $profileAssoc->find()
                ->select(['user_refid'])
                ->distinct()
                ->where([
                    'state_of_residence' => $targetUser->profile->getStateOfResidence()
                ]);
            $locationConditions[] = ['Users.refid IN' => $sameProvince];
        }

        // People in the same city as the user
        if ($targetUser->profile->hasValue('current_city')) {
            $sameCity = $profileAssoc->find()
                ->select(['user_refid'])
                ->distinct()
                ->where([
                    'current_city' => $targetUser->profile->getCurrentCity()
                ]);
            $locationConditions[] = ['Users.refid IN' => $sameCity];
        }
        if (!empty($locationConditions)) {
            $query = $query->andWhere(['OR' => $locationConditions]);
        }


        $query = $query->having(['Users.refid !=' => $targetUser->refid]);
        if ($appUser instanceof User) {
            $query = $query->andHaving(['Users.refid !=' => $appUser->refid]);
        }

        /********* DO NOT REMOVE *********/
//        $query = $query->where(
//            function (QueryExpression $exp, Query $query) use ($sameCountry, $sameProvince, $sameCity) {
//                return $query->newExpr()
//                    ->or(['Users.refid IN' => $sameCountry])
//                    ->add(['Users.refid IN' => $sameProvince])
//                    ->add(['Users.refid IN' => $sameCity]);
//            }
//        );
        /************ DO NOT REMOVE ************/

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
        if (!empty($user->getOthernames())) {
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
        $user = is_string($options['user'])
            ? $this->getUser($options['user'])
            : $options['user'];
        if (! empty($user->profile->getBio())) {
            $query = $query->where([
                'OR' => [
                    'MATCH(Profiles.description) AGAINST(\'' . addslashes($user->profile->getBio())
                    . '\' IN BOOLEAN MODE)'
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
    public function findByCountry(Query $query, array $options)
    {
        $country = $options['country'];
        if (!empty($user->profile->getCountryOfResidence())) {
//            $query = $query->where([
//                'OR' => [
//                    "MATCH(Profiles.country_of_residence) AGAINST('+"
//                    . $user->profile->getCountryOfResidence()
//                    . "' IN BOOLEAN MODE)"
//                ]
//            ]);
            $query = $query->matching('Profiles', function (Query $q) use($user) {
                return $q->where([
                    'OR' => [
                        'Profiles.country_of_residence' => $user->profile->getCountryOfResidence()
                    ]
                ]);
            });
        }

        return $query;
    }

    /**
     * Finds users similar to a given user
     *
     * @param \Cake\ORM\Query $query
     * @param array $options
     * @return \Cake\ORM\Query The modified query object containing users who
     * live in same city as the given user
     */
    public function findByCity( Query $query, array $options ) {
//        $user = $options['user'];
//        $newQuery = clone $query;
//        if (! empty($user->profile->getCurrentCity())) {
//            $newQuery = $newQuery->where([
//                'OR' => [
//                    "MATCH(Profiles.current_city) AGAINST('+"
//                    . $user->profile->getCurrentCity()
//                    . "' IN BOOLEAN MODE)"
//                ]
//            ]);
//        }
        $user = is_string($options['user'])
            ? $this->getUser($options['user'])
            : $options['user'];


        if (!empty($user->profile->getCurrentCity())) {
//            $query = $query->where([
//                'OR' => [
//                    "MATCH(Profiles.country_of_residence) AGAINST('+"
//                    . $user->profile->getCountryOfResidence()
//                    . "' IN BOOLEAN MODE)"
//                ]
//            ]);
            $query = $query->matching('Profiles', function (Query $q) use($user) {
                return $q->where([
                    'OR' => ['Profiles.current_city' => $user->profile->getCurrentCity()]
                ]);
            });
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
    public function findByProvince( Query $query, array $options )
    {
//        $user = $options['user'];
//        $newQuery = clone $query;
//        if (!empty($user->profile->getStateOfResidence())) {
//            $newQuery = $newQuery->where([
//                'OR' => [
//                    "MATCH(Profiles.state_of_residence) AGAINST('+"
//                    . $user->profile->getStateOfResidence()
//                    . "' IN BOOLEAN MODE)"
//                ]
//            ]);
//        }
//
//        return $newQuery;
        $user = is_string($options['user'])
            ? $this->getUser($options['user'])
            : $options['user'];


        if (!empty($user->profile->getStateOfResidence())) {
            $query = $query->matching('Profiles', function (Query $q) use($user) {
                return $q->where([
                    'OR' => ['Profiles.state_of_residence' => $user->profile->getStateOfResidence()]
                ]);
            });
        }
        return $query;
    }

    /**
     * @param Query $query
     * @param array|null $options
     * @return Query
     */
    public function findUsersWithSimilarRoles(Query $query, array $options = null)
    {
        $roles = $options['roles'];
        $query = $query
            ->matching('Profiles.Roles', function (Query $q) use($roles) {
            return $q->where([
                'OR' => ['Roles.slug IN' => $roles]
            ]);
        });

        return $query;
    }

    /**
     * @param Query $query
     * @param array|null $options
     * @return Query
     */
    public function findUsersWithSimilarGenres(Query $query, array $options = null)
    {
        $genres = $options['genres'];
        $query = $query
            ->distinct()
            ->matching('Profiles.Genres', function (Query $q) use($genres) {
            return $q->where([
                'OR' => ['Genres.slug IN' => $genres]
            ]);
        });

        return $query;
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
     * @param array|null $options
     * @return Query
     */
    public function fetchArtists($query, array $options = null)
    {
        $artisticRoles = ['singer','rapper','backup-singer','vocalist'];

        $query = $query->filter(function ($user) use ($artisticRoles) {
            $result = false;
            if (count($user->profile->roles)
            ) {
                $thisUserRoles = (array) \collection($user->profile->roles)
                    ->extract(
                        function ($userRoleObj) {
                            return $userRoleObj->slug;
                        }
                    )
                    ->toArray();
                $intersection = array_intersect($thisUserRoles, $artisticRoles);
                if (count($intersection)) {
                    $result = true;
                }
            }

            return $result;
        });

        return $query;
    }

    public function fetch(array $filters = null)
    {
        $query = $this->find()->contain([
            'Profiles' => [
                'Genres',
                'Roles',
                'Industries'
            ]
        ]);

        if (isset($filters['_i'])) {
            $industry = unserialize(
                base64_decode($filters['_i'])
            );
            $industry = CustomString::hyphenate($industry);
            $query = $query->filter(function ($row) use($industry) {
                $thisUserIndustries = (array) \collection(
                    $row->profile->industries
                )
                    ->extract(function ($userIndustryObj) {
                        return $userIndustryObj->slug;
                    })
                    ->toArray();
                return in_array($industry, $thisUserIndustries);
            });
//            $profileAssoc = $this->getAssociation('Profiles')->getTarget();
//            $industryAssoc = $profileAssoc->getAssociation('Industries')->getTarget();
//            $matchingIndustry = $industryAssoc->find()
//                ->select(['id'])
//                ->distinct()
//                ->where(['slug' => $industry]);
//            $profilesMatchingIndustry = $profileAssoc->find()
//                ->select(['user_refid'])
//                ->distinct()
//                ->where(['industries LIKE' => '%' . $industry . '%']);
//            pr($profilesMatchingIndustry->all());
//            exit;
        }
        if (isset($filters['_u_p'])) {

            $userProfession = Inflector::camelize($filters['_u_p']);
            $userProfession = Inflector::pluralize($userProfession);
            $fetchUserByProfession = 'fetch' . $userProfession;
            if (method_exists($this, $fetchUserByProfession)) {
                $query = $this->{$fetchUserByProfession}($query);
            }
        }

        if (count($filters)) {
            $query = $this->applyFilters($query, $filters);
        }

        return $query;
    }

    private function applyFilters($query, array $filters)
    {
        if (isset($filters['genre'])) {
            $query = $query->filter(function ($row) use ($filters) {
                $result = false;
                if (count($row->profile->genres)) {
                    $thisUserRoles = (array) \collection($row->profile->genres)->extract(
                        function ($userGenreObj) {
                            return $userGenreObj->slug;
                        }
                    )
                        ->toArray();
                    $result = in_array($filters['genre'], $thisUserRoles);
                }
                return $result;
            });
        }
        if (isset($filters['category'])) {
            $query = $query->filter(function ($row) use ($filters) {
                $result = false;
                if (count($row->profile->genres)) {
                    $thisUserCateories = (array) \collection($row->profile->genres)->extract(
                        function ($item) {
                            return $item->slug;
                        }
                    )
                        ->toArray();
                    $result = in_array($filters['category'], $thisUserCateories);
                }
                return $result;
            });
        }
        if (isset($filters['role'])) {
            $query = $query->filter(function ($row) use ($filters) {
                $result = false;
                if (count($row->profile->roles)) {
                    $thisUserRoles = (array) \collection($row->profile->roles)
                        ->extract(
                        function ($userRoleObj) {
                            return $userRoleObj->slug;
                        }
                    )
                        ->toArray();
                    $result = in_array($filters['role'], $thisUserRoles);
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
        // This is a very complex suggestion algorithm
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
     * Fetch a list of people who the user might know.
     *
     * The idea is to find people who the current user might know
     * using a list of persons who the user is already connected to,
     * we try to compare between their own connections to see if we can
     * find anyone the user might know
     * Example: Using user Mike and friends
     * Mike: friends[John, Joe, Jane, Toby, Ella];
     * John: friends[Peter, James, Joahn, Joe, Mike]
     * Joe: friends[Toby, Ella, Mike, John]
     * In the above example Mike is the principal person.
     * Given that John and Joe, Joe and Toby, Joe and Ella, all have
     * people in common, then there is a great chance
     * that Mike might know some of John's and Joe's
     * connections, and so on...
     * Now for each two connections of Mike's, we check if they too, are
     * connected to each other, if true, we import their connections
     * as people that Mike might know... Just keeping it shallow...
     *
     * @param Query $query
     * @param array $options
     * Valid keys include 'user' (required): The user to make suggestions for, and 'account'
     * (optional): If provided, suggestions will be based on the connections of 'account',
     * otherwise, it will default to the connections of 'user'.
     * @return Query A list of matched users
     */
    public function findPossibleAcquaintances(Query $query, array $options = [])
    {
        $user = $options['user']; // The user who suggestion is being made to
        $account = $options['account'] ?? null; // The user on whose profile the suggestion is based

//        $userConnections = $this->User->connections($user->refid)
//            ->toArray();
        /** @var ConnectionsTable $ConnectionsAssoc */
        $ConnectionsAssoc = $this->getAssociation('Connections')->getTarget();
        $connections = $this->find('connections', ['user' => $user->refid])
            ->contain(['Profiles'])
            ->all();

        if (!is_null($account)) {
//            $userConnections = $this->User
//                ->connections($account->refid)
//                ->toArray();
            $connections = $this->find('connections', ['user' => $account->refid])
                ->contain(['Profiles'])
                ->all();
        }

        if (!$connections->count()) {
            return $query;
        }
//        $connectionsOfConnections = $this->User
//            ->connectionsOfConnections($user->refid)
//            ->toArray();
//        if (!is_null($account)) {
//            $connectionsOfConnections = $this->User
//                ->connectionsOfConnections($account->refid)
//                ->toArray();
//        }
        $from = !is_null($account) ? $account->refid : $user->refid;
        $connectionsOfConnections = $this->find('connectionsOfConnections', [
            'user' => $from
        ])
            ->all()
            ->toArray();

        $possibleAcquaintances = $connectionsOfConnections;

        /*
         * First Approach: Using foreach loop
         * But there is a problem with this approach: Notice that each pair is
         * only compared once in a forward direction. (John and Joe), (Jane and Toby)...;
         * So what if connection does not exist between (John and Joe), but (Joe and Jane)?
         */
//        foreach (array_chunk($connectionsOfConnections, 2) as $pair)
//        {
//            if (sizeof($pair) < 2) return;
//            /* @var $john \App\Model\Entity\Connection */
//            $john = $pair[0];
//            /* @var $joe \App\Model\Entity\Connection */
//            $joe = $pair[1];
//            if ($this->Connections->existsBetween($john->get('person_refid'), $joe->get('person_refid'))) {
//                // Then it is possible that Mike knows some of their connections too.
//                $possibleAcquaintances += $john->connections;
//                $possibleAcquaintances += $joe->connections;
//            }
//            // So what if the two are not actually connected, but they still
//            // have other mutual connections apart from Mike?
//            // Then we should try to find who they have in common apart from Mike
//            else {
//                $connectionsOfJohn = (array) $john->connections;
//                $connectionsOfJoe = (array) $joe->connections;
//            }
//
//        }

        /*
         * Second approach: Using ArrayIterator with do...while loop
         */
//        pr($connections);
//        exit;

        $ArrayIterator = new \ArrayIterator($connections->toArray());
        do {
            $previousConnection = null;
            /**
             * Bug Discovered!
             * @requires Revision This <b>$currentIndex</b> appears to be improperly placed. It ought to be outside the block
             */
            $currentIndex = 0;

            // Skip the user who the suggestion is being made to
            if (
                $ArrayIterator->current() instanceof User &&
                $ArrayIterator->current()->isSameAs($user)
            ) {
                $ArrayIterator->next();
                $currentIndex += 1; // Increasing the counter by one
            }
            $currentConnection = $ArrayIterator->current(); // Say John
//            $currentIndex += 1;

            // When the index increases by 1, it means the iterator just walked
            // pass 1 person, so we save that person as the previous person
            if ($currentIndex >= 2) {
                $previousConnection = $ArrayIterator->offsetGet($currentIndex - 1);
            }

            // Then our operations will be between the previous and the current persons
            if (
                (
                    $previousConnection instanceof User &&
                    !$previousConnection->isSameAs($user)
                )
                && $currentConnection instanceof User
            ) {
                if (
                    $ConnectionsAssoc->existsBetween(
                        $previousConnection, $currentConnection
                    )
                ) {
                    // Then it is possible that Mike knows some of their connections too.
                    $possibleAcquaintances = array_merge(
                        $possibleAcquaintances,
                        $this->find('connections', [
                            'user' => $previousConnection->get('refid')
                        ])->all()->toArray()
                    );
                    $possibleAcquaintances = array_merge(
                        $possibleAcquaintances,
                        $this->find('connections', [
                            'user' => $currentConnection->get('refid')
                        ])->all()->toArray()
                    );
                }
                // The comparison above will look like this:
                // First pair: (John, Joe)
                // Second pair: (Joe, Jane)
                // Third pair: (Jane, Toby)
                // Fourth pair: (Toby, Ella)

                // Then what if the two are not actually connected, but they still
                // have other mutual connections apart from Mike?
                // So we should try to find who they have in common apart from Mike
                else {
//                    $mutualConnections = $this->User->getMutualConnections(
//                        $previousConnection,
//                        $currentConnection, ['apartFrom' => $user]
//                    );
                    $mutualConnections = $this->find('mutualConnections', [
                        'user_a' => $previousConnection,
                        'user_b' => $currentConnection
                    ])
                        ->where(['Users.refid !=' => $user->refid])
                        ->all()
                        ->toArray();
                    $possibleAcquaintances = array_merge(
                        $possibleAcquaintances, $mutualConnections
                    );
//                    $connectionsOfJohn = (array) $this->Connections
//                            ->extractActualConnectionsAsArray($previousConnection->get('refid'));
//
//                    $connectionsOfJoe = (array) $this->Connections
//                            ->extractActualConnectionsAsArray($currentConnection->get('refid'));

                    // Walk through John's connections to see who he has in common with Joe
//                    array_walk($connectionsOfJohn, function (Connection $thisConnectionOfJohn, $index) use ($possibleAcquaintances) {
//                            $connectionsOfJoe = (array) func_get_arg(2);
//                            // Having gone through John's connections, now let's
//                            // also go through Joe's connections
//                            array_walk($connectionsOfJoe, function ( Connection $thisConnectionOfJoe,
//                                    $index
//                                )
//                                use ($possibleAcquaintances) {
//                                    /* @var $givenConnectionOfJohn Connection */
//                                    $givenConnectionOfJohn = func_get_arg(2);
//                                    if ($givenConnectionOfJohn->get('person_refid') === $thisConnectionOfJoe->get('person_refid')) {
//                                        $possibleAcquaintances[] = $givenConnectionOfJohn; // Pushing a single connection entity into the list
//                                    }
//                                }, $thisConnectionOfJohn);
//                            // Where $thisConnectionOfJohn = a picture (virtualy) of each
//                            // person from John's connections, taking one at atime,
//                            // to be matched against Joe's connections
//                        }, $connectionsOfJoe);
                }
            }

            $hasMutualConnections = (bool) $this->find('mutualConnections', [
                'user_a' => $currentConnection,
                'user_b' => $user
            ])->count();

            /**
             * Imagine that out of all the connections of Mike, only one person
             * (Eg: John) has another connection other than Mike (Eg: Anderson).
             * Then let's check if there is anybody in Anderson's list, who is also connected to Mike,
             * if so, then there is a chance that Mike might Know Anderson
             * Thus: Mike and John are connected
             * John is also connected to another person called Anderson.
             * If Anderson has connections(A,B,C,D) and one or more of them is
             * also connected to Mike, then there's a chance that Mike might know Anderson
             */
            if ($hasMutualConnections) {
                $possibleAcquaintances[] = $currentConnection;
                // Now we have Anderson in the list, we could also include his
                // connections
                $connectionsOfAnderson = $this->find('connections', [
                    'user' => $currentConnection->refid
                ])
                    ->all()
                    ->toArray();
                $possibleAcquaintances = array_merge($possibleAcquaintances, $connectionsOfAnderson);
            }

            // Having gotten the current person in the list, we move to the next
            // Increasing the index by 1, to help us find the previous person
            $ArrayIterator->next();
            $currentIndex += 1;
        } while ($ArrayIterator->valid());

        if (count($possibleAcquaintances)) {
            // Now that we have some possible acquaintances, it is time to mine
            // the data returned, filter off duplicate rows and people who Mike
            // may already have been connected to or have blocked
            $possibleAcquaintances = array_unique($possibleAcquaintances);

        }

        $userIDsExtract = \collection($possibleAcquaintances)
            ->extract('Users.refid')->toArray();
        unset($possibleAcquaintances);

        if (!is_null($account) && in_array($account->refid, $userIDsExtract)) {
            unset($userIDsExtract[
                array_search($account->refid, $userIDsExtract)
                ]);
        }
        $userIDsExtract = array_values($userIDsExtract);

        return $query->whereInList('Users.refid', $userIDsExtract)
            ->andWhere(['Users.refid !=' => $user->refid]);
    }

    public function findMutualConnections(Query $query, array $options = [])
    {
        $userA = $options['user_a'];
        $userB = $options['user_b'];
        if ($userA instanceof User) {
            $userA = $userA->refid;
        }
        if ($userB instanceof User) {
            $userB = $userB->refid;
        }

        $connectionsOfUserA = $this->find('connections', ['user' => $userA])
            ->select(['refid'])
            ->distinct();

        return $query->find('connections', ['user' => $userB])
            ->where(['Users.refid IN' => $connectionsOfUserA]);
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
     * @return Query
     */
    public function findConnections( \Cake\ORM\Query $query, array $options): Query
    {
        $user = $options['user'];
        $ConnectionsAssoc = $this->getAssociation('Connections')->getTarget();
        $userConnectionsIDs = $ConnectionsAssoc->find()
            ->select(['correspondent_refid'])
            ->distinct()
            ->where(['Connections.user_refid' => $user]);

        return $query->where(['Users.refid IN' => $userConnectionsIDs])
            ->contain(['Profiles']);
    }

    public function findConnectionsOfConnections(Query $query, array $options = [])
    {
        $user = $options['user'];
//        $connections = $this->find('connections', $options)
//            ->select(['refid'])
//            ->distinct();
        $ConnectionsAssoc = $this->getAssociation('Connections')->getTarget();
        $userConnectionsIDs = $ConnectionsAssoc->find()
            ->select(['correspondent_refid'])
            ->distinct()
            ->where(['Connections.user_refid' => $user]);

        $connectionsOfConnections = $ConnectionsAssoc->find()
            ->select(['correspondent_refid'])
            ->distinct()
            ->where(['Connections.user_refid IN' => $userConnectionsIDs]);

        return $query->where(['Users.refid IN' => $connectionsOfConnections])
            ->contain(['Profiles']);
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
     * @throws RecordNotFoundException
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
        } else {
            if (false === $overwriteContain) {
                $contains = array_merge($defaultContain, $contains);
            }
        }

        $query = $this->find();
        $query = $this->findUser($query, ['user' => $credential])
            ->contain($contains);

        return $query->firstOrFail();
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
    
    public function findUserFeedSources(Query $query, array $options) 
    {
        $user = $options['user'];
        $userID = $user instanceof User ? $user->refid : $user;
        
        $userConnections = $this->find('connections', ['user' => $userID])
                ->clearContain()
                ->select(['Users.refid'])
                ->distinct();
        
        /** @var \App\Model\Table\FollowsTable $FollowedFeedsAssoc **/
        $FollowedFeedsAssoc = $this->getAssociation('Followings')->getTarget();
        $userFollowedFeeds = $FollowedFeedsAssoc->find('followings', [
                    'user' => $userID
                ])
                ->select(['followee_refid'])
                ->distinct();
        
        return $query
                ->select(['Users.refid'])
                ->distinct()
                ->where([
                    'OR' => [
                        ['Users.refid IN' => $userConnections],
                        ['Users.refid IN' => $userFollowedFeeds]
                    ]
                ]);
    }
}
