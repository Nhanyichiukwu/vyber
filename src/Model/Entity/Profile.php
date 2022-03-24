<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Utility\Text;

/**
 * Profile Entity
 *
 * @property int $id
 * @property string $user_refid
 * @property string|null $gender
 * @property string|null $date_of_birth
 * @property string|null $relationship
 * @property string|null $description
 * @property string|null $bio
 * @property bool|null $is_hall_of_famer
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
        'gender' => true,
        'date_of_birth' => true,
        'relationship' => true,
        'description' => true,
        'bio' => true,
        'is_hall_of_famer' => true,
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
        'industries' => true,
        'roles' => true,
        'genres' => true,
//        'user_genres' => true,
//        'user_industries' => true,
//        'user_roles' => true,
    ];

    public function getGender()
    {
        return $this->gender;
    }

    public function getGenderAdjective()
    {
        return $this->getGender() === 'male' ? 'his' : 'her';
    }

    /**
     * User date of birth
     * @return string|null
     */
    public function getDOB()
    {
        return $this->date_of_birth;
    }

    /**
     * Calculates and returns a user's age based on their birth date
     *
     * @return \DateInterval|int|false
     * @throws \Exception
     */
    public function getAge($option = null)
    {
        $birthDay = new \DateTime(
            (string) $this->getDOB()
        );
        $today = new \DateTime(
            (string) date("Y-m-d")
        );
        $dateDiff = $today->diff($birthDay);

        if ($option && property_exists($dateDiff, $option)) {
            return (int) $dateDiff->$option;
        }
        return $dateDiff;
    }

    public function getRelationship() {
        return $this->relationship;
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

    public function getDescription()
    {
        return $this->description;
    }

    public function getBio()
    {
        return $this->bio;
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

    public function getIndustries()
    {
        return (array) $this->get('industries');
    }

    public function getIndustriesAsString($glue = '&')
    {
        $string = collection($this->getIndustries())->extract('name')->toArray();
        return Text::toList($string, $glue);
    }

    public function getRoles()
    {
        return (array) $this->get('roles');
    }

    public function getRolesAsString($glue = '&')
    {
        $string = collection($this->getRoles())->extract('name')->toArray();
        return Text::toList($string, $glue);
    }

    public function getGenres()
    {
        return (array) $this->get('genres');
    }

    public function getGenresAsString($glue = '&')
    {
        $string = collection($this->getGenres())->extract('name')->toArray();
        return Text::toList($string, $glue);
    }

    public function getImageUrl()
    {
        return $this->profile_image_url;
    }

    public function hasProfileImage() {
        if (empty($this->profile_image_url)) {
            return false;
        }
        return true;
    }

    public function getHeaderImageUrl()
    {
        return $this->header_image_url;
    }

    public function hasHeaderImage() {
        if (empty($this->header_image_url)) {
            return false;
        }
        return true;
    }
}
