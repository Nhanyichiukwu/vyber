<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Event Entity
 *
 * @property int $id
 * @property string $refid
 * @property string $title
 * @property string|null $description
 * @property int|null $event_type_id
 * @property string|null $privacy
 * @property string|resource|null $image
 * @property string $user_refid
 * @property string $host_name
 * @property string|null $status
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\EventVenue[] $venues
 * @property \App\Model\Entity\Guest[] $guests
 */
class Event extends Entity
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
        'description' => true,
        'event_type_id' => true,
        'privacy' => true,
        'image' => true,
        'user_refid' => true,
        'host_name' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'venues' => true,
        'guests' => true
    ];
}
