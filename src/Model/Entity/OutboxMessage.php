<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OutboxMessage Entity
 *
 * @property int $id
 * @property string $refid
 * @property string $chat_refid
 * @property string $sender_refid
 * @property string|null $sender_location
 * @property string|null $text
 * @property string $has_attachments
 * @property string|null $attachments_batch_id
 * @property string $status
 * @property string|null $is_read
 * @property string|null $is_trashed
 * @property \Cake\I18n\FrozenTime $message_time
 *
 * @property \App\Model\Entity\AttachmentsBatch $attachments_batch
 */
class OutboxMessage extends Entity
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
        'sender_refid' => true,
        'sender_location' => true,
        'text' => true,
        'has_attachments' => true,
        'attachments_batch_id' => true,
        'status' => true,
        'is_read' => true,
        'is_trashed' => true,
        'message_time' => true,
        'attachments_batch' => true
    ];
}
