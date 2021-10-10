<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MusicMaker Entity
 *
 * @property int $id
 * @property string $user_refid
 * @property string $role_refid
 * @property string $stagename
 * @property string $user_entity_refid
 * @property string|null $genre_refid
 * @property string|null $music_category_refid
 * @property \Cake\I18n\FrozenDate|null $debut
 * @property string|null $debute_album
 * @property string|null $debute_song
 * @property int|null $number_of_songs
 * @property int|null $number_of_videos
 * @property int|null $number_of_albums
 * @property int|null $number_of_features
 * @property string|null $skills
 * @property string|null $instruments_known
 * @property string|null $story
 * @property string|null $manager
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class MusicMaker extends Entity
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
        'stagename' => true,
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
        'skills' => true,
        'instruments_known' => true,
        'story' => true,
        'manager' => true,
        'created' => true,
        'modified' => true
    ];
}
