<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MessageBox Entity
 *
 * @property int $id
 * @property string $refid
 * @property string $chat_refid
 * @property string $message_refid
 * @property string $sender_refid
 * @property string|null $recipient_refid
 * @property string $box
 * @property bool|null $is_seen
 * @property bool|null $is_read
 * @property bool|null $is_trashed
 * @property bool|null $is_spam
 * @property bool|null $archived
 * @property \Cake\I18n\FrozenTime $message_time
 */
class MessageBox extends Entity
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
        'refid' => true,
        'chat_refid' => true,
        'message_refid' => true,
        'sender_refid' => true,
        'recipient_refid' => true,
        'box' => true,
        'is_seen' => true,
        'is_read' => true,
        'is_trashed' => true,
        'is_spam' => true,
        'archived' => true,
        'message_time' => true
    ];
}
