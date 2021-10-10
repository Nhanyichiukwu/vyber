<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Chat Entity
 *
 * @property int $id
 * @property string $refid
 * @property string|null $title
 * @property string|null $slug
 * @property string|null $description
 * @property string $initiator_refid
 * @property \Cake\I18n\FrozenTime $start_time
 * @property \Cake\I18n\FrozenTime|null $last_active_time
 * @property string|null $last_active_participant_refid
 * @property string $chattype
 * @property string|null $avatar
 * @property string|null $group_accessibility
 * @property string|null $group_scalability
 * @property int|null $max_participants
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\User $initiator
 * @property \App\Model\Entity\Message[] $messages
 * @property \App\Model\Entity\ChatParticipant[] $participants
 * @property \App\Model\Entity\User $lastActiveParticipant
 * @property \App\Model\Entity\Message $mostRecentMessage
 */
class Chat extends Entity
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
        'refid' => true,
        'title' => true,
        'slug' => true,
        'description' => true,
        'initiator_refid' => true,
        'start_time' => true,
        'last_active_time' => true,
        'last_active_participant_refid' => true,
        'chattype' => true,
        'avatar' => true,
        'group_accessibility' => true,
        'group_scalability' => true,
        'max_participants' => true,
        'created' => true,
        'modified' => true,
        'initiator' => true,
        'messages' => true,
        'participants' => true,
        'lastActiveParticipant' => true,
        'mostRecentMessage' => true
    ];
}
