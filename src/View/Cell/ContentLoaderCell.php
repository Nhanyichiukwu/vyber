<?php
namespace App\View\Cell;

use App\Model\Entity\User;
use Cake\Datasource\EntityInterface;
use Cake\Datasource\ResultSetInterface;
use Cake\ORM\Locator\TableLocator;
use Cake\Utility\Inflector;
use Cake\View\Cell;
use Cake\Datasource\Paginator;
use http\Exception\InvalidArgumentException;

/**
 * ContentLoader cell
 */
class ContentLoaderCell extends Cell
{

    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    public function initialize(): void
    {
        parent::initialize();

//        $this->loadModel('Audios');
//        $this->loadModel('Videos');
//        $this->loadModel('Posts');
    }

    /**
     * @param string $what
     * @param array $args
     */
    public function count(string $what, array $args)
    {
        $result = $this->fetch($what, $args);
        $this->set('count', $result->count());
    }

    public function load(string $what, array $args)
    {
        $this->viewBuilder()->setTemplate($what);
        $result = $this->fetch($what, $args);

        $what = lcfirst(Inflector::camelize($what));
        $$what = $result;
        $this->set(compact("$what"));
    }

    public function fetch(string $what, array $args)
    {
        $method = Inflector::camelize($what);
        try {
            $this->viewBuilder()->setTemplate($what);
        } catch (\Throwable $e) {
            $this->viewBuilder()->setTemplate('fetch');
        }
        return call_user_func_array([$this, $method], $args);
    }

    /**
     * @param string $what
     * @param array|null $args
     */
    public function list(string $what, array $args = null)
    {
        $method = Inflector::camelize($what);
        $result = call_user_func_array([$this, $method], $args);

        $this->set('list', $result->toArray());
    }

    /**
     * @param string|null $type
     * @return \Cake\Datasource\QueryInterface
     */
    public function genres(string $finder = null, array $options = null)
    {
        if (is_null($finder)) {
            $finder = 'all';
        }
        $tbl = (new TableLocator())->get('Genres');
        $genres = $tbl->find($finder, $options);

        return $genres;
    }

    public function categories(string $finder = null, array $options = null)
    {
        if (is_null($finder)) {
            $finder = 'all';
        }

        $tbl = (new TableLocator())->get('Categories');
        $categories = $tbl->find($finder, $options);

        return $categories;
    }

    public function roles(string $finder = null, array $options = null)
    {
        if (is_null($finder)) {
            $finder = 'all';
        }
        $tbl = (new TableLocator())->get('Roles');
        $roles = $tbl->find($finder, $options);

        return $roles;
    }

    /**
     *
     * @param string $filterMethod
     * @param string|object $author
     * @return void
     */
    public function posts(string $finder, $author)
    {
        $this->loadModel('Posts');
        $posts = $this->Posts->find($finder, ['author' => $author]);

//        $this->viewBuilder()->setTemplate('display');
//        $this->set('count', $posts->count());

        return $posts;
    }

    /**
     * @param $actor
     * @return ResultSetInterface
     */
    public function connections($actor): ResultSetInterface
    {
        $Connections = $this->getTableLocator()->get('Connections');
        return $Connections->find('forUser', ['user' => $actor])
            ->all();
    }

    /**
     * @param $actor
     * @return ResultSetInterface
     */
    public function pendingConnections($actor): ResultSetInterface
    {
        $Requests = $this->getTableLocator()->get('Requests');
        return $Requests->find('pending', [
            'type' => 'connection',
            'actor' => $actor
        ])
        ->all();
    }

    /**
     * @param $actor
     * @param $type
     * @return ResultSetInterface
     */
    public function sentRequests($actor, $type): ResultSetInterface
    {
        $Requests = $this->getTableLocator()->get('Requests');
        return $Requests
            ->find('sent', ['user' => $actor, 'type' => $type])
            ->all();
    }


    /**
     * @param $actor
     * @return void
     */
    public function introductions($actor)
    {
        $this->loadModel('Requests');
        $introductions = $this->Requests->find('byType', ['type' => 'introductions']);
        $introductions = $this->Requests->findByRecipient($introductions, ['recipient' => $actor]);

        $this->viewBuilder()->setTemplate('display');
        $this->set('count', $introductions->count());
    }

    /**
     * @param $actor
     * @return void
     */
    public function recommendations($actor)
    {
        $this->loadModel('Requests');
        $recommendations = $this->Requests->find('byType', ['type' => 'recommendations']);
        $recommendations = $this->Requests->findByRecipient($recommendations, ['recipient' => $actor]);

        $this->viewBuilder()->setTemplate('display');
        $this->set('count', $recommendations->count());
    }

