<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;

/**
 * Messenger component
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
     * The Logged in user object <br>
     * Useful in cases where a method is defined with a negligible user_refid
     * param but was called with no user_refid argument
     * 
     * @var \App\Model\Entity\User 
     */
    public $user;
    
    /**
     * The Table Locator object
     * 
     * @var \Cake\ORM\Locator\TableLocator 
     */
    protected $_tableLocator;
    
    /**
     * 
     * @var array
     */
    public $components = ['User'];


    public function initialize(array $config) {
        parent::initialize($config);
        
        if (!$this->_tableLocator) 
            $this->_tableLocator = $this->getController()->getTableLocator();
        if (!$this->user) 
            $this->user = $this->getController()->getActiveUser();
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
    public function getChatMessages( $chat_refid = null, $filter = null )
    {
        $MsgTbl = $this->_tableLocator->get('Messages');
        $query = $MsgTbl->find()->where(['Messages.chat_refid =' => $chat_refid]);
//        $result = null;

        switch ($filter)
        {
            case 'read': // Messages received and read
                $query = $query->where([
                    'Messages.author_refid !=' => $this->user->refid,
                    'Messages.is_read =' => '1', 
                    'Messages.trashed =' => '0'
                ]);
                break;
            case 'unread': // Messages received but not yet read
                $query = $query->where([
                    'Messages.author_refid !=' => $this->user->refid,
                    'Messages.is_read =' => '0', 
                    'Messages.trashed =' => '0'
                ]);
                break;
            case 'trashed': // Messages marked as trashed (received and sent)
                $query = $query->where(['Messages.trashed =' => '1']);
                break;
            case 'trashed_read': // Messages received, read and trashed
                $query = $query->where([
                    'Messages.author_refid !=' => $this->user->refid,
                    'Messages.is_read =' => '1',
                    'Messages.trashed =' => '1'
                ]);
                break;
            case 'trashed_unread': // Messages received and trashed without reading, or marked as unread
                $query = $query->where([
                    'Messages.author_refid !=' => $this->user->refid,
                    'Messages.is_read =' => '0',
                    'Messages.trashed =' => '1', 
                ]);
                break;
            case 'trashed_sent': // Messages received and trashed without reading, or marked as unread
                $query = $query->where([
                    'Messages.author_refid =' => $this->user->refid,
                    'Messages.trashed =' => '1', 
                ]);
                break;
            case 'seen':
                $query = $query->where([
                    'Messages.author_refid !=' => $this->user->refid,
                    'Messages.seen =' => '1', 
                    'Messages.trashed =' => '0'
                ]);
                break;
            case 'has_attachment':
                $query = $query->where([
                    'Messages.has_attachment =' => '1', 
                    'Messages.trashed =' => '0'
                ]);
                break;
            case 'has_attachment_trashed':
                $query = $query->where([
                    'Messages.has_attachment =' => '1', 
                    'Messages.trashed =' => '1'
                ]);
                break;
            default:
                $query = $query->where([ 
                    'Messages.trashed =' => '0'
                ]);
        }
        $query = $query->orderDesc('id');
        $results = (array) $query->all()->toArray();
        
        array_walk($results, function (&$value, $index) {
            $value->author = $this->User->getUser($value->author_refid);
            $value->recipient = $this->User->getUser($value->recipient_refid);
        });

        return $results;
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

    
    public function getConversation($chat_refid, $filter = null) {
        $chatsTbl = $this->_tableLocator->get('Chats');
        
        $conversation = $chatsTbl->get($chat_refid, [
            'contain' => ['ChatParticipants', 'Messages']
        ]);
        
        return $conversation;
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
    public function getChats( $user_refid = null )
    {
        if (is_null($user_refid)) {
            if ($this->user)
                $user_refid = $this->user->refid;
        }
        
        $chats = [];
        $ChatParticipantsTbl = $this->_tableLocator->get('ChatParticipants');
        $query = $ChatParticipantsTbl->find()->where(['participant_refid' => $user_refid]);
        $results = (array) $query->all()->toArray();
        
        if (count($results)) {
            foreach ($results as $result) {
                $chats[] = $this->getChat($result->chat_refid);
            }
        }
        
        return $chats;
    }

    
    /**
     * Chat entity retrieval method
     * 
     * - Gets a single chat entity using its id
     * 
     * @param string $chat_refid
     * @return \App\Model\Entity\Chat $chat | null
     */
    public function getChat( $chat_refid )
    {
        $ChatsTbl = $this->_tableLocator->get('Chats');
        $chat = $ChatsTbl->get($chat_refid);
        $chat->messages = (array) $this->getChatMessages($chat->refid);
        $chat->participants = (array) $this->getChatParticipants($chat->refid);
        
        
        return $chat;
    }
    
    
    /**
     * Participants retrieval method
     * Retrieves a comprehensive list of all participant in a given chat
     * 
     * @param string $chat_refid
     */
    public function getChatParticipants( $chat_refid )
    {
//        $ChatParticipantsTbl = $this->_tableLocator->get('ChatParticipants');
//        $query = $ChatParticipantsTbl->find()->where(['ChatParticipants.chat_refid =' => $chat_refid]);
//        $query = $query->aliasField('participant_refid');
//        $participants = (array) $query->all()->toArray();
//        $participants = array_unique($participants);
        
        $pTbl = $this->_tableLocator->get('ChatParticipants');
        $query = $pTbl->find()->where(['chat_refid' => $chat_refid]);
        $results = (array) $query->toArray();
        $participants = [];
        
        if (count($results))
        {
            foreach ($results as $result)
            {
                $participants[] = $this->User->getUser($result->participant_refid);
            }
        }
        
        return $participants;
    }
    
    /**
     * 
     * @param string $chat_refid
     * @param string $message
     * @param mixed $attachment
     */
    public function sendMessage( $chat_refid, $message = null, array $attachments = null )
    {
        $Incoming = $this->_tableLocator->get('Messages');
        $Outgoing = $this->_tableLocator->get('OutgoingMessages');
        $MsgAttachments = $this->_tableLocator->get('MessageAttachments');
        $chat = $this->getChat($chat_refid);
        
        $messageSenderName = "$this->user->firstname $this->user->lastname";
        $messageTime = date('Y-m-d h:i:s');
        $hasAttach = ($attachments) ? '1' : '0';
        $recipients = (array) $this->getChatParticipants($chat->chat_refid);
        unset($recipients[$this->user->_user_refid]);
        $totalRecipients = count($recipients);
        $failedMessagesSave = [];
        $successfulIncomingMsgs = 
                $successfulIncomingFileSave = $succefullIncomingFileMove = 
                $successfulOutgoingMsg = $successfulOutgoingFileSave = 
                $successfulOutgoingFileMove = [];

        $msgData = [
            'chat_refid' => $chat->chat_refid,
            'message_refid' => $message_refid,
            'sender_refid' => $this->user->user_refid,
            'sender_name' => $messageSenderName,
            'message_body' => $message,
            'has_attachment' => $hasAttach,
            'created' => $messageTime,
            'modified' => $messageTime
        ];
        
        $outgoingMsg = $Outgoing->newEntity($msgData);
        
        foreach ( $recipients as $participant_refid ) 
        {
            if ($participant_refid === $this->user->user_refid)
                continue; // Skip the sender's id if found in the recipients list
            
            $recipient = $this->User->getUser($participant_refid);
            $message_refid = $this->CustomString->generateRandom(20, ['type' => 'numbers']);
            // Define the message data
            $msgData = [
                'chat_refid' => $chat->chat_refid,
                'message_refid' => $message_refid,
                'sender_refid' => $messageSenderId,
                'sender_name' => $messageSenderName,
                'recipient_refid' => $recipient->user_refid,
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
                    $fileFinalDestination = static::UPLOAD_DIR . $this->user->user_refid . '/' . $fileFiletype . 's/';

                    if (!is_dir($fileFinalDestination)) {
                        $Folder = New Folder($fileFinalDestination, true, 0755);
                        $fileFinalDestination = $Folder->path;
                    }

                    $fileFinalDestination = rtrim($fileFinalDestination, '/') . '/' . $fileName;
                    //$fileUrl = static::UPLOAD_DIR . $user->user_refid . '/' . $fileFiletype . '/' . $fileName;
                    $fileUrl = explode('/', $fileFinalDestination);
                    array_shift($fileUrl);
                    $fileUrl = trim(implode('/', $fileUrl), '/');

                    $attachmentId = $this->CustomString->generateRandom(20, ['type' => 'numbers']);
                    $attachData = [
                        'attachment_refid' => $attachmentId,
                        'message_refid' => $incomingMsg->message_refid,
                        'user_refid' => $messageSenderId,
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
                        $failedMessagesSave[] = $incomingMsg;
                    } elseif (! $attachment->moveTo($fileFinalDestination)) {
                            $failedFileMove[] = $fileFinalDestination;
                    }
                }
            }
            else
            {
                if (!$Incoming->save($incomingMsg)) {
                    $failedMessagesSave[] = $incomingMsg;
                }
            }
        }
        
        // Confirming the total number of messages failed to save before
        // proceeding to insert the sender record
        if (count($failedMessagesSave) < $totalRecipients) 
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
                    $fileFinalDestination = static::UPLOAD_DIR . $this->user->user_refid . '/' . $fileFiletype . 's/';

                    if (!is_dir($fileFinalDestination)) {
                        $Folder = New Folder($fileFinalDestination, true, 0755);
                        $fileFinalDestination = $Folder->path;
                    }

                    $fileFinalDestination = rtrim($fileFinalDestination, '/') . '/' . $fileName;
                    //$fileUrl = static::UPLOAD_DIR . $user->user_refid . '/' . $fileFiletype . '/' . $fileName;
                    $fileUrl = explode('/', $fileFinalDestination);
                    array_shift($fileUrl);
                    $fileUrl = trim(implode('/', $fileUrl), '/');

                    $attachmentId = $this->CustomString->generateRandom(20, ['type' => 'numbers']);
                    $attachData = [
                        'attachment_refid' => $attachmentId,
                        'message_refid' => $incomingMsg->message_refid,
                        'user_refid' => $messageSenderId,
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
                        $failedMessagesSave[] = $incomingMsg;
                    } elseif (! $attachment->moveTo($fileFinalDestination)) {
                            $failedFileMove[] = $fileFinalDestination;
                    }
                }
            }
            else
            {
                if (!$Incoming->save($incomingMsg)) {
                    $failedMessagesSave[] = $incomingMsg;
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
                foreach ($successfulMessagesSave as $successfulMsg) {
                    $Incoming->delete($successfulMsg);
                }
                
                return false;
            }
        }
    }
}
