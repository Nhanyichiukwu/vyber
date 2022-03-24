<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Genre Entity
 *
 * @property int $id
 * @property string $refid
 * @property string|null $parent_refid
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property int|null $industry_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class Genre extends Entity
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
        'parent_id' => true,
        'name' => true,
        'slug' => true,
        'description' => true,
        'parent_genre' => true,
        'child_genres' => true,
        'industry_id' => true,
        'profiles' => true,
        'created' => true,
        'modified' => true,
    ];
}
