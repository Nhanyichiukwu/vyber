<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Connection Entity
 *
 * @property int $id
 * @property string $user_refid
 * @property string $correspondent_refid
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class Connection extends Entity
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
        'user_refid' => true,
        'correspondent_refid' => true,
        'created' => true,
        'modified' => true
    ];
}
