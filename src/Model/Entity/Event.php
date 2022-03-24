<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Events Entity
 *
 * @property int $id
 * @property string $refid
 * @property string $title
 * @property string|null $description
 * @property int|null $event_type_id
 * @property string|null $privacy
 * @property string|null $media
 * @property string $user_refid
 * @property string $hostname
 * @property string|null $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\EventType $event_type
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
        'id' => true,
        'refid' => true,
        'title' => true,
        'description' => true,
        'event_type_id' => true,
        'privacy' => true,
        'media' => true,
        'user_refid' => true,
        'hostname' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'event_type' => true,
        'guests' => true,
    ];
}
