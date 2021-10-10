<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * GroupInvite Entity
 *
 * @property int $id
 * @property int $group_id
 * @property string $sender_refid
 * @property string $invitee_refid
 * @property string|null $status
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Group $group
 */
class GroupInvite extends Entity
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
        'group_id' => true,
        'sender_refid' => true,
        'invitee_refid' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'group' => true,
    ];
}
