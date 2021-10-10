<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PostReaction Entity
 *
 * @property int $id
 * @property string $refid
 * @property string $name
 * @property string $content_refid
 * @property string $content_type
 * @property string $reactor_refid
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class PostReaction extends Entity
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
        'refid' => true,
        'name' => true,
        'content_refid' => true,
        'content_type' => true,
        'reactor_refid' => true,
        'created' => true,
        'modified' => true
    ];
}
