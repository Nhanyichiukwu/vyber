<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MusicProfile Entity
 *
 * @property int $id
 * @property string|null $user_refid
 * @property string|null $role_refid
 * @property string|null $celebrity_name
 * @property string|null $user_entity_refid
 * @property string|null $genre_refid
 * @property string|null $music_categories
 * @property \Cake\I18n\FrozenDate|null $debut
 * @property string|null $debut_album
 * @property string|null $debut_song
 * @property int|null $number_of_songs
 * @property int|null $number_of_videos
 * @property int|null $number_of_albums
 * @property int|null $number_of_features
 * @property string|null $story
 * @property string|null $manager
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class MusicProfile extends Entity
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
        'user_refid' => true,
        'role_refid' => true,
        'celebrity_name' => true,
        'user_entity_refid' => true,
        'genre_refid' => true,
        'music_categories' => true,
        'debut' => true,
        'debut_album' => true,
        'debut_song' => true,
        'number_of_songs' => true,
        'number_of_videos' => true,
        'number_of_albums' => true,
        'number_of_features' => true,
        'story' => true,
        'manager' => true,
        'created' => true,
        'modified' => true
    ];
}
