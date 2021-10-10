<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * GroupMember Entity
 *
 * @property int $group_id
 * @property string $user_refid
 * @property string|null $invited_by
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property string|null $status
 * @property \Cake\I18n\FrozenTime|null $invited_at
 * @property string|null $approved_by
 * @property \Cake\I18n\FrozenTime|null $approved_at
 * @property bool|null $is_admin
 *
 * @property \App\Model\Entity\Group $group
 */
class GroupMember extends Entity
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
        'user_refid' => true,
        'invited_by' => true,
        'created' => true,
        'modified' => true,
        'status' => true,
        'invited_at' => true,
        'approved_by' => true,
        'approved_at' => true,
        'is_admin' => true,
        'group' => true,
    ];
}
