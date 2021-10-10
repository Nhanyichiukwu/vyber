<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * GroupJoinRequest Entity
 *
 * @property int $id
 * @property int $group_id
 * @property string $user_refid
 * @property string|null $status
 * @property string|null $message
 * @property string|null $appeal
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property string|null $approved_by
 * @property \Cake\I18n\FrozenTime|null $approved_at
 *
 * @property \App\Model\Entity\Group $group
 */
class GroupJoinRequest extends Entity
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
        'status' => true,
        'message' => true,
        'appeal' => true,
        'created' => true,
        'modified' => true,
        'approved_by' => true,
        'approved_at' => true,
        'group' => true,
    ];
}
