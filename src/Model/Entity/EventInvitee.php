<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EventInvitee Entity
 *
 * @property int $id
 * @property string $event_refid
 * @property int $event_venue_id
 * @property string $invitee_refid
 * @property string|null $inviter_refid
 * @property \Cake\I18n\FrozenTime|null $date_invited
 * @property bool|null $event_seen
 * @property \Cake\I18n\FrozenTime|null $date_seen
 * @property \Cake\I18n\FrozenTime|null $invite_response_date
 * @property string|null $response
 * @property string $event_status
 *
 * @property \App\Model\Entity\Event $event
 * @property \App\Model\Entity\User $user
 */
class EventInvitee extends Entity
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
        'event_refid' => true,
        'event_venue_id' => true,
        'invitee_refid' => true,
        'inviter_refid' => true,
        'date_invited' => true,
        'event_seen' => true,
        'date_seen' => true,
        'invite_response_date' => true,
        'response' => true,
        'event_status' => true,
        'event' => true,
        'user' => true
    ];
}
