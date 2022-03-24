<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EventVenue Entity
 *
 * @property int $id
 * @property string $event_refid
 * @property string $title
 * @property string $description
 * @property string|resource|null $media
 * @property string $country_region
 * @property string $state_province
 * @property string $city
 * @property string $address
// * @property \Cake\I18n\FrozenTime $start_date
// * @property \Cake\I18n\FrozenTime $end_date
 * @property string|null $status
 *
 * @property \App\Model\Entity\EventGuest[] $event_guests
 * @property \App\Model\Entity\EventInvitee[] $event_invitees
 */
class EventVenue extends Entity
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
        'event_refid' => true,
        'title' => true,
        'description' => true,
        'media' => true,
        'country_region' => true,
        'state_province' => true,
        'city' => true,
        'address' => true,
//        'start_date' => true,
//        'end_date' => true,
        'status' => true,
        'event_guests' => true,
        'event_invitees' => true,
        'dates' => true,
    ];
}
