<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Comment Entity
 *
 * @property int $id
 * @property string $refid
 * @property string $author_refid
 * @property string $post_refid
 * @property string|null $in_reply_to
 * @property string|null $text
 * @property string|null $has_attachment
 * @property string|resource|null $attachments
 * @property string|null $type
 * @property string|resource|null $tags
 * @property string|null $location
 * @property string|null $privacy
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Post $post
 */
class Comment extends Entity
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
        'refid' => true,
        'author_refid' => true,
        'post_refid' => true,
        'in_reply_to' => true,
        'text' => true,
        'has_attachment' => true,
        'attachments' => true,
        'type' => true,
        'tags' => true,
        'location' => true,
        'privacy' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'author' => true,
        'post' => true
    ];
    
        
    public function hasAttachment()
    {
        if (!empty($this->attachment_refkey)) {
            return true;
        }
        
        return false;
    }
}
