<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;

/**
 * Messenger component
 * 
 * @property \App\Model\Entity\User $user The currently logged in user
 * @property \Cake\ORM\Locator\TableLocator $_tableLocator The ORM Table Locator
 */
class MessengerComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    
    /**
     * The Logged in user object
     * 
     * Useful in cases where a method is defined with a negligible user_id
     * param but was called with no user_id argument
     * 
     * @var object 
     */
    public $user;
    
    /**
     * The Table Locator object
     * 
     * @var object 
     */
    protected $_tableLocator;
    
    public function initialize(array $config) {
        parent::initialize($config);
        
        $this->_tableLocator = $this->getController()->getTableLocator();
    }
    
    /**
     * Message Retrieval method
     * 
     * Retrieves messages from the incoming_messages table.
     * This method returns only unread messages by default, but can be
     * manipulated to filter messages based on different filter options
     * This method is particularly handy for informing the user of new unread
     * messages
     *  
     * @param string $user_id
     * @param string $filter
     * @return array A list of recently received and unread messages by default | empty array if noting was found
     */
    public function getMessages( $user_id = null, $filter = null )
    {
        if (is_null($user_id)) {
            if ($this->user)
                $user_id = $this->user->user_id;
        }
        
        $MsgTbl = $this->_tableLocator->get('IncomingMessages');
        $query = $MsgTbl->find()->where(['IncomingMessages.recipient_id =' => $user_id]);
        $result = null;
        
        if (!$filter) 
            $filter = 'unread'; // Default filter option;

        switch ($filter)
        {
            case 'read':
                $query = $query->where(['IncomingMessages.read =' => '1', 'IncomingMessages.trashed =' => '0']);
                break;
            case 'unread':
                $query = $query->where(['IncomingMessages.read =' => '0', 'IncomingMessages.trashed =' => '0']);
                break;
            case 'trashed':
                $query = $query->where(['IncomingMessages.trashed =' => '1']);
                break;
            case 'trashed_read':
                $query = $query->where(['IncomingMessages.trashed =' => '1', 'IncomingMessages.read =' => '1']);
                break;
            case 'trashed_unread':
                $query = $query->where(['IncomingMessages.trashed =' => '1', 'IncomingMessages.read =' => '0']);
                break;
            case 'seen':
                $query = $query->where(['IncomingMessages.seen =' => '1', 'IncomingMessages.trashed =' => '0']);
                break;
            case 'has_attachment':
                $query = $query->where(['IncomingMessages.has_attachment =' => '1', 'IncomingMessages.trashed =' => '0']);
                break;
            case 'has_attachment_trashed':
                $query = $query->where(['IncomingMessages.has_attachment =' => '1', 'IncomingMessages.trashed =' => '1']);
                break;
            default:
                $query = false;
        }

        if ($query !== false) {
            $result = $query->all()->toList();
        }

        return $result;
    }
    
    public function getSentMessages($filter = null)
    {
        $msgTbl = $this->_tableLocator->get('OutgoingMessages');
        $query = $msgTbl
                ->find()
                ->where(['OutgoingMessages.sender_id =' => $this->user->user_id]);
        
        if ($filter) {
            $query = $msgTbl->applyFilter($query, $filter);
        }
        
        $result = $query->all()->toArray();
        
        return $result;
    }
    
    public function getReceivedMessages($filter = 'unread')
    {
        $msgTbl = $this->_tableLocator->get('IncomingMessages');
        $query = $msgTbl
                ->find('all')
                ->where(['IncomingMessages.recipient_id =' => $this->user->user_id]);
        
        if ($filter) {
            $query = $msgTbl->applyFilter($query, $filter);
        }
        
        $result = $query->all()->toArray();
        
        return $result;
    }
    
    /**
     * Fetches a single row from a given message table
     * 
     * @param string $message_id
     * @param string $table_name
     * @return App\Model\Entity\IncomingMessage | App\Model\Entity\OutgoingMessage
     */
    public function getMessage($message_id, $table_name = 'IncomingMessages')
    {
        $msgTbl = $this->_tableLocator->get($table_name);
        $message = $msgTbl->get($message_id);
        
        return $message;
    }

    
    public function getConversation($chat_id, $filter = null) {
        $chatsTble = $this->_tableLocator->get('Chats');
        
        $chat = $this->Chats->get($chat_id, [
            'contain' => ['ChatParticipants', 'IncomingMessages', 'OutgoingMessages']
        ]);
        $conversation = $chat->incoming_messages + $chat->outgoing_messages;
        
        return $conversation;
    }

    /**
     * Chats retrieval method
     * 
     * - Get all available chats (private/group) in which the user is a participant
     * 
     * @param string $user_id
     * @return array This will return either a list of chat entity objects or
     * an empty array
     */
    public function getChats( $user_id = null )
    {
        if (is_null($user_id)) {
            if ($this->user)
                $user_id = $this->user->user_id;
        }
        
        $chats = [];
        $ChatParticipantsTbl = $this->_tableLocator->get('ChatParticipants');
        $query = $ChatParticipantsTbl->find()->where(['ChatParticipants.participant_id =' => $user_id]);
        $query = $query->aliasField('chat_id');
        $results = (array) $query->all()->toArray();
        
        if (count($results)) {
            foreach ($results as $chat_id) {
                $chats[] = $this->getChat($chat_id);
            }
        }
        
        return $chats;
    }

    
    /**
     * Chat entity retrieval method
     * 
     * - Gets a single chat entity using its id
     * 
     * @param string $chat_id
     * @return \App\Model\Entity\Chat $chat | null
     */
    public function getChat( $chat_id )
    {
        $ChatsTbl = $this->_tableLocator->get('Chats');
        $chat = $ChatsTbl->get($chat_id);
        
        return $chat;
    }
    
    
    /**
     * Participants retrieval method
     * Retrieves a comprehensive list of all participant in a given chat
     * 
     * @param string $chat_id
     */
    public function getChatParticipants( $chat_id )
    {
//        $ChatParticipantsTbl = $this->_tableLocator->get('ChatParticipants');
//        $query = $ChatParticipantsTbl->find()->where(['ChatParticipants.chat_id =' => $chat_id]);
//        $query = $query->aliasField('participant_id');
//        $participants = (array) $query->all()->toArray();
//        $participants = array_unique($participants);
        
        $chatTbl = $this->_tableLocator->get('Chats');
        $chat = $chatTbl->get($chat_id, [
            'contain' => 'ChatParticipants'
        ]);
        $participants = $chat->chat_participants;
        
        return $participants;
    }
    
    /**
     * 
     * @param string $chat_id
     * @param string $message
     * @param mixed $attachment
     */
    public function sendMessage( $chat_id, $message = null, array $attachments = null )
    {
        $Incoming = $this->_tableLocator->get('IncomingMessages');
        $Outgoing = $this->_tableLocator->get('OutgoingMessages');
        $MsgAttachments = $this->_tableLocator->get('MessageAttachments');
        $chat = $this->getChat($chat_id);
        $messageSenderId = $this->user->user_id;
        $messageSenderName = "$this->user->firstname $this->user->lastname";
        $messageTime = date('Y-m-d h:i:s');
        $hasAttach = ($attachments) ? '1' : '0';
        $recipients = (array) $this->getChatParticipants($chat->chat_id);
        unset($recipients[$this->user->_user_id]);
        $totalRecipients = count($recipients);
        $failedIncomingMessagesSave = [];
        $successfulIncomingMsgs = 
                $successfulIncomingFileSave = $succefullIncomingFileMove = 
                $successfulOutgoingMsg = $successfulOutgoingFileSave = 
                $successfulOutgoingFileMove = [];

        $msgData = [
            'chat_id' => $chat->chat_id,
            'message_id' => $message_id,
            'sender_id' => $messageSenderId,
            'sender_name' => $messageSenderName,
            'recipient_id' => '',
            'recipient_name' => '',
            'message_body' => $message,
            'has_attachment' => $hasAttach,
            'created' => $messageTime,
            'modified' => $messageTime
        ];
        
            $outgoingMsg = $Outgoing->newEntity($msgData);
        
        foreach ( $recipients as $participant_id ) 
        {
            if ($participant_id === $this->user->user_id)
                continue; // Remove the sender if found in the recipients list
            
            $recipient = $this->User->getUser($participant_id);
            $message_id = $this->CustomString->generateRandom(20, ['type' => 'numbers']);
            // Define the message data
            $msgData = [
                'chat_id' => $chat->chat_id,
                'message_id' => $message_id,
                'sender_id' => $messageSenderId,
                'sender_name' => $messageSenderName,
                'recipient_id' => $recipient->user_id,
                'recipient_name' => "$recipient->firstname $recipient->lastname",
                'message_body' => $message,
                'has_attachment' => $hasAttach,
                'created' => $messageTime,
                'modified' => $messageTime
            ];
            
            $incomingMsg = $Incoming->newEntity();
            $incomingMsg = $Incoming->patchEntity($incomingMsg, $msgData);
            
            // If there are attachments, then message should only be sent when
            // the attachments are successfully saved
            
            
            // Try processing the attachments if their is any
            // In the future, we hope to advance this aspect of our application
            // to use Contents Delivery Networks (CDN) for file storage, in
            // order to optimize speed
            if ($hasAttach == '1') 
            {
                $failedAttachments = $failedFileMove = [];
                
                foreach ($attachments as $attachment) 
                {
                    $fileFilename = $attachment->getClientFilename();
                    $fileMediaType = $attachment->getClientMediaType();
                    $fileFiletype = $this->_defineAttachment($fileMediaType);

                    // Getting the file extension and creating a new random name
                    // for the file to avoid having files with similar names
                    $fileFilenameSplit = explode('.', $fileFilename);
                    $ext = end($fileFilenameSplit);

                    $fileName = time() . '_' . $this->CustomString->generateRandom(32) . '.' . $ext;
                    $fileFinalDestination = static::UPLOAD_DIR . $this->user->user_id . '/' . $fileFiletype . 's/';

                    if (!is_dir($fileFinalDestination)) {
                        $Folder = New Folder($fileFinalDestination, true, 0755);
                        $fileFinalDestination = $Folder->path;
                    }

                    $fileFinalDestination = rtrim($fileFinalDestination, '/') . '/' . $fileName;
                    //$fileUrl = static::UPLOAD_DIR . $user->user_id . '/' . $fileFiletype . '/' . $fileName;
                    $fileUrl = explode('/', $fileFinalDestination);
                    array_shift($fileUrl);
                    $fileUrl = trim(implode('/', $fileUrl), '/');

                    $attachmentId = $this->CustomString->generateRandom(20, ['type' => 'numbers']);
                    $attachData = [
                        'attachment_id' => $attachmentId,
                        'message_id' => $incomingMsg->message_id,
                        'user_id' => $messageSenderId,
                        'attachment_url' => $fileUrl,
                        'attachment_type' => $fileFiletype,
                        'created' => $messageTime,
                        'modified' => $messageTime
                    ];

                    $newAttach = $MsgAttachments->newEntity($attachData);
                    if (!$MsgAttachments->save($newAttach)) {
                        $failedAttachments[] = $newAttach;
                    }
                }

                if (!count($failedAttachments)) 
                { 
                // It means the attachments for this message were successfully 
                //inserted into the db
                    if (!$Incoming->save($incomingMsg)) {
                        $failedIncomingMessagesSave[] = $incomingMsg;
                    } elseif (! $attachment->moveTo($fileFinalDestination)) {
                            $failedFileMove[] = $fileFinalDestination;
                    }
                }
            }
            else
            {
                if (!$Incoming->save($incomingMsg)) {
                    $failedIncomingMessagesSave[] = $incomingMsg;
                }
            }
        }
        
        // Confirming the total number of messages failed to save before
        // proceeding to insert the sender record
        if (count($failedIncomingMessagesSave) < $totalRecipients) 
        {
            if ($hasAttach == '1') 
            {
                $failedAttachments = $failedFileMove = [];
                
                foreach ($attachments as $attachment) 
                {
                    $fileFilename = $attachment->getClientFilename();
                    $fileMediaType = $attachment->getClientMediaType();
                    $fileFiletype = $this->_defineAttachment($fileMediaType);

                    // Getting the file extension and creating a new random name
                    // for the file to avoid having files with similar names
                    $fileFilenameSplit = explode('.', $fileFilename);
                    $ext = end($fileFilenameSplit);

                    $fileName = time() . '_' . $this->CustomString->generateRandom(32) . '.' . $ext;
                    $fileFinalDestination = static::UPLOAD_DIR . $this->user->user_id . '/' . $fileFiletype . 's/';

                    if (!is_dir($fileFinalDestination)) {
                        $Folder = New Folder($fileFinalDestination, true, 0755);
                        $fileFinalDestination = $Folder->path;
                    }

                    $fileFinalDestination = rtrim($fileFinalDestination, '/') . '/' . $fileName;
                    //$fileUrl = static::UPLOAD_DIR . $user->user_id . '/' . $fileFiletype . '/' . $fileName;
                    $fileUrl = explode('/', $fileFinalDestination);
                    array_shift($fileUrl);
                    $fileUrl = trim(implode('/', $fileUrl), '/');

                    $attachmentId = $this->CustomString->generateRandom(20, ['type' => 'numbers']);
                    $attachData = [
                        'attachment_id' => $attachmentId,
                        'message_id' => $incomingMsg->message_id,
                        'user_id' => $messageSenderId,
                        'attachment_url' => $fileUrl,
                        'attachment_type' => $fileFiletype,
                        'created' => $messageTime,
                        'modified' => $messageTime
                    ];

                    $newAttach = $MsgAttachments->newEntity($attachData);
                    if (!$MsgAttachments->save($newAttach)) {
                        $failedAttachments[] = $newAttach;
                    }
                }

                if (!count($failedAttachments)) 
                { 
                // It means the attachments for this message were successfully 
                //inserted into the db
                    if (!$Incoming->save($incomingMsg)) {
                        $failedIncomingMessagesSave[] = $incomingMsg;
                    } elseif (! $attachment->moveTo($fileFinalDestination)) {
                            $failedFileMove[] = $fileFinalDestination;
                    }
                }
            }
            else
            {
                if (!$Incoming->save($incomingMsg)) {
                    $failedIncomingMessagesSave[] = $incomingMsg;
                }
            }
            if ($Outgoing->save($outgoingMsg)) {
                
                return true;
            } else { 
                // Since the outgoing part failed to save, we delete every
                // data saved and return a failure response to the sender
                foreach ($successfulAttachments as $attachment ) {
                    $MsgAttachments->delete($attachment);
                }
                foreach ($successfulFileMove as $file) {
                    $File = new File($file);
                    if ($File->exists())
                        $File->delete();
                }
                foreach ($successfulIncomingMessagesSave as $successfulMsg) {
                    $Incoming->delete($successfulMsg);
                }
                
                return false;
            }
        }
    }
}
