<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Role Entity
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $aka
 * @property string|null $description
 * @property int|null $parent_id
 * @property int|null $industry_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Role $parent_role
 * @property \App\Model\Entity\Role[] $child_roles
 * @property \App\Model\Entity\UserRole[] $user_roles
 */
class Role extends Entity
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
        'name' => true,
        'slug' => true,
        'aka' => true,
        'description' => true,
        'parent_id' => true,
        'industry_id' => true,
        'created' => true,
        'modified' => true,
        'parent_role' => true,
        'child_roles' => true,
        'profiles' => true,
    ];
}
