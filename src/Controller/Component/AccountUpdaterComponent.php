<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Utility\Text;
use Cake\Validation\Validation;

/**
 * AccountUpdater component
 *
 * @property \App\Model\Entity\Users $Users The Users Model Entity Class
 * @property \App\Model\Entity\Contacts $Contacts The Contacts Entity Class
 * @property \App\Model\Entity\Achievements $Achievements Description
 * @property \App\Model\Entity\Awards $Awards Description
 * @property \App\Model\Entity\Nominations $Nominations Description
 *
 */
class AccountUpdaterComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    protected $_message;


    /**
     * @var
     */

    /**
     *
     * @var \App\Model\Entity\User
     */
    private $__user;

    /**
     *
     * @var array list of components used by this component
     */
    public $components = ['Flash','CustomString'];

    /**
     *
     * @param array $config
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $tableLocator = $this->getController()->getTableLocator();
        $this->Users = $tableLocator->get('Users');
        $this->Contacts = $tableLocator->get('Contacts');
        $this->Achievements = $tableLocator->get('Achievements');
        $this->Awards = $tableLocator->get('Awards');
        $this->Nominations = $tableLocator->get('Nominations');

        if (!$this->__user) {
            $this->__user = $this->getController()->getActiveUser();
        }
    }

    public function editName()
    {
        $controller = $this->getController();
        $request = $controller->getRequest();

        $user = $this->Users->get($this->__user->refid);
        $firstname = $request->getData('firstname');
        $lastname = $request->getData('lastname');
        $othernames = $request->getData('othernames');

        if (
                $firstname === $user->firstname &&
                $lastname === $user->lastname &&
                $othernames === $user->othernames
        )
        {
            $this->_message = 'No changes made!';
            return true;
        }
        else
        {
            if (
                Validation::containsNonAlphaNumeric($firstname) ||
                Validation::containsNonAlphaNumeric($lastname) ||
                Validation::custom($othernames, '[a-zA-Z ]')
            )
            {
                $this->Flash->error(__('Sorry, one or more of your fields contain(s) invalid charcters'));
            }
            elseif (
                Validation::minLength($firstname, 2) &&
                Validation::minLength($lastname, 2)
            )
            {
                $data = [
                    'firstname' => $firstname,
                    'othernames' => $othernames,
                    'lastname' => $lastname
                ];
                $user = $this->Users->patchEntity($user, $data);

                if ($this->Users->save($user))
                {
                    $this->_message = 'Name updated successfully!';
                    return true;
                }
                else
                {
                    $this->_message = 'Sorry, we unable to udate your name at the moment. Please try again!';
                    return false;
                }
            }
            else
            {
                $this->_message = 'Sorry, one or more of your fields is lesser than one (1) charcter long';
                return false;
            }
        }
    }

    public function editContacts()
    {
        $controller = $this->getController();
        $request = $controller->getRequest();

        $user = $this->Users->get($this->__user->refid);
        $contacts = $this->Contacts->find('all', ['user_refid' => $this->__user->refid]);
        $newContacts = $request->getData('contacts');
    }

    public function editBasicInfo()
    {
        $controller = $this->getController();
        $request = $controller->getRequest();

        $user = $this->Users->get($this->__user->refid);

        $gender = $request->getData('gender');
        $dob = (array) $request->getData('date_of_birth');
        $dateOfBirth = implode('-', array_values($dob));
        $origin = (array) $request->getData('origin');
        $country = $origin['country'];
        $state = $origin['state'];
        $lga = $origin['lga'];
        $city = $origin['city'];
        $hometown = $origin['hometown'];
        $address = $origin['address'];
        $postcode = $origin['postcode'];

        $data = [
            'gender' => $gender,
            'date_of_birth' => $dateOfBirth,
            'country_of_origin' => $country,
            'state_of_origi' => $state,
            'lga_of_origin' => $lga,
            'city' => $city,
            'hometown' => $hometown,
            'address' => $address,
            'postcode' => $postcode
        ];

        array_walk($data, function (&$value, $key) {
            if (!empty($value)) {
//                if ()
//                $value = Validation::
            }
        });
        $user = $this->Users->patchEntity($user, $data);
        if ($this->Users->save($user)) {
            $this->_message = 'Profile updated successfully';
            return true;
        } else {
            $this->_message = 'Profile update failed Please again.';
            return false;
        }
    }

    /**
     * Handles the edit operation for user bio
     *
     * @return boolean
     */
    public function editBio()
    {
        $controller = $this->getController();
        $request = $controller->getRequest();

        $user = $this->Users->get($this->__user->refid);
        $about = $request->getData('about');
        //  && ! Validation::maxLength($about, 160)
        if (
                $about !== $user->about
        )
        {
            if (Validation::maxLength($about, 160) )
            {
                $data = [
                    'about' => $about
                ];

                $user = $this->Users->patchEntity($user, $data);

                if ($this->Users->save($user)) {
                    $this->_message = 'Your bio updated successfully!';
                    return true;
                } else {
                    $this->_message ='Sorry, we unable to udate your name at the moment. Please try again!';
                    return false;
                }
            }
            else
            {
                $this->_message = 'Sorry, your bio must not be more than 160 charcters long!';
                return false;
            }
        }
        else
        {
            $this->_message = 'No Changes Made';
        }
    }

    public function updateProfile()
    {
        $controller = $this->getController();
        $request = $controller->getRequest();

        $user = $this->Users->get($this->__user->refid);
        if (!$user->get('profile')) {
            $user->profile = $this->Users->Profiles->newEntity();
        }

        $firstname = $request->getData('firstname');
        $lastname = $request->getData('lastname');
        $othernames = $request->getData('othernames');

        if (
            Validation::containsNonAlphaNumeric($firstname) ||
            Validation::containsNonAlphaNumeric($lastname) ||
            Validation::custom($othernames, '[a-zA-Z ]')
        )
        {
            $this->_message = 'Sorry, one or more of your name fields contain(s) invalid charcters';
            return false;
        }
        elseif (
            ! Validation::minLength($firstname, 2) ||
            ! Validation::minLength($lastname, 2)
        )
        {
            $this->_message = 'Sorry, names must not be lesser than (2) charcter long';
            return false;
        }

        $about = $request->getData('about');
        if (! Validation::maxLength($about, 160) )
        {
            $this->_message = 'Sorry, your bio must not be more than 160 charcters long!';
            return false;
        }

        $gender = $request->getData('gender');
        $dob = (array) $request->getData('date_of_birth');
        $dateOfBirth = implode('-', array_values($dob));
        $origin = (array) $request->getData('origin');
        $country = $origin['country'] ?? null;
        $state = $origin['state'] ?? null;
        $lga = $origin['lga'] ?? null;
        $city = $origin['city'] ?? null;
        $hometown = $origin['hometown'] ?? null;
        $address = $origin['address'] ?? null;
        $postcode = $origin['postcode'] ?? null;

        $data = [
            'firstname' => $firstname,
            'othernames' => $othernames,
            'lastname' => $lastname,
            'gender' => $gender
        ];
        $profile = [
            'user_refid' => $user->get('refid'),
            'about' => $about,
            'date_of_birth' => $dateOfBirth,
            'country_of_origin' => $country,
            'state_of_origin' => $state,
            'lga_of_origin' => $lga,
            'city' => $city,
            'hometown' => $hometown,
            'address' => $address,
            'postcode' => $postcode
        ];
        $user = $this->Users->patchEntity($user, $data);
        $user->profile = $this->Users->Profiles->patchEntity($user->profile, $profile);

//        print_r($user);
//        exit;
        if ($this->Users->save($user)) {
            $this->_message = 'Profile updated successfully';
            return true;
        } else {
            $this->_message = 'Profile update failed Please try again.';
            return false;
        }
    }


    public function getLastMessage()
    {
        return $this->_message;
    }
}
