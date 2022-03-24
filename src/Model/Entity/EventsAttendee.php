<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EventsAttendee Entity
 *
 * @property int $id
 * @property string $event_refid
 * @property string $attendee_refid
 * @property string|null $invited_by
 * @property \Cake\I18n\FrozenTime|null $date_invited
 * @property bool|null $event_seen
 * @property \Cake\I18n\FrozenTime|null $date_seen
 * @property \Cake\I18n\FrozenTime|null $invite_response_date
 * @property string|null $response
 */
class EventsAttendee extends Entity
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
        'attendee_refid' => true,
        'invited_by' => true,
        'date_invited' => true,
        'event_seen' => true,
        'date_seen' => true,
        'invite_response_date' => true,
        'response' => true
    ];
}
