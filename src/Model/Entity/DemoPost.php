<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DemoPost Entity
 *
 * @property int $id
 * @property string $refid
 * @property string $author_refid
 * @property string $original_author_refid
 * @property string|null $post_text
 * @property string|null $original_post_refid
 * @property string|null $shared_post_refid
 * @property string|null $shared_post_referer
 * @property string|null $attachment_refkey
 * @property string|null $type
 * @property string|resource|null $tags
 * @property string|null $location
 * @property string|null $privacy
 * @property string|null $status
 * @property string|null $year_published
 * @property \Cake\I18n\FrozenTime|null $date_published
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 */
class DemoPost extends Entity
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
        'author_refid' => true,
        'original_author_refid' => true,
        'post_text' => true,
        'original_post_refid' => true,
        'shared_post_refid' => true,
        'shared_post_referer' => true,
        'attachment_refkey' => true,
        'type' => true,
        'tags' => true,
        'location' => true,
        'privacy' => true,
        'status' => true,
        'year_published' => true,
        'date_published' => true,
        'created' => true,
        'modified' => true
    ];
}
