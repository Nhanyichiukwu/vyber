<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Profile Entity
 *
 * @property int $id
 * @property string $user_refid
 * @property string|null $about
 * @property string|null $country_of_origin
 * @property string|null $state_of_origin
 * @property string|null $lga_of_origin
 * @property string|null $hometown
 * @property string|null $country_of_residence
 * @property string|null $state_of_residence
 * @property string|null $lga_of_residence
 * @property string|null $current_city
 * @property string|null $address
 * @property string|null $postcode
 * @property string|null $location
 * @property string|null $website
 * @property string|null $skills
 * @property string|null $languages
 * @property string|null $profile_image_url
 * @property string|null $header_image_url
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\UserGenre[] $user_genres
 * @property \App\Model\Entity\UserIndustry[] $user_industries
 * @property \App\Model\Entity\UserRole[] $user_roles
 */
class Profile extends Entity
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
        'user_refid' => true,
        'about' => true,
        'country_of_origin' => true,
        'state_of_origin' => true,
        'lga_of_origin' => true,
        'hometown' => true,
        'country_of_residence' => true,
        'state_of_residence' => true,
        'lga_of_residence' => true,
        'current_city' => true,
        'address' => true,
        'postcode' => true,
        'location' => true,
        'website' => true,
        'skills' => true,
        'languages' => true,
        'profile_image_url' => true,
        'header_image_url' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'user_genres' => true,
        'user_industries' => true,
        'user_roles' => true,
    ];

    public function getGender()
    {
        return $this->gender;
    }

    public function getCountryOfOrigin()
    {
        return $this->country_of_origin;
    }

    public function getStateOfOrigin()
    {
        return $this->state_of_origin;
    }

    public function getLgaOfOrigin()
    {
        return $this->lga_of_origin;
    }

    public function getCountryOfResidence()
    {
        return $this->country_of_residence;
    }

    public function getStateOfResidence()
    {
        return $this->state_of_residence;
    }

    public function getCityOfResidence()
    {
        return $this->location;
    }

    public function getCurrentCity()
    {
        return $this->current_city;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function getPostcode()
    {
        return $this->postcode;
    }

    public function getWebsiteAddress()
    {
        return $this->website;
    }

    public function getMaritalStatus() {

    }

    public function getBio()
    {
        return $this->about ?? '';
    }

    public function getHometown()
    {
        return $this->hometown;
    }

//
//    public function getCelebrityName()
//    {
//        return $this->stagenaem;
//    }

    public function getNiche()
    {
        return $this->niche;
    }

    public function getRoles() {

        return [];
    }

    public function getImageUrl()
    {
        return $this->profile_image_url;
    }

    public function hasProfileImage() {
        if (empty($this->profile_image_url))
            return false;
        return true;
    }

    public function getHeaderImageUrl()
    {
        return $this->header_image_url;
    }

    public function hasHeaderImage() {
        if (empty($this->header_image_url))
            return false;
        return true;
    }
}
