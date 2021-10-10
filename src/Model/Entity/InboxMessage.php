<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * InboxMessage Entity
 *
 * @property int $id
 * @property string $refid
 * @property string $chat_refid
 * @property string $message_refid
 * @property string $sender_refid
 * @property string|null $sender_location
 * @property string $recipient_refid
 * @property string|null $text
 * @property string $has_attachments
 * @property string|null $attachments_batch_id
 * @property string|null $is_seen
 * @property string|null $is_read
 * @property string|null $is_trashed
 * @property string|null $is_spam
 * @property \Cake\I18n\FrozenTime $message_time
 *
 * @property \App\Model\Entity\AttachmentsBatch $attachments_batch
 */
class InboxMessage extends Entity
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
        'sender_location' => true,
        'recipient_refid' => true,
        'text' => true,
        'has_attachments' => true,
        'attachments_batch_id' => true,
        'is_seen' => true,
        'is_read' => true,
        'is_trashed' => true,
        'is_spam' => true,
        'message_time' => true,
        'attachments_batch' => true
    ];
}
