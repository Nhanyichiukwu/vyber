<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Email Entity
 *
 * @property int $id
 * @property string $refid
 * @property string $user_refid
 * @property string $address
 * @property bool|null $is_primary
 * @property string|null $type
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class Email extends Entity
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
        'address' => true,
        'is_primary' => true,
        'type' => true,
        'created' => true,
        'modified' => true
    ];

}
