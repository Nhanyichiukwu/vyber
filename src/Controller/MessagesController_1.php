<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Controller\Component\WebSocketChatHandlerComponent;
use App\Utility\RandomString;
use Cake\Utility\Text;
use Cake\Utility\Inflector;

/**
 * Messages Controller
 *
 * @property \App\Model\Table\AppTable $App
 * @property \App\Model\Table\ChatsTable $Chats
 * @property \App\Model\Table\MessagesTable $Messages
 * @property \App\Model\Table\ChatParticipantsTable $ChatParticipants
 * @property \App\Model\Table\OutboxMessagesTable $OutboxMessages
 * @property \App\Model\Table\InboxMessagesTable $InboxMessagesd
 * 
 * @property \App\Controller\Component\WebSocketChatHandlerComponent $WebSocketChatHandler
 *
 * @method \App\Model\Entity\Message[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MessagesController extends AppController
{

    public function initialize() {
        parent::initialize();
        
        $this->loadComponent('Messenger', [
            'user' => $this->getActiveUser()
        ]);
        $this->loadComponent('Cookie');
        $this->loadComponent('WebSocketChatHandler');
        
        $this->loadModel('App');
    }
    
    public function beforeRender(\Cake\Event\Event $event) {
        parent::beforeRender($event);
        
        $this->viewBuilder()->setLayout('messenger');
    }


    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'Chats']
        ];
        $chats = (array) $this->_getUserChats();

        $this->set(compact('chats'));
    }

    /**
     * View method
     *
     * @param string|null $id Message id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $message = $this->Messages->get($id, [
            'contain' => ['Users', 'Chats']
        ]);

        $this->set('message', $message);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $message = $this->Messages->newEntity();
        if ($this->request->is('post')) {
            $message = $this->Messages->patchEntity($message, $this->request->getData());
            if ($this->Messages->save($message)) {
                $this->Flash->success(__('The message has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The message could not be saved. Please, try again.'));
        }
        $users = $this->Messages->Users->find('list', ['limit' => 200]);
        $chats = $this->Messages->Chats->find('list', ['limit' => 200]);
        $this->set(compact('message', 'users', 'chats'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Message id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $message = $this->Messages->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $message = $this->Messages->patchEntity($message, $this->request->getData());
            if ($this->Messages->save($message)) {
                $this->Flash->success(__('The message has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The message could not be saved. Please, try again.'));
        }
        $users = $this->Messages->Users->find('list', ['limit' => 200]);
        $chats = $this->Messages->Chats->find('list', ['limit' => 200]);
        $this->set(compact('message', 'users', 'chats'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Message id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $message = $this->Messages->get($id);
        if ($this->Messages->delete($message)) {
            $this->Flash->success(__('The message has been deleted.'));
        } else {
            $this->Flash->error(__('The message could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    /**
     * Chats retrieval method
     * 
     * - Get all available chats (private/group) in which the user is a participant
     * 
     * @param string $user_refid
     * @return array This will return either a list of chat entity objects or
     * an empty array
     */
    protected function _getUserChats()
    {
        $chats = [];
        $this->loadModel('ChatParticipants');
        $query = $this->ChatParticipants->find('chatsByUser', ['user' => $this->getActiveUser()->refid]);
        $results = $query->select('chat_refid')->toArray();
        
        if ($query->count() > 0) {
            foreach ($results as $result) {
                $chats[] = $this->_getChat($result->chat_refid);
            }
        }
        
        return $chats;
    }

    
    /**
     * Chat entity retrieval method
     * 
     * - Gets a single chat entity using its id
     * @access protected
     * @param string $chat_refid
     * @return \App\Model\Entity\Chat $chat | null
     */
    protected function _getChat( $chat_refid )
    {
        $this->loadModel('Chats');
        $chat = $this->Chats->get($chat_refid);
        $chat->messages = (array) $this->_getChatMessages($chat->refid);
        $chat->participants = (array) $this->_getChatParticipants($chat->refid);
        
        
        return $chat;
    }
    
    /**
     * Message Retrieval method
     * 
     * Retrieves messages belonging to a given chat identified by refid.
     * This method returns only unread messages by default, but can be
     * manipulated to filter messages based on different filter options
     * This method is particularly handy for informing the user of new unread
     * messages
     *  
     * @param string $chat_refid
     * @param string $filter
     * @return array A list of recently received and unread messages by default | empty array if noting was found
     */
    protected function _getChatMessages( $chat_refid = null, $filter = null )
    {
        $this->loadModel('Messages');
//        $this->loadModel('OutboxMessages');
//        $this->loadModel('InboxMessages');
        $pagination_limit = $this->Cookie->check('UserPreferences.paged_result_limit')?
                $this->Cookie->read('UserPreferences.paged_result_limit') : 10;
        
//        $outbox = $this->OutboxMessages
//                        ->find('all')
//                        ->where([
//                            'chat_refid' => $chat_refid,
//                            'is_trashed' => '0'
//                        ])
//                        ->orderDesc('message_time')
//                        ->all()
//                        ->toArray();
//        
//        $inbox = $this->InboxMessages
//                        ->find('all')
//                        ->where([
//                            'chat_refid' => $chat_refid,
//                            'recipient_refid' => $this->getActiveUser()->refid,
//                            'is_trashed' => '0'
//                        ])
//                        ->orderDesc('message_time')
//                        ->all()
//                        ->toArray();
//        $allMessages = array_merge($outbox, $inbox);
//        $orderedMessages = $this->App->sortByDateCreated($allMessages);

        $query = $this->Messages->find('all', [
            'conditions' => ['Messages.chat_refid' => $chat_refid],
//            'contain' => ['MessageBoxes'],
            'limit' => $pagination_limit
        ])->orderDesc('id');
        
        $messages = $query->all()->toArray();
        
//        if (count($messages)) {
//            array_walk($messages, function(&$value, $index) {
//                if (property_exists($value, 'messageBoxes'));
//            });
//        }
//        switch ($filter)
//        {
//            case 'read': // Messages received and read
//                $query = $query->where([
//                    'Messages.author_refid !=' => $this->user->refid,
//                    'Messages.is_read =' => '1', 
//                    'Messages.trashed =' => '0'
//                ]);
//                break;
//            case 'unread': // Messages received but not yet read
//                $query = $query->where([
//                    'Messages.author_refid !=' => $this->user->refid,
//                    'Messages.is_read =' => '0', 
//                    'Messages.trashed =' => '0'
//                ]);
//                break;
//            case 'trashed': // Messages marked as trashed (received and sent)
//                $query = $query->where(['Messages.trashed =' => '1']);
//                break;
//            case 'trashed_read': // Messages received, read and trashed
//                $query = $query->where([
//                    'Messages.author_refid !=' => $this->user->refid,
//                    'Messages.is_read =' => '1',
//                    'Messages.trashed =' => '1'
//                ]);
//                break;
//            case 'trashed_unread': // Messages received and trashed without reading, or marked as unread
//                $query = $query->where([
//                    'Messages.author_refid !=' => $this->user->refid,
//                    'Messages.is_read =' => '0',
//                    'Messages.trashed =' => '1', 
//                ]);
//                break;
//            case 'trashed_sent': // Messages received and trashed without reading, or marked as unread
//                $query = $query->where([
//                    'Messages.author_refid =' => $this->user->refid,
//                    'Messages.trashed =' => '1', 
//                ]);
//                break;
//            case 'seen':
//                $query = $query->where([
//                    'Messages.author_refid !=' => $this->user->refid,
//                    'Messages.seen =' => '1', 
//                    'Messages.trashed =' => '0'
//                ]);
//                break;
//            case 'has_attachment':
//                $query = $query->where([
//                    'Messages.has_attachment =' => '1', 
//                    'Messages.trashed =' => '0'
//                ]);
//                break;
//            case 'has_attachment_trashed':
//                $query = $query->where([
//                    'Messages.has_attachment =' => '1', 
//                    'Messages.trashed =' => '1'
//                ]);
//                break;
//            default:
//                $query = $query->where([ 
//                    'Messages.trashed =' => '0'
//                ]);
//        }
//        $query = $query->orderDesc('id');
//        $results = (array) $query->all()->toArray();
//        
//        array_walk($results, function (&$value, $index) {
//            $value->author = $this->User->getUser($value->author_refid);
//            $value->recipient = $this->User->getUser($value->recipient_refid);
//        });

        return $messages;
    }
    
    /**
     * Fetches a single row from a given message table
     * 
     * @param string $message_refid
     * @param string $table_name
     * @return App\Model\Entity\IncomingMessage | App\Model\Entity\OutgoingMessage
     */
    public function getMessage($message_refid)
    {
        $msgTbl = $this->_tableLocator->get('Messages');
        $message = $msgTbl->get($message_refid);
        
        return $message;
    }
    
    
    /**
     * Participants retrieval method
     * Retrieves a comprehensive list of all participant in a given chat
     * 
     * @access protected
     * @param string $chat_refid
     */
    protected function _getChatParticipants( $chat_refid )
    {        
        $this->loadModel('ChatParticipants');
        $query = $this->ChatParticipants->find()->where(['chat_refid' => $chat_refid]);
        $results = (array) $query->all()->toArray();
        $participants = [];
        
        if (count($results))
        {
            foreach ($results as $result)
            {
                $participants[] = $this->getUser($result->participant_refid);
            }
        }
        
        return $participants;
    }
    
    public function conversation()
    {
        $this->autoRender = false;

        define('HOST_NAME', "localhost");
        define('PORT', 8080);
        $null = NULL;

        //require_once("class.chathandler.php");
        $chatHandler = $this->WebSocketChatHandler;

        $socketResource = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        socket_set_option($socketResource, SOL_SOCKET, SO_REUSEADDR, 1);
        socket_bind($socketResource, 0, PORT);
        socket_listen($socketResource);

        $clientSocketArray = array($socketResource);
//        debug($clientSocketArray);
//        exit;
        while (true) {
            $newSocketArray = $clientSocketArray;
            socket_select($newSocketArray, $null, $null, 0, 10);

            if (in_array($socketResource, $newSocketArray)) {
                $newSocket = socket_accept($socketResource);
                $clientSocketArray[] = $newSocket;

                $header = socket_read($newSocket, 1024);
                $chatHandler->doHandshake($header, $newSocket, HOST_NAME, PORT);

                socket_getpeername($newSocket, $client_ip_address);
                $connectionACK = $chatHandler->newConnectionACK($client_ip_address);

                $chatHandler->send($connectionACK);

                $newSocketIndex = array_search($socketResource, $newSocketArray);
                unset($newSocketArray[$newSocketIndex]);
            }

            foreach ($newSocketArray as $newSocketArrayResource) {
                while (socket_recv($newSocketArrayResource, $socketData, 1024, 0) >= 1) {
                    $socketMessage = $chatHandler->unseal($socketData);
                    $messageObj = json_decode($socketMessage);

                    $chat_box_message = $chatHandler->createChatBoxMessage($messageObj->chat_user, $messageObj->chat_message);
                    $chatHandler->send($chat_box_message);
                    break 2;
                }

                $socketData = @socket_read($newSocketArrayResource, 1024, PHP_NORMAL_READ);
                if ($socketData === false) {
                    socket_getpeername($newSocketArrayResource, $client_ip_address);
                    $connectionACK = $chatHandler->connectionDisconnectACK($client_ip_address);
                    $chatHandler->send($connectionACK);
                    $newSocketIndex = array_search($newSocketArrayResource, $clientSocketArray);
                    unset($clientSocketArray[$newSocketIndex]);
                }
            }
        }
        socket_close($socketResource);
    }
    
    public function eTextInterchange()
    {
        $request = $this->getRequest();
        $response = $this->getResponse();
        $msg = '';
        $isAjax = $request->is('ajax');
        
        if (! $request->is(['post','ajax'])) {
            $msg = 'Bad Request!';
            if ($isAjax) {
                $response = $response->withStatus(303, $msg);
                return $response;
            }
            throw new \Cake\Http\Exception\BadRequestException($msg);
        }
        
        $message = $request->getData();
        $msgRefid = RandomString::generateString(20);
        $chat_refid = (isset($message->chat_refid) ? $message->chat_refid : RandomString::generateString(20, 'numbers'));
        $sender = $this->getActiveUser();
        $senderIp = $request->clientIp();
        $senderLocation = $message->location;
        $recipients = json_decode($message->recipients, true);
        $text = $message->text;
        $msgReplied = $message->message_replied;
        $timestamp = time();
        $hasAttachments = 0;
        $chat = $this->findOrCreateChat($chat_refid);
        $uploadedFiles = (array) $this->FileManager->getUploadedFiles($request->getUploadedFiles());
        if (count($uploadedFiles) > 0) {
            $hasAttachments = 1;
            
        }
        
        $MessagesTable = $this->getTableLocator()->get('Messages');
        
        $msg_data = [
            'refid' => $msgRefid,
            'chat_refid' => $chat_refid,
            'author_refid' => $sender->refid,
            'author_ip' => $senderIp,
            'author_location' => $senderLocation,
            'text' => $text,
            'replyingto_message_refid' => $msgReplied,
            'has_attachment' => $hasAttachment,
            'message_time' => $timestamp
        ];
        
        $newMessage = $MessagesTable->newEntities($newMessage);
        
        $MessagesTable->getConnection()->transactional(function ()
                use ($MessagesTable, $newMessage, $chat_refid, $msgRefid, 
                $sender, $recipients, $timestamp) {
            if ($MessagesTable->save($newMessage, ['atomic' => false])) 
            {
                $messageBoxDataArray = [];
                $messageBoxDataArray[] = [
                    'refid' => RandomString::generateString(20),
                    'chat_refid' => $chat_refid,
                    'message_refid' => $msgRefid,
                    'sender_refid' => $sender->refid,
                    'recipient_refid' => $recipients[0],
                    'box' => 'outbox',
                    'message_time' => $timestamp
                ];

                foreach ($recipients as $recipient) {
                    $messageBoxDataArray[] = [
                        'refid' => RandomString::generateString(20),
                        'chat_refid' => $chat_refid,
                        'message_refid' => $msgRefid,
                        'sender_refid' => $sender->refid,
                        'recipient_refid' => $recipient,
                        'box' => 'inbox',
                        'message_time' => $timestamp
                    ];
                }

                $MessageBoxesTable = $this->getTableLocator()->get('MessagesBoxes');
                $messageBoxesEntities = $MessageBoxesTable->newEntities($messageBoxDataArray);
                $MessageBoxesTable->getConnection()->transactional(
                        function () use ($MessagesTable, $MessageBoxesTable, 
                        $messageBoxesEntities) {
                    $msg = null;
                    if ($MessageBoxesTable->saveMany($messageBoxesEntities, ['atomic' => false])) {
                        $MessagesTable->getConnection()->commit();
                        $MessageBoxesTable->getConnection()->commit();
                    } else {
                        $msg = 'Sorry, the message could not be delivered. Tap to retry...';
                        $response = $this->getResponse()->withStatus(200, $msg);
                    }
                });
            }
        });
        
        
    }

}
