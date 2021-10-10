<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Video Entity
 *
 * @property int $id
 * @property string $refid
 * @property string $refkey
 * @property string $title
 * @property string $slug
 * @property string|null $description
 * @property string|null $cast
 * @property string|null $tags
 * @property string $privacy
 * @property string|null $author_location
 * @property string $url
 * @property string $file_mime_type
 * @property string $video_type
 * @property string $author_refid
 * @property string|null $audio_refid
 * @property string|null $album_refid
 * @property string|null $genre_refid
 * @property string|null $category_refid
 * @property \Cake\I18n\FrozenTime|null $release_date
 * @property string $status
 * @property bool|null $is_debut
 * @property bool|null $monetize
 * @property int|null $total_plays
 * @property int|null $number_of_people_played
 * @property int|null $number_of_downloads
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class Video extends Entity
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
        'title' => true,
        'slug' => true,
        'description' => true,
        'cast' => true,
        'tags' => true,
        'privacy' => true,
        'author_location' => true,
        'file_path' => true,
        'file_mime_type' => true,
        'video_type' => true,
        'author_refid' => true,
        'audio_refid' => true,
        'album_refid' => true,
        'genre_refid' => true,
        'category_refid' => true,
        'release_date' => true,
        'status' => true,
        'is_debut' => true,
        'monetize' => true,
        'total_plays' => true,
        'number_of_people_played' => true,
        'number_of_downloads' => true,
        'created' => true,
        'modified' => true
    ];
}
