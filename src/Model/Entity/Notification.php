<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Notification Entity
 *
 * @property int $id
 * @property string $refid
 * @property string $type
 * @property string $user_refid
 * @property string|null $initiator_refid
 * @property string|null $subject_permalink
 * @property string $message
 * @property bool|null $is_read
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\User $e_user
 */
class Notification extends Entity
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
        'type' => true,
        'user_refid' => true,
        'initiator_refid' => true,
        'subject_source' => true,
        'subject_refid' => true,
        'subject_permalink' => true,
        'message' => true,
        'is_read' => true,
        'created' => true,
        'modified' => true,
        'e_user' => true
    ];
}
