<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MovieMakersProfile Entity
 *
 * @property int $id
 * @property string $user_refid
 * @property string $role_refid
 * @property string $popular_name
 * @property \Cake\I18n\FrozenDate|null $debut
 * @property string|null $debut_movie
 * @property int|null $number_of_movies
 * @property string|null $skills
 * @property string|null $instruments_known
 * @property string|null $spoken_languages
 * @property string|null $story
 * @property string|null $manager
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property string|null $debut_movie_role
 */
class MovieMakersProfile extends Entity
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
        'popular_name' => true,
        'debut' => true,
        'debut_movie' => true,
        'number_of_movies' => true,
        'skills' => true,
        'instruments_known' => true,
        'spoken_languages' => true,
        'story' => true,
        'manager' => true,
        'created' => true,
        'modified' => true,
        'debut_movie_role' => true
    ];
}
