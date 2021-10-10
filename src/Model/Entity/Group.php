<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Group Entity
 *
 * @property int $id
 * @property string $refid
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property string|null $group_image
 * @property string $author
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\GroupInvite[] $group_invites
 * @property \App\Model\Entity\GroupJoinRequest[] $group_join_requests
 * @property \App\Model\Entity\GroupMedia[] $group_medias
 * @property \App\Model\Entity\GroupMember[] $group_members
 * @property \App\Model\Entity\GroupPost[] $group_posts
 */
class Group extends Entity
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
        'name' => true,
        'slug' => true,
        'description' => true,
        'group_image' => true,
        'author' => true,
        'created' => true,
        'modified' => true,
        'group_invites' => true,
        'group_join_requests' => true,
        'group_medias' => true,
        'group_members' => true,
        'group_posts' => true,
    ];
}
