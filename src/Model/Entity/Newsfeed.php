<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Newsfeed Entity
 *
 * @property int $id
 * @property string $feed_refid
 * @property string $user_refid
 * @property string|null $content_type
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class Newsfeed extends Entity
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
        'feed_refid' => true,
        'user_refid' => true,
        'content_type' => true,
        'created' => true,
        'modified' => true
    ];
}
