<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Guest Entity
 *
 * @property int $id
 * @property string|null $registered_user_refid
 * @property string $ip
 * @property string $device
 * @property string $browser
 * @property string|null $os
 * @property string|null $city
 * @property string|null $state
 * @property string|null $region
 * @property string|null $country
 * @property string|null $country_code
 * @property string|null $continent
 * @property string|null $continent_code
 * @property string|null $currency_symbol
 * @property string|null $currency_code
 * @property float|null $currencey_converter
 * @property string|null $timezone
 * @property string|null $longitude
 * @property string|null $latitude
 * @property \Cake\I18n\FrozenTime|null $last_visit
 */
class Guest extends Entity
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
        'registered_user_refid' => true,
        'ip' => true,
        'device' => true,
        'browser' => true,
        'os' => true,
        'city' => true,
        'state' => true,
        'region' => true,
        'country' => true,
        'country_code' => true,
        'continent' => true,
        'continent_code' => true,
        'currency_symbol' => true,
        'currency_code' => true,
        'currencey_converter' => true,
        'timezone' => true,
        'longitude' => true,
        'latitude' => true,
        'last_visit' => true,
    ];
}
