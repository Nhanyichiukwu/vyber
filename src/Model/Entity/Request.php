<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Request Entity
 *
 * @property int $id
 * @property string $refid
 * @property string $sender_refid
 * @property string $recipient_refid
 * @property string|null $suggested_user_refid
 * @property \Cake\I18n\FrozenTime|null $proposed_meeting_date
 * @property \Cake\I18n\FrozenTime|null $proposed_meeting_time
 * @property string|null $short_message
 * @property bool|null $is_read
 * @property string $type
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class Request extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'id' => true,
        'refid' => true,
        'sender_refid' => true,
        'recipient_refid' => true,
        'suggested_user_refid' => true,
        'proposed_meeting_date' => true,
        'proposed_meeting_time' => true,
        'short_message' => true,
        'is_read' => true,
        'type' => true,
        'created' => true,
        'modified' => true
    ];

    public function getMessage()
    {
        return $this->short_message;
    }

    public function getsender()
    {
        return $this->sender;
    }

    public function getRecipient()
    {
        return $this->recipient;
    }

    public function getSuggestedUser()
    {
        return $this->suggested_user;
    }
}
