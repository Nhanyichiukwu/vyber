<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Post Entity
 *
 * @property int $id
 * @property string $refid
 * @property string $author_refid
 * @property string $original_author_refid
 * @property string $type
 * @property string|null $replying_to
 * @property string|null $parent_type
 * @property string|null $post_text
 * @property string|null $copied
 * @property string|null $copied_as
 * @property string|null $original_post_refid
 * @property string|null $shared_post_refid
 * @property string|null $shared_post_referer
 * @property string|null $tags
 * @property string|null $location
 * @property string|null $privacy
 * @property string|null $status
 * @property \Cake\I18n\FrozenTime|null $date_published
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\User $e_user
 */
class Post extends Entity
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
        'original_author_refid' => true,
        'type' => true,
        'replying_to' => true,
        'parent_type' => true,
        'post_text' => true,
        'copied' => true,
        'copied_as' => true,
        'original_post_refid' => true,
        'shared_post_refid' => true,
        'shared_post_referer' => true,
        'tags' => true,
        'location' => true,
        'privacy' => true,
        'status' => true,
        'date_published' => true,
        'created' => true,
        'modified' => true,
        'author' => true,
        'originalAuthor' => true,
        'originalPost' => true,
        'sharedPost' => true,
        'attachments' => true
    ];

    public function hasAttachments()
    {
        if ($this->isEmpty('attachments')) {
            return false;
        }

        return true;
    }

    public function hasReactionFromUser($user_refid)
    {
        if ($this->isEmpty('reactions')) {
            return false;
        }
        $postReactions = $this->get('reactions');
        $userIds = [];
        array_walk(function ($reaction, $index, &$ids) {
            $ids[] = $reaction->get('reactor_refid');
            
        }, $postReactions, $userIds);

        if (in_array($user_refid, $userIds)) {
            return true;
        }

        return false;
    }
    
    public function isCoppied() {
        return (bool) ((int) $this->copied === 1);
    }
    
    public function getLocation() {
        return $this->get('location');
    }
    
    public function getBody() {
        return $this->get('post_text');
    }
    
    public function getAttachments() {
        return $this->get('attachments');
    }
}
