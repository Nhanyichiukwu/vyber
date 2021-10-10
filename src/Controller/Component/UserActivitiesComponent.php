<?php
declare(strict_types=1);

namespace App\Controller\Component;

use App\Model\Entity\Connection;
use App\Model\Entity\User;
use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Collection\Collection;
use Cake\ORM\ResultSet;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;
use Cake\Utility\Text;
use Cake\Database\Expression\QueryExpression;
use Cake\ORM\Query;
use Cake\Database\Query as DBQuery;
use Cake\Validation\Validation;


/**
 * UserActivities component
 *
 * @property \App\Controller\Component\UserComponent $UserProfiler
 * @property \Cake\Controller\Component\PaginatorComponent $Paginator
 * @property \App\Model\Table\UsersTable $Users
 * @property \App\Model\Table\ConnectionsTable $Connections
 * @property \App\Model\Table\PostsTable $Posts
 * @property \App\Model\Table\Activities $Activities
 * @property \Cake\Controller\Component\FlashComponent $Flash
 */
class UserActivitiesComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public $components = ['CustomString', 'Paginator', 'Cookie', 'UserProfiler','Flash', 'Newsfeed'];


    /**
     *
     * @var object ORM TableLocator object
     */
    private $_tableLocator;

    public $user;

    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->_tableLocator = TableRegistry::getTableLocator();
        $this->Users = $this->_tableLocator->get('Users');
        $this->Posts = $this->_tableLocator->get('Posts');
        $this->Connections = $this->_tableLocator->get('Connections');
        $this->NewsFeeds = $this->_tableLocator->get('Newsfeeds');
        $this->Activities = $this->_tableLocator->get('Activities');
    }

    /**
     *
     * @param \Cake\ORM\Query $query
     * @return \Cake\ORM\Query $query
     */
    public function applyFormatting(\Cake\ORM\Query $query)
    {
//        $query = $query
//                ->map(function($posts) {
//                    $posts = array_map($this->addPostProperties, $posts);
//                    return $posts;
//                });

        return $query;
    }

    public function extractConnectionsIDs(array $connections) {
        $connectionsIDs = [];
        (new Collection($connections))->each(function($item) use (&$connectionsIDs) {
            $connectionsIDs[] = $item->get('correspondent_refid');
        });

        return $connectionsIDs;
    }

    public function extractFollowsIDs($follows, $field) {
        $followsIDs = [];
        (new Collection($follows))->each(function($item) use (&$followsIDs, $field) {
            $followsIDs[] = $item->get($field);
        });
    }



    public function getFollowings($refid = null)
    {
        if (is_null($refid)) {
            if ($this->getController()->getActiveUser())
                $refid = $this->getController()->getActiveUser()->get('refid');
        }

        $followsTbl = $this->_tableLocator->get('Follows');
        $followings = $followsTbl->find()
                ->select(['followee_refid'])
                ->where(['follower_refid =' => $refid]);

        return $followings;
    }



    public function getSuggestion($what, $actor, $filter = false)
    {
        $inflector = new Inflector();
        $action = lcfirst($inflector->camelize($what));

        return $this->{$action}($actor, $filter);
    }

    public function getEngagements($param)
    {

    }

    /**
     * Retrieves all events either created by the user, or to which the user
     * is invited, which are 10 days or less closer to the start date
     *
     * @param User $actor
     */
    public function getDueEvents(User $actor)
    {
//        $Guests = $this->_tableLocator->get('EventInvitees');
//        $query = $Guests->find('all');
//        $_7daysInFuture = new \DateTime('7 days');
//        $now = new \DateTime('NOW');
//        print_r($now);
//        exit;
//        $query = $query->contain('Events', function (Query $q) {
//                    return $q->where([
//                        'start_date <=' => new \DateTime('7 days')
//                    ]);
//                })
//                ->where(['invitee_refid' => $actor->refid]);
//                print_r($query);
//                exit;
    }

    public function getInteractions($param)
    {

    }



    /**
     *
     * @param string $actor
     * @param array $object
     */
    public function getUserInterests(User $actor, $limit = 3, array $object = null)
    {
        $Interests = $this->_tableLocator->get('UserInterests');
        $items = $Interests->find()
                ->where([
                    'user_refid' => $actor->get('refid')
                ]);
        if (! is_null($object)) {
            $items = $items->where([
                'object_name' => $object['name'],
                'object_refid' => $object['refid']
            ]);
        }
        $items = $items->orderDesc('id')->limit($limit);
        $items = $items->all()->toArray();

        if (! $object) {
            $items = (new Collection($items))
                ->map(function ($item) {
                    $obj = Inflector::pluralize(ucfirst($item->object_name));
                    $objId = $item->object_refid;
                    $object = $this->_tableLocator->get($obj)
                            ->find()
                            ->where(['refid' => $objId])
                            ->limit(1)
                            ->first();
                    $item->object = $object;

                    return $item;
                });
        }

        if (! is_array($items)) {
            $items = $items->toArray();
        }

        return $items;
    }

    public function getAttachmentsByRefkey($attachments, $refkey)
    {
        $attachments = Inflector::camelize($attachments);
        $results = [];
//        if ($this->_tableLocator->exists($attachments)) {
            $attachmentsTable = $this->_tableLocator->get($attachments);
            $query = $attachmentsTable->find()->where(['refkey' => $refkey]);
            $results = $query->all()->toArray();
//        }

        return $results;
    }

    public function getMedias($actor, $filter = 'all')
    {
        $medias = $this->_tableLocator->get('Medias');
        $medias = $medias->find($filter)
                ->where(['user_refid' => $actor]);
        if ($filter === 'all') {
            $medias = $medias->contain(['Users','Videos','Audios']);
        }

        return $medias;
    }

    public function getUserLikes($refid)
    {
    }

    /**
     * Fetch a list of activities by a given user and those they're following
     *
     * @param string $userRefid
     * @return Query
     */
    public function getActivities($userRefid)
    {
        $activityFeeds = $this->Newsfeed->getNewsSources($userRefid);
        $activities = $this->Activities->find()
                ->whereInList('actor_refid', $activityFeeds);

        return $activities;
    }

}
