<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MediaView Entity
 *
 * @property string $media_refid
 * @property string $viewer_refid
 * @property \Cake\I18n\FrozenTime $view_date
 * @property float $view_level
 * @property string $playing_status
 */
class MediaView extends Entity
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
        'media_refid' => true,
        'viewer_refid' => true,
        'view_date' => true,
        'view_level' => true,
        'playing_status' => true
    ];
}
