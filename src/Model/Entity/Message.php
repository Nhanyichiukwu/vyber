<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Message Entity
 *
 * @property int $id
 * @property string $refid
 * @property string $chat_refid
 * @property string $author_refid
 * @property string|null $author_ip
 * @property string|null $author_location
 * @property string|null $text
 * @property string|null $counter_message_refid
 * @property bool|null $has_attachment
 * @property \Cake\I18n\FrozenTime $message_time
 * @property string|null $is_seen
 * @property bool|null $is_read
 * @property bool|null $is_reply
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class Message extends Entity
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
        'author_refid' => true,
        'author_ip' => true,
        'author_location' => true,
        'text' => true,
        'counter_message_refid' => true,
        'has_attachment' => true,
        'message_time' => true,
        'is_seen' => true,
        'is_read' => true,
        'is_reply' => true,
        'created' => true,
        'modified' => true
    ];
}
