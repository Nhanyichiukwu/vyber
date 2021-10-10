<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FollowedFeed Entity
 *
 * @property int $id
 * @property string $followee_id
 * @property string $followee_industry
 * @property string $followee_role
 * @property string $follower_id
 * @property string $follower_industry
 * @property string $follower_role
 * @property string $follow_type
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Followee $followee
 * @property \App\Model\Entity\Follower $follower
 */
class FollowedFeed extends Entity
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
        'followee_id' => true,
        'followee_industry' => true,
        'followee_role' => true,
        'follower_id' => true,
        'follower_industry' => true,
        'follower_role' => true,
        'follow_type' => true,
        'created' => true,
        'modified' => true,
        'followee' => true,
        'follower' => true
    ];
}
