<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Nomination Entity
 *
 * @property int $id
 * @property string $refid
 * @property string $refkey
 * @property string $user_refid
 * @property string $title
 * @property string|null $description
 * @property \Cake\I18n\FrozenTime $date
 * @property string $nominated_by
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class Nomination extends Entity
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
        'refkey' => true,
        'user_refid' => true,
        'title' => true,
        'description' => true,
        'date' => true,
        'nominated_by' => true,
        'created' => true,
        'modified' => true
    ];
}
