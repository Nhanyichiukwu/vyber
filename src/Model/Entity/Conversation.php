<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Conversation Entity
 *
 * @property int $id
 * @property string $refid
 * @property string $chat_refid
 * @property string $message_refid
 * @property string $sender_refid
 * @property string|null $recipient_refid
 * @property bool|null $is_read
 * @property bool|null $is_trashed
 * @property string|null $flag
 * @property bool|null $archived
 * @property \Cake\I18n\FrozenTime $message_time
 *
 * @property \App\Model\Entity\Chat $chat
 * @property \App\Model\Entity\Message $message
 * @property \App\Model\Entity\User $sender
 * @property \App\Model\Entity\User $recipient
 */
class Conversation extends Entity
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
        'chat_refid' => true,
        'message_refid' => true,
        'sender_refid' => true,
        'recipient_refid' => true,
        'is_read' => true,
        'is_trashed' => true,
        'flag' => true,
        'archived' => true,
        'message_time' => true,
        'chat' => true,
        'message' => true,
        'sender' => true,
        'recipient' => true
    ];
}
