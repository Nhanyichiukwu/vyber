<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * GroupMedia Entity
 *
 * @property int $id
 * @property int $group_id
 * @property string $user_refid
 * @property string $media_path
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Group $group
 */
class GroupMedia extends Entity
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
        'media_path' => true,
        'created' => true,
        'modified' => true,
        'group' => true,
    ];
}
