<?php
namespace App\Controller\Component;

use App\Model\Entity\User;
use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Collection\Collection;
use Cake\Utility\Inflector;
use Cake\Utility\Text;
use Cake\Validation\Validation;


/**
 * Suggestion component
 *
 * @property \App\Controller\Component\UserComponent $UserProfiler
 * @property \Cake\Controller\Component\CookieComponent $Cookie
 * @property \Cake\Controller\Component\PaginatorComponent $Paginator
 * @property \App\Model\Table\UsersTable $Users
 * @property \App\Model\Table\ConnectionsTable $Connections
 * @property \App\Model\Table\EPostsTable $Posts
 * @property \App\Model\Table\Activities $Activities
 * @property \Cake\Controller\Component\FlashComponent $Flash
 * @property \App\Controller\Component\UserComponent $User
 */
class SuggestionComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public $components = ['CustomString', 'Paginator', 'Cookie', 'UserActivities','Flash', 'Newsfeed','User'];

    public function initialize(array $config): void
    {
        parent::initialize($config);

        $TableLocator = new \Cake\ORM\Locator\TableLocator();
        $this->Users = $TableLocator->get('Users');
        $this->Connections = $TableLocator->get('Connections');
//        $this->NewsFeeds = $TableLocator->get('NewsFeeds');
//        $this->Activities = $TableLocator->get('Activities');
    }

    public function handle(array $path = [], array $params = [])
    {
        if (count($path) > 1) {
            $subHandler = Inflector::camelize($path[0]);
            if (method_exists($this, $subHandler)) {
                array_shift($path);
                return $this->$subHandler($path, $params);
            }
        }

        $what = $params['what'] ?? 'people';
        unset($params['what']);
        $suggestWhat = 'suggest' . Inflector::camelize($what);

        return $this->{$suggestWhat}($params);
    }

    /**
     * @param $options
     * @return array|void|null
     */
    public function suggestPeople(array $options)
    {
        $user = $this->getController()->getActiveUser();

        if (!$user) {
            return null;
        }

        $type = $options['type'] ?? 'any';
        $query = $this->Users->find()
            // Make sure the user is not in the list
            ->where([
                'Users.refid !=' => $user->refid
            ])
            ->contain([
                'Profiles' => [
                    'UserRoles' => ['Roles']
                ],
                'SentRequests',
                'ReceivedRequests'
            ]);

        array_shift($options);

        switch ($type) {
            case 'people_you_may_know':
                $users = $this->suggestPossibleAcquaintances($user);
                break;
            case 'who_to_follow':
                $users = $this->suggestPersonsOfInterest();
                break;
            case 'connections':
                $users = $this->suggestPossibleConnections();
                break;
            default:
                $users = [
                    'topRated' => $this->Users->findTopRated($query)->toArray(),
                    'popular' => $this->Users->findPopular($query)->toArray(),
                    'peopleInSameCountry' => $this->Users->findPeopleInSameCountryAs(
                        $query,
                        [
                            'user' => $user
                        ]
                    )
                        ->toArray()
                ];
        }

        return $users;
    }

    /**
     * Fetch a list of people who the user might know.
     *
     * The idea is to find people who the current user might know
     * Given a list of persons who the user is already connected to,
     * we try to compare between their own connections to see if we can
     * find anyone the user might know
     * Example: Using user Mike and friends
     * Mike: friends[John, Joe, Jane, Toby, Ella];
     * John: friends[Peter, James, Joahn, Joe, Mike]
     * Joe: friends[Toby, Ella, Mike, John]
     * Given that John and Joe, Joe and Toby, Joe and Ella, all have
     * people in common, then there is a great chance
     * that Mike might know some of John's and Joe's
     * connections, and so on...
     * Now for each two connections of Mike's, we check if they too, are
     * connected to each other, if true, we import their connections
     * as people that Mike might know... Just keeping it shallow...
     *
     * @param User $user The user to make suggestions for
     * @return array A list of matched users
     */
    public function suggestPossibleAcquaintances(User $user): array
    {
        $userConnections = $this->User->connections(
            $user->get('refid')
        )
            ->toArray();

        if (!count($userConnections)) {
            return [];
        }
        $connectionsOfConnections = $this->User->connectionsOfConnections(
            $user->get('refid')
        )
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

        $ArrayIterator = new \ArrayIterator($userConnections);
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
                        $this->Connections->existsBetween(
                                $previousConnection, $currentConnection
                        )
                ) {
                    // Then it is possible that Mike knows some of their connections too.
                    $possibleAcquaintances = array_merge(
                        $possibleAcquaintances,
                        $this->User->connections(
                            $previousConnection->get('refid')
                        )
                    );
                    $possibleAcquaintances = array_merge(
                        $possibleAcquaintances,
                        $this->User->connections(
                            $currentConnection->get('refid')
                        )
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
                else
                {
                    $mutualConnections = $this->User->getMutualConnections(
                        $previousConnection,
                        $currentConnection, ['apartFrom' => $user]
                    );
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
            if ($this->User->hasMutualConnectionsWith($currentConnection, $user)) {
                $possibleAcquaintances[] = $currentConnection;
                // Now we have Anderson in the list, we could also include his
                // connections
                $connectionsOfAnderson = $this->User->connections($currentConnection->refid)->toArray();
                $possibleAcquaintances = array_merge($possibleAcquaintances, $connectionsOfAnderson);
            }

            // Having gotten the current person in the list, we move to the next
            // Increasing the index by 1, to help us find the previous person
            $ArrayIterator->next();
            $currentIndex += 1;
        } while ($ArrayIterator->valid());

        if (count($possibleAcquaintances))
        {
            // Now that we have some possible acquaintances, it is time to mine
            // the data returned, filter off duplicate rows and people who Mike
            // may already have been connected to or have blocked
            $possibleAcquaintances = array_unique($possibleAcquaintances);

        }

        return $possibleAcquaintances;
    }

    /**
     *
     * @param string $filter
     * @return array
     */
    public function suggestPossibleConnections($filter = null)
    {
        if ($filter === null) {
            $filter = 'all';
        }

        $request = $this->getController()->getRequest();
        $user = (
            $request->getQuery('user')
            ? $this->Users->getUser(
                    $this->CustomString->sanitize($request->getQuery('user')
                )
            )
            : null
        );
        $dataTarget = $request->getQuery('_dt');
        $basedOn = [];
        if ($dataTarget === 'i_base') {
            $basedOn = ['connections','personality'];
        } elseif($dataTarget === 'i_lookup') {
            $basedOn = ['similar_users','profile_connections'];
        } elseif ($dataTarget === 'recent_connection') {
            $basedOn = ['similar_users'];
        }

        $activeUser = $this->getController()->getActiveUser();

/* { Re-implementation required! */
        $suggestions = [];
        if (in_array('connections', $basedOn) && $activeUser)
        {
            $connectionsOfConnections = (array) $this->Connections
                ->getConnectionsOfConnections($activeUser->refid);
            (new Collection($connectionsOfConnections))->each(
                function ($user) use (&$suggestions, $activeUser) {
                    if ( !$user->isSameAs($activeUser) &&
                        !$this->Connections->existsBetween($activeUser, $user)
                    ) {
                        $suggestions[] = $user;
                    }
                }
            );
            $suggestions = array_unique($suggestions);
        }
/* } */
        // Offers suggestions to a user based on his/her personality
        // For example: if the user is a song writer, suggested users could
        // include producers, recording artists, etc.
        // This is a very complex suggestion algorythme
        if(in_array('personality', $basedOn)) {

        }

        // Offers suggestions based on people who share some level of similarity
        // with a given user
        if (in_array('similar_users', $basedOn) && $user) {
            $result = $this->Users->find('usersSimilarTo', ['user' => $user]);
            $similarUsers = $result->getIterator()->shuffle()->take(5, 0);
            if (! $similarUsers->isEmpty()) {
                $suggestions = array_merge($suggestions, $similarUsers->toArray());
            }
        }

        // Offer suggestions from a given user's connections list
        if (in_array('profile_connections', $basedOn) && $user) {
            $userConnections = $this->Connections->find('forUser', ['user' => $user->refid])
                    ->orderDesc('Connections.created')
                    ->getIterator()->shuffle()->take(5, 0);

            $userConnections->each(function($row) use (&$suggestions, $user) {
                if ($row->correspondent->isSameAs($user))
                    $suggestions[] = $row->actor;
                elseif ($row->actor->isSameAs($user))
                    $suggestions[] = $row->correspondent;
            });
        }
//        $query = null;
//        switch ($filter)
//        {
//            case 'all':
//                $query = $users;
//                break;
//            case 'same_niche':
//                $query = $users->where(['Profiles.niche' => $user->niche]);
//                break;
//            case 'country_people':
//                $query = $users->where(['Profiles.country_of_origin' => $user->country_of_origin]);
//                break;
//            case 'country_people_same_niche':
//                $query = $users->where([
//                    'Profiles.country_of_origin' => $user->country_of_origin,
//                    'niche' => $user->niche
//                    ]);
//                break;
//            case 'same_residence':
//                $query = $users->where(['Profiles.country_of_residence' => $user->country_of_residence]);
//                break;
//            case 'same_location_same_niche':
//                $query = $users->where([
//                    'Profiles.location' => $user->location,
//                    'Profiles.niche' => $user->niche
//                    ]);
//                break;
//            default:
//                $query = $users;
//        }

        return $suggestions;
    }

    public function suggestPersonsOfInterest()
    {

    }

    public function getPostStartingPhrase($type = null)
    {
        $phrases = [
            'shoutout' => [
                'My shout-out goes to',
                "I'd like to make a shout out to",
                "A big shout out to all my fans",
                "Hi guys, I can't thank y'all enough for your love and support!"
            ],
            'moment' => [
                "It's been a great moment with",
                "Having a great time with ma hommies at"
            ],
            'story' => [],
            'location' => []
        ];
        if ($type) {
            return $phrases[$type];
        }
        return $phrases;
    }
}
