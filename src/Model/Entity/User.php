<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\Collection\Collection;
use Cake\ORM\Entity;
use Cake\ORM\Locator\TableLocator;

/**
 * User Entity
 *
 * @property int $id
 * @property string $refid
 * @property string $firstname
 * @property string|null $othernames
 * @property string $lastname
 * @property string $username
 * @property string $password
 * @property array|null $emails
 * @property array|null $phones
 * @property Profile|null $profile
 * @property array|null $connections
 * @property array|null $posts
 * @property array|null $photos
 * @property array|null $videos
 * @property string|null $gender
 * @property string|null $date_of_birth
 * @property string|null $account_type
 * @property string|null $account_status
 * @property bool|null $activated
 * @property bool|null $is_hall_of_famer
 * @property string|null $time_zone
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 */
class User extends Entity
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
        'firstname' => true,
        'othernames' => true,
        'lastname' => true,
        'username' => true,
        'password' => true,
        'profile' => true,
        'emails' => true,
        'phones' => true,
        'photos' => true,
        'videos' => true,
        'gender' => true,
        'date_of_birth' => true,
        'account_type' => true,
        'account_status' => true,
        'activated' => true,
        'is_hall_of_famer' => true,
        'time_zone' => true,
        'created' => true,
        'modified' => true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password',
    ];

    public function getGenderAdjective()
    {
        return $this->getGender() === 'male' ? 'his' : 'her';
    }

    protected function _setPassword($password) {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher)->hash($password);
        }
    }

    public function getFullname()
    {
        $names = array_filter([$this->getFirstName(), $this->getOthernames(), $this->getLastName()]);
        $fullname =  implode(' ', $names);

        return $fullname;
    }

    public function getFirstName()
    {
        return $this->firstname;
    }

    public function getLastName()
    {
        return $this->lastname;
    }

    public function getOthernames()
    {
        return $this->othernames;
    }

    public function getNameAccronym()
    {
        $firstName = substr($this->getFirstName(), 0, 1);
        $middleName = substr($this->getOthernames(), 0, 1);
        $lastName = substr($this->getLastName(), 0, 1);

        $accronym = implode('', array_filter([$firstName, $middleName, $lastName]));

        return $accronym;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function getPrimaryPhone() {
        return '';
    }

    public function getGender() {
        return $this->gender;
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

    public function getMaritalStatus() {
        return null;
    }

    public function getAccountType()
    {
        return $this->account_type;
    }

    public function getEmailAddress()
    {
        return $this->email;
    }

    public function getPrimaryEmail() {
        return '';
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getJoinDate()
    {
        return $this->created;
    }

    /**
     *
     * @param \App\Model\Entity\User $user
     * @return boolean
     */
    public function isConnectedTo(User $user)
    {
        if (in_array($user->refid, $this->extractConnectionsIDs())) {
            return true;
        }

        return false;
    }

    /**
     * Extract the IDs of a user's connections
     *
     * @return array
     */
    public function extractConnectionsIDs() {
        $connections = (array) $this->get('connections');
        return collection($connections)->extract(
            function (Connection $row) {
                return $row->correspondent_refid;
            }
        )
            ->toList();
    }

    public function extractConnectionsCorrespondents() {
        $correspondents = [];
        $connections = $this->get('connections');
        if (count($connections)) {
            $correspondents = \collection($connections)->extract(
                function ($row) {
                    return $row->correspondent;
                }
            )
                ->toArray();
        }

        return $correspondents;
    }

    public function isSameAs($user)
    {
        $class = get_class();
        if (! $user instanceof $class) {
            return false;
        }
        if ($user->get('refid') === $this->get('refid')) {
            return true;
        }
        return false;
    }

    public function isActivated()
    {
        return (bool) $this->activated;
    }

    public function isAHallOfFamer() {
        return (bool) $this->is_hall_of_famer;
    }

    public function hasPhotos() {
        if ($this->has('photos')) {
            return $this->hasValue($this->get('photos'));
        }

//        $photosTbl = (new TableLocator())->get('Photos');
//        $photos = $photosTbl->findByAuthorRefid($this->refid)->toArray();
//
//        if (count($photos)) {
//            return true;
//        }
        return false;
    }

//    public function setConnections($connections)
//    {
//        $this->connections = $connections;
//    }

//    public function getConnections()
//    {
//        return $this->connections;
//    }

    /**
     * Get the total number of connections the user has
     *
     * @return int
     */
    public function connectionsCount() {
        $count = (int) count($this->get('connections') ?? []);

        return $count;
    }

//    public function getFollowers() {
//        return (array) $this->get('followers');
//    }

    /**
     * Get the total number of followers the user has
     *
     * @return int
     */
    public function followersCount() {
        $count = (int) count($this->get('followers') ?? []);

        return $count;
    }
//
//
//
//    public function getFollowings() {
//        return (array) $this->get('followings');
//    }

    /**
     * Get the total number of people this user is following
     *
     * @return int
     */
    public function followingsCount() {
        $count = (int) count($this->get('followings') ?? []);

        return $count;
    }


//    public function getPosts() {
//        return (array) $this->get('posts');
//    }

    /**
     * Get the total number of posts this user has posted, since account creation,
     * including posts containing videos, audio, photos, award, nominations etc.
     *
     * @return int
     */
    public function postsCount()
    {
        if ($this->isEmpty('posts')) {
            return 0;
        }

        $postsAndComments = (array) $this->get('posts');
        $collection = new Collection($postsAndComments);
        $postsOnly = $collection->match(['replying_to' => '']);

        return $postsOnly->count();
    }

    /**
     * Tells a user's preference on whether or not their current location
     * when posting, should be tracked and/or shown on the post.
     *
     * @return bool
     */
    public function allowsLocationOnPosts()
    {
        $preferences = (array) $this->get('preferences');
        if (!count($preferences)) {
            return false;
        }

        $allowPostLocation = (new Collection($preferences))->firstMatch([
            'option' => 'location',
            'preference' => 1
        ]);

        return $allowPostLocation === null;
    }

    /**
     * Check whether this user has an unconfirmed connection invitation
     * from the user given in the argument;
     *
     * @param User $user
     * @return bool
     */
    public function hasPendingInvitation(User $user): bool
    {
        if (
            !$this->has('received_requests') ||
            !$this->hasValue('received_requests')
        ) {
            return false;
        }
        $check = (new Collection($this->received_requests))->filter(
            function ($request, $index) use($user) {
                return $request->type === 'connection' && $request->sender_refid === $user->refid;
            }
        )
            ->toList();

        if (count($check)) {
            return true;
        }
        return false;
    }
}
