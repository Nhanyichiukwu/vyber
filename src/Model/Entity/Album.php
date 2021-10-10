<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Album Entity
 *
 * @property int $id
 * @property string $refid
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property string $owner_refid
 * @property string $type
 * @property string|null $counterpart
 * @property \Cake\I18n\FrozenTime|null $release_date
 * @property bool|null $is_debut
 * @property string $privacy
 * @property bool|null $published
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $mofified
 */
class Album extends Entity
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
        'name' => true,
        'slug' => true,
        'description' => true,
        'owner_refid' => true,
        'media_type' => true,
        'counterpart' => true,
        'release_date' => true,
        'is_debut' => true,
        'privacy' => true,
        'published' => true,
        'created' => true,
        'mofified' => true
    ];
}
