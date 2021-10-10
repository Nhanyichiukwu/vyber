<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Media Entity
 *
 * @property int $id
 * @property string $refid
 * @property string $title
 * @property string $slug
 * @property string|null $description
 * @property string|null $cast
 * @property string|null $tags
 * @property string $author_refid
 * @property string|null $genre_refid
 * @property string|null $album_refid
 * @property string|null $author_location
 * @property string|resource|null $categories
 * @property string $file_path
 * @property string $permalink
 * @property string $file_mime
 * @property string $media_type
 * @property string|null $classification
 * @property string|null $target_audience
 * @property string|null $audience_locations
 * @property string|null $age_restriction
 * @property string|null $audio_or_video_counterpart_refid
 * @property \Cake\I18n\FrozenDate|null $recording_date
 * @property \Cake\I18n\FrozenDate|null $release_date
 * @property string|null $privacy
 * @property string|null $status
 * @property bool|null $is_debut
 * @property bool|null $monetize
 * @property string|null $language
 * @property string|null $orientation
 * @property string|null $thumbnail
 * @property int|null $total_plays
 * @property int|null $number_of_people_played
 * @property int|null $number_of_downloads
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class Media extends Entity
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
        'author_refid' => true,
        'genre_refid' => true,
        'album_refid' => true,
        'author_location' => true,
        'categories' => true,
        'file_path' => true,
        'permalink' => true,
        'file_mime' => true,
        'media_type' => true,
        'classification' => true,
        'target_audience' => true,
        'audience_locations' => true,
        'age_restriction' => true,
        'audio_or_video_counterpart_refid' => true,
        'recording_date' => true,
        'release_date' => true,
        'privacy' => true,
        'status' => true,
        'is_debut' => true,
        'monetize' => true,
        'language' => true,
        'orientation' => true,
        'thumbnail' => true,
        'total_plays' => true,
        'number_of_people_played' => true,
        'number_of_downloads' => true,
        'created' => true,
        'modified' => true
    ];
}
