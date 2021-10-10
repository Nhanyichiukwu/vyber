<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Photo Entity
 *
 * @property int $id
 * @property string $refid
 * @property string $author_refid
 * @property string|null $album_refid
 * @property string $url
 * @property string|null $location
 * @property string|null $privacy
 * @property string|null $tags
 * @property string|null $role
 * @property string|null $caption
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\User $author
 * @property \App\Model\Entity\Album $photo_album
 */
class Photo extends Entity
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
        'author_refid' => true,
        'album_refid' => true,
        'file_path' => true,
        'location' => true,
        'privacy' => true,
        'tags' => true,
        'role' => true,
        'caption' => true,
        'created' => true,
        'modified' => true,
        'author' => true,
        'photo_album' => true
    ];
}