    /**
     * @param $actor
     * @return void
     */
    public function meetingRequests($actor)
    {
        $this->loadModel('Requests');
        $meetings = $this->Requests->find('byType', ['type' => 'meetings']);
        $meetings = $this->Requests->findByRecipient($meetings, ['recipient' => $actor]);

        $this->viewBuilder()->setTemplate('display');
        $this->set('count', $meetings->count());
    }

    public function dueEvents($actor, $timeframe = '')
    {
        $this->loadModel('Events');
        $dueEvents = $this->Events->find('due', ['actor' => $actor->refid, 'timeframe' => $timeframe]);
        return $dueEvents;
    }

    public function notifications($actor)
    {
        $notifications = new NotificationsCell();
//        $notifications->
    }

    /**
     * Runs a query to retrieves user unread connection requests
     *
     * @param \App\Model\Entity\User $user
     * @return \Cake\ORM\Query
     */
    public function unreadMessages($user)
    {
        $this->loadModel('Messages');
        $unreadMessages = $this->Messages->find('unread', [
            'recipient' => $user->refid
        ]);

        return $unreadMessages;
    }

    /**
     * Runs a query to retrieves user unread connection requests
     *
     * @param \App\Model\Entity\User $user
     * @return \Cake\ORM\Query
     */
    public function unreadConnectionRequests($user)
    {
//        $NotificationsTbl = $this->loadModel('Notifications');
        $connectionRequests = $this->_unreadNotifications($user)
            ->where(['type' => 'connection_request']);

        return $connectionRequests;
    }

    public function unreadMeetingRequests($user)
    {
        $meetingRequests = $this->_unreadNotifications($user)
            ->where(['type' => 'meeting_request']);

        return $meetingRequests;
    }

    /**
     * @param $user
     * @return \Cake\Datasource\QueryInterface
     */
    public function introductionRequests($user)
    {
        $introductionRequests = $this->_unreadNotifications($user)
            ->where(['type' => 'introduction_request']);

        return $introductionRequests;
    }

    /**
     * Runs a query to retrieve all user unread notifications
     *
     * @param \App\Model\Entity\User $user
     * @return \Cake\Datasource\QueryInterface
     */
    public function unreadNotifications($user)
    {
        $this->loadModel('Notifications');
        $unreadNotifications = $this->Notifications->find('unread', ['for' => $user->refid]);

        return $unreadNotifications;
    }

    public function events($user)
    {
        $eventsTbl = $this->loadModel('Events');
    }

    public function songs(string $finder = null, $matcher = null)
    {
        $this->loadModel('Audios');
        if ($finder && $finder !== 'all') {
            $find = 'findBy' . ucfirst($finder);
        } else {
            $find = 'findAll';
        }

        $songs = $this->Audios->find('music');
        $songs = $this->Audios->{$find}($songs, [$finder => $matcher])
            ->orderDesc('created');

        $paginator = new Paginator();
        $songs = $paginator->paginate($songs);

        return $songs;
    }

    public function videos(string $finder = null, $matcher = null)
    {
        $this->loadModel('Videos');
        if ($finder && $finder !== 'all') {
            $find = 'findBy' . ucfirst($finder);
        } else {
            $find = 'findAll';
        }

        $videos = $this->Videos->find('music');
        $videos = $this->Videos->{$find}($videos, [$finder => $matcher])
            ->orderDesc('created');

        $paginator = new Paginator();
        $videos = $paginator->paginate($videos);

        return $videos;
    }

    public function music($actor)
    {
        $this->loadModel('Audios');
        $this->loadModel('Videos');

        $songs = $this->Audios->find('music')
            ->select(['refid'])
            ->where(['author_refid' => $actor->get('refid')]);
        $videos = $this->Videos->find('music')
            ->select(['refid'])
            ->where(['author_refid' => $actor->get('refid')]);
        $music = $songs->unionAll($videos)->map(function($row) {
            $item = null;
            if ($this->Audios->exists(['refid' => $row->get('refid')])) {
                $item = $this->Audios->get($row->get('refid'));
            } elseif ($this->Videos->exists(['refid' => $row->get('refid')])) {
                $item = $this->Videos->get($row->get('refid'));
            }
            return $item;
        });

        return $music;
    }

    public function lyrics($actor = null)
    {

    }

    public function albums($actor = null)
    {

    }

    public function playlists($actor, $type)
    {

    }

    public function newReleases($actor = null)
    {

    }

    public function voiceNotes($actor)
    {

    }

    public function recentPlays($actor)
    {

    }

    public function users(string $finder = null, array $options = null)
    {
        if (is_null($finder)) {
            $finder = 'all';
        }
        $UsersTbl = $this->loadModel('Users');
        if (!$UsersTbl->hasFinder($finder)) {
            throw new \Exception("Unknown find: `$finder`");
        }
        if (is_null($options)) {
            $options = [];
        }
        $users = $UsersTbl->find($finder, $options);

        return $users;
    }
}
