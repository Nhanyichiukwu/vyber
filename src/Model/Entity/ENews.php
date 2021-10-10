<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ENews Entity
 *
 * @property int $id
 * @property string $refid
 * @property string|null $title
 * @property string $slug
 * @property string|null $body
 * @property string $author_refid
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property string|null $status
 * @property string|null $privacy
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Comment[] $comments
 */
class ENews extends Entity
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
        'title' => true,
        'slug' => true,
        'body' => true,
        'author_refid' => true,
        'created' => true,
        'modified' => true,
        'status' => true,
        'privacy' => true,
        'user' => true,
        'comments' => true
    ];
}
