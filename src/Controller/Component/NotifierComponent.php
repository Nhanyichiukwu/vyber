<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use App\Utility\RandomString;

/**
 * Notifier component
 */
class NotifierComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    
    protected $_connectionRequestMessage = "%s would like to connect with you";
    
    protected $_meetingRequestMessage = "%s would like to meet you.";
    
    protected $_introductionRequestMessage = "%s would like to introduce you to %s.";


    public function sendNotification($to, $reason, $initiator, $subject)
    {
//        $defaultMessage = "_{$requestType}RequestMessage";
//        if (empty($message)) {
//            $message = sprintf ($this->$defaultMessage, $user->fullname);
//        }
        
        $NotificationsTable = $this->getController()->getTableLocator()->get('Notifications');
        $datetime = date('Y-m-d h:i:s');
        $data = [
            'refid' => RandomString::generateString(20),
            'reason' => $reason,
            'target_refid' => $to->refid,
            'initiator_refid' => $initiator->refid,
            'subject_refid' => $subject->refid,
            'created' => $datetime,
            'modified' => $datetime
        ];
        $notification = $NotificationsTable->newEntity($data);
        if ($NotificationsTable->save($notification)) {
            return true;
        }
        
        return false;
    }
}
