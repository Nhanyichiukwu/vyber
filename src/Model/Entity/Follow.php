<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Follow Entity
 *
 * @property int $id
 * @property string $follower_refid
 * @property string $followee_refid
 * @property \Cake\I18n\FrozenTime $created
 */
class Follow extends Entity
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
        'follower_refid' => true,
        'followee_refid' => true,
        'created' => true
    ];
}
