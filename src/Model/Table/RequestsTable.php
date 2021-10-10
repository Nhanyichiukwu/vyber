<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\User;
use App\Model\Entity\Request;
use App\Utility\RandomString;
use Cake\Core\Configure;
use Cake\Database\Connection;
use Cake\Database\Exception;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\Log\Log;
use Cake\ORM\Locator\TableLocator;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use App\Model\Table\AppTable;
use Cake\Event\EventListenerInterface;
use Cake\Event\EventManagerInterface;
use Cake\Validation\Validator;
use \UnexpectedValueException;

/**
 * Requests Model
 *
 * @method \App\Model\Entity\Request get($primaryKey, $options = [])
 * @method \App\Model\Entity\Request newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Request[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Request|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Request|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Request patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Request[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Request findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RequestsTable extends AppTable
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

        $this->setTable('requests');
        $this->setDisplayField('refid');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Senders', [
            'foreignKey' => 'sender_refid',
            'joinType' => 'INNER',
            'className' => 'Users'
        ]);
        $this->belongsTo('Recipients', [
            'foreignKey' => 'recipient_refid',
            'joinType' => 'INNER',
            'className' => 'Users'
        ]);
        $this->hasOne('SuggestedUsers', [
            'foreignKey' => 'refid',
            'targetForeignKey' => 'suggested_user_refid',
            'joinType' => 'LEFT',
            'className' => 'Users'
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
            ->allowEmptyString('id');

        $validator
            ->scalar('refid')
            ->maxLength('refid', 20)
            ->allowEmptyString('refid', 'create');

        $validator
            ->scalar('sender_refid')
            ->maxLength('sender_refid', 20)
            ->requirePresence('sender_refid', 'create')
            ->allowEmptyString('sender_refid', null);

        $validator
            ->scalar('recipient_refid')
            ->maxLength('recipient_refid', 20)
            ->requirePresence('recipient_refid', 'create')
            ->allowEmptyString('recipient_refid', null);

        $validator
            ->scalar('suggested_user_refid')
            ->maxLength('suggested_user_refid', 20)
            ->allowEmptyString('suggested_user_refid');

        $validator
            ->dateTime('proposed_meeting_date')
            ->allowEmptyDateTime('proposed_meeting_date');

        $validator
            ->time('proposed_meeting_time')
            ->allowEmptyTime('proposed_meeting_time');

        $validator
            ->scalar('short_message')
            ->maxLength('short_message', 160)
            ->allowEmptyString('short_message');

        $validator
            ->boolean('is_read')
            ->allowEmptyString('is_read');

        $validator
            ->scalar('type')
            ->requirePresence('type', 'create')
            ->allowEmptyString('type', null);

        return $validator;
    }

    public function isAlreadySent($user, $target_account, $request_type)
    {
        return $this->exists([
            'OR' => [
                [
                    'sender_refid' => $user,
                    'recipient_refid' => $target_account
                ],
                [
                    'sender_refid' => $target_account,
                    'recipient_refid' => $user
                ]
            ],
            'type' => $request_type
        ]);
    }

    public function findUnread(Query $query, array $options = [])
    {
        if (isset($options['user'])) {
            $query = $query->where([
                'Requests.recipient_refid' => $options['user']
            ]);
        }
        return $query->where([
            'Requests.is_read' => '0'
        ]);
    }

    /**
     * @param Query $query
     * @param array $options
     * @return Query
     */
    public function findReceived(Query $query, array $options)
    {
        if (isset($options['type'])) {
            $query = $query->where([
                'Requests.type' => $options['type']
            ]);
        }
        if (isset($options['status'])) {
            $query = $query->where(['Requests.is_read' => $options['status']]);
        }
        return $query->where([
            'Requests.recipient_refid' => $options['user']
        ]);
    }

    /**
     * @param Query $query
     * @param array $options
     * @return Query
     */
    public function findAny(Query $query, array $options)
    {
        return $query->where([
            'Requests.recipient_refid' => $options['user']
        ]);
    }

    public function findSent(Query $query, array $options)
    {
        $query = $query->where([
            'Requests.sender_refid' => $options['user']
        ]);
        if (isset($options['type'])) {
            $query = $query->where(['Requests.type' => $options['type']]);
        }

        return $query;
    }

    /**
     * Fetch a list of pending requests
     *
     * @param Query $query
     * @param array $options
     * @return Query
     * @throws \InvalidArgumentException
     */
    public function findPending(Query $query, array $options)
    {
        if (!isset($options['actor'])) {
            $msg = 'No actor provided';
            throw new \InvalidArgumentException($msg);
        }
        $actor = $options['actor'];
        $type = null;
        $box = 'received';
        if (isset($options['box'])) {
            $box = $options['box'];
        }
        if (isset($options['type'])) {
            $type = $options['type'];
        }
        switch ($box) {
            case 'sent':
                $query->where(['Requests.sender_refid =' => $actor]);
                break;
            case 'received':
                $query->where(['Requests.recipient_refid =' => $actor]);
                break;
            default:
                $query->where([
                    'OR' => [
                        'Requests.sender_refid =' => $actor,
                        'Requests.recipient_refid =' => $actor
                    ]
                ]);
        }

        if ($type !== null) {
            $query->where(['Requests.type' => $type]);
        }

        $query->orderDesc('Requests.created');

        return $query;
    }

    public function findByType(Query $query, array $options)
    {
        return $query->where(['Requests.type' => $options['type']]);
    }

    public function findByRecipient(Query $query, array $options)
    {
        return $query->where(['Requests.recipient_refid' => $options['recipient']]);
    }

    public function afterConfirmation(Event $event)
    {
        (new Log())->write('Request Confirmed Successfully');
    }

    /**
     * Cancel a given request (only requests sent by the user)
     *
     * @param string $sender
     * @param string $recipient
     * @param string $type
     * @return bool
     */
    public function cancel(string $sender, string $recipient, string $type)
    {
        try {
            $request = $this->find()
                ->where([
                    'sender_refid' => $sender,
                    'recipient_refid' => $recipient,
                    'type' => $type
                ])
                ->firstOrFail();
            $this->delete($request);
        } catch ( Exception $exception) {
            if (Configure::read('debug') === true) {
                throw new Exception('Oops! Unable to cancel ' .
                    'request. Something went wrong');
            }

            return false;
        }

        return true;
    }

    /**
     * Checks if the given request was sent by the actor provided in the first parameter
     *
     * @param string $sender
     * @param string $recipient
     * @param string $type
     * @return bool
     */
    public function wasSentBy(string $sender, string $recipient, string $type)
    {
        return  $this->exists([
            'sender_refid' => $sender,
            'recipient_refid' => $recipient,
            'type' => $type
        ]);
    }

    /**
     * @param User $sender
     * @param User $recipient
     * @param string $type
     * @param array $options
     * @return bool
     */
    public function send(User $sender, User $recipient, $type, $options = [])
    {
        $data = [
            'refid' => RandomString::generateString(20),
            'sender_refid' => $sender->refid,
            'recipient_refid' => $recipient->refid,
            'type' => $type
        ];

        $messages = [
            'connection' => sprintf('<strong>%s</strong> has invited you to join %s network.', $sender->getFullname()
                , $sender->getGenderAdjective()),
            'meeting' => sprintf('<strong>%s</strong> asked to meet with you', $sender->getFullname())
        ];
        if (isset($options['suggested_user'])) {
            $suggestedUser = $options['suggested_user'];
            if (! $suggestedUser instanceof User) {
                throw new UnexpectedValueException('Suggested User ' .
                    'must be an instance of User Object');
            }
            $messages['introduction'] = sprintf('%actor_name% wants ' .
                'you to meet %introduced_user%, %introduced_user_description%',
                $sender->getFullname(), $suggestedUser->getFullname(), $suggestedUser->getDescription());
        }

        // If the request type is meeting, this option is required.
        if (isset($options['meeting_date'])) {
            $data['proposed_meeting_date'] = $options['meeting_date'];
        }
        if (isset($options['meeting_time'])) {
            $data['proposed_meeting_time'] = $options['meeting_time'];
        }
        if (isset($options['message'])) {
            $data['short_message'] = $options['message'];
        } else {
            $data['short_message'] = $messages[$type];
        }

        $request = $this->newEntity($data);

        if ($this->save($request)) {
            return true;
        }

        return false;
    }

    public function getOutstandingRequests($actor)
    {
        $sentRequests = $this->getSentRequests($actor);
        $receivedRequests = $this->getReceivedRequests($actor);

        $outstanding = [];
        if ($sentRequests->count() > 0) {
            $outstanding += $sentRequests->all()->toArray();
        }
        if ($receivedRequests->count() > 0) {
            $outstanding += $receivedRequests->all()->toArray();
        }

        return $outstanding;
    }

    public function getSentRequests($actor)
    {
        $requests = $this->find()->where([
            'sender_refid' => $actor
        ]);

        return $requests;
    }

    public function getReceivedRequests($actor)
    {
        $requests = $this->find()->where([
            'recipient_refid' => $actor
        ]);

        return $requests;
    }

    /**
     * @param $recipient
     * @param $sender
     * @param $type
     * @return bool|\Cake\Database\Connection
     */
    public function accept($recipient, $sender, $type): ?Connection
    {
        try {
            $request = $this->find()
                ->where([
                    'sender_refid' => $sender->refid,
                    'recipient_refid' => $recipient->refid,
                    'type' => $type
                ])
                ->firstOrFail();
            $this->getConnection()->begin();
            $this->deleteOrFail($request, ['atomic' => false]);
        } catch (\Throwable $e) {
            $error = 'Connection request acceptance failed. '
                . 'The record could not be deleted from the requests table.';
            if (Configure::read('debug') === true) {
                throw new \RuntimeException($error);
            }

            Log::error($error);
            return false;
        }

        // If everything goes well
//        $_acceptRequest = '_accept' . ucfirst($type);
//        if (! $this->{$_acceptRequest}($recipient, $sender)) {
//            $this->getConnection()->rollback();
//            return false;
//        }
        // Call an onSave event dispatcher here to propagate the event


        return $this->getConnection();
    }

    /**
     * Check whether the user given in second parameter has a pending
     * connection invitation from the actor.
     *
     * @param User $actor
     * @param User $account
     * @return bool
     */
    public function hasPendingInvitation(?User $actor, ?User $account)
    {
        return $this->wasSentBy($actor->refid, $account->refid, 'connection');
    }

    protected function _acceptConnection(string $recipient, string $sender)
    {
        $Connections = (new TableLocator)->get('Connections');
        if (! $Connections->connect($recipient, $sender)) {
            return false;
        }
        return true;
    }

    protected function _acceptIntroduction($recipient, $sender)
    {

    }

    protected function _acceptMeeting($recipient, $sender)
    {

    }
}
