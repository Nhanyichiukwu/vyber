<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProfilesEducation Entity
 *
 * @property int $profile_id
 * @property string $institution
 * @property string $course
 * @property string $degree
 * @property string|null $description
 * @property \Cake\I18n\FrozenDate $start_date
 * @property \Cake\I18n\FrozenDate $end_date
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Profile $profile
 */
class ProfilesEducation extends Entity
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
        'profile_id' => true,
        'institution' => true,
        'course' => true,
        'degree' => true,
        'description' => true,
        'start_date' => true,
        'end_date' => true,
        'created' => true,
        'modified' => true,
        'profile' => true,
    ];
}
