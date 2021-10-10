<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Industry Entity
 *
 * @property int $id
 * @property int|null $parent_id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Industry $parent_industry
 * @property \App\Model\Entity\Genre[] $genres
 * @property \App\Model\Entity\Industry[] $child_industries
 * @property \App\Model\Entity\Role[] $roles
 * @property \App\Model\Entity\TalentHub[] $talent_hub
 */
class Industry extends Entity
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
        'parent_id' => true,
        'name' => true,
        'slug' => true,
        'description' => true,
        'created' => true,
        'modified' => true,
        'parent_industry' => true,
        'genres' => true,
        'child_industries' => true,
        'roles' => true,
        'talent_hub' => true,
    ];
}
