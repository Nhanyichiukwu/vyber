<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Category Entity
 *
 * @property int $id
 * @property string $refid
 * @property string|null $parent_refid
 * @property string $name
 * @property string $slug
 * @property int|null $type_id
 * @property string|null $description
 * @property string|null $thumbnail
 * @property int|null $views
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\CategoryType $category_type
 */
class Category extends Entity
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
        'parent_refid' => true,
        'name' => true,
        'slug' => true,
        'type_id' => true,
        'description' => true,
        'thumbnail' => true,
        'views' => true,
        'created' => true,
        'modified' => true,
        'category_type' => true,
    ];
}
