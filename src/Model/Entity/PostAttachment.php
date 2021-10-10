<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PostAttachment Entity
 *
 * @property int $id
 * @property string $post_refid
 * @property string $author_refid
 * @property string $attachment_type
 * @property string|null $attachment_refid
 * @property string|null $file_path
 * @property string $permalink
 * @property string|null $attachment_description
 * @property string|null $attachment_tags
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\EPost $post
 */
class PostAttachment extends Entity
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
        'post_refid' => true,
        'author_refid' => true,
        'attachment_type' => true,
        'attachment_refid' => true,
        'file_path' => true,
        'permalink' => true,
        'attachment_description' => true,
        'attachment_tags' => true,
        'created' => true,
        'modified' => true,
        'post' => true
    ];
}
