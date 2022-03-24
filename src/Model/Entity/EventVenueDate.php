<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EventVenueDate Entity
 *
 * @property int $id
 * @property int $event_venue_id
 * @property \Cake\I18n\FrozenDate $day
 * @property \Cake\I18n\FrozenTime $starts_at
 * @property \Cake\I18n\FrozenTime $ends_at
 * @property string|null $detail
 *
 * @property \App\Model\Entity\EventVenue $event_venue
 */
class EventVenueDate extends Entity
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
        'event_venue_id' => true,
        'day' => true,
        'starts_at' => true,
        'ends_at' => true,
        'detail' => true,
        'event_venue' => true,
    ];
}
