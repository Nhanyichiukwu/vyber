<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ChatParticipant Entity
 *
 * @property int $id
 * @property string $chat_refid
 * @property string $participant_refid
 * @property string|null $added_by
 * @property \Cake\I18n\FrozenTime|null $date_added
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property bool|null $is_admin
 * @property bool|null $previously_engaged_in
 *
 * @property \App\Model\Entity\User $participant
 * @property \App\Model\Entity\Chat $chat
 */
class ChatParticipant extends Entity
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
        'chat_refid' => true,
        'participant_refid' => true,
        'added_by' => true,
        'date_added' => true,
        'created' => true,
        'modified' => true,
        'is_admin' => true,
        'previously_engaged_in' => true,
        'participant' => true,
        'chat' => true
    ];
}
