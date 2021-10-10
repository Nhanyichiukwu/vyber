<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CategoryItem Entity
 *
 * @property int $id
 * @property string $category_refid
 * @property string $item_foreign_key
 * @property string $item_table_name
 * @property string $item_type
 * @property \Cake\I18n\FrozenTime $date_added
 *
 * @property \App\Model\Entity\Category $category
 */
class CategoryItem extends Entity
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
        'category_refid' => true,
        'item_foreign_key' => true,
        'item_table_name' => true,
        'item_type' => true,
        'date_added' => true,
        'category' => true
    ];
}
