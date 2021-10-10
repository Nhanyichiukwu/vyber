<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * UsersRating Entity
 *
 * @property int $id
 * @property string $user_refid
 * @property string $actor_refid
 * @property bool $rating
 * @property string|null $review
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 */
class UsersRating extends Entity
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
        'actor_refid' => true,
        'rating' => true,
        'review' => true,
        'created' => true,
        'modified' => true,
    ];
}
