<?php
namespace App\Controller\Component;

use App\Model\Entity\Genre;
use App\Model\Entity\Industry;
use App\Model\Entity\Role;
use App\Utility\CustomString;
use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Locator\TableLocator;
use Cake\Utility\Text;
use Cake\Validation\Validation;
use Cake\Http\ServerRequest as Request;
use http\Client\Response;

/**
 * AccountUpdater component
 *
 * @property \App\Model\Table\UsersTable $Users The Users Model Entity Class
 * @property \App\Model\Table\ContactsTable $Contacts The Contacts Entity Class
 * @property \App\Model\Table\AchievementsTable $Achievements Description
 * @property \App\Model\Table\AwardsTable $Awards Description
 * @property \App\Model\Table\NominationsTable $Nominations Description
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
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $tableLocator = new TableLocator();
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
                Validation::notAlphaNumeric($firstname) ||
                Validation::notAlphaNumeric($lastname) ||
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

    public function updateBasicInfo(Request $request)
    {
        $controller = $this->getController();

        $user = $this->Users->get($this->__user->refid, [
            'contain' => [
                'Profiles' => [
                    'Roles'
                ]
            ]
        ]);

        /**
         * Assuming the user has no profile record already, we create a new
         * profile entity. However, this is a rare case, as each user given a
         * profile upon account creation.
         */
        if ($user->isEmpty('profile')) {
            $user->profile = $this->Users->Profiles->newEmptyEntity();
        }

        $firstname = $request->getData('firstname');
        $lastname = $request->getData('lastname');
        $othernames = $request->getData('othernames');

        if (
            Validation::notAlphaNumeric($firstname) ||
            Validation::notAlphaNumeric($lastname) ||
            Validation::custom($othernames, '[a-zA-Z ]')
        )
        {
            $this->_message = 'Sorry, one or more of your name fields contain(s) invalid charcters';
            return false;
        } elseif (
            !Validation::minLength($firstname, 2) ||
            !Validation::minLength($lastname, 2)
        ) {
            $this->_message = 'Sorry, names must not be lesser than (2) charcter long';
            return false;
        }

        $description = $request->getData('profile.description');
        if (Validation::minLength($description, 180) ) {
            $this->_message = 'Sorry, your description cannot be more than 180 charcters long!';
            return false;
        }
        $bio = $request->getData('profile.bio');
        if (Validation::minLength($bio, 2000) ) {
            $this->_message = 'Sorry, your bio cannot be more than 2000 charcters long!';
            return false;
        }

        $gender = $request->getData('profile.gender');

        $data = [
            'firstname' => $firstname,
            'othernames' => $othernames,
            'lastname' => $lastname,
            'profile' => [
                'user_refid' => $user->get('refid'),
                'gender' => $gender,
                'description' => $description,
                'bio' => $bio
            ]
        ];

        $user = $this->Users->patchEntity($user, $data);

        if ($this->Users->save($user)) {
            $this->_message = 'Profile updated successfully';
            return true;
        } else {
            $this->_message = 'Profile update failed Please try again.';
            return false;
        }
    }

    public function updateBirthDate(Request $request)
    {
        $user = $this->Users->get($this->__user->refid, [
            'contain' => [
                'Profiles'
            ]
        ]);

        $dateOfBirth = $request->getData('profile.date_of_birth');
        if (is_array($dateOfBirth)) {
            $dateOfBirth = implode('-', array_values($dateOfBirth));
        }

        $data = [
            'profile' => [
                'date_of_birth' => $dateOfBirth
            ]
        ];

        $user = $this->Users->patchEntity($user, $data);

        if ($this->Users->save($user)) {
            $this->_message = 'Profile updated successfully';
            return true;
        } else {
            $this->_message = 'Oops! Something went wrong. Your birth date ' .
                'could not be updated at the moment. Please try again.';
            return false;
        }
    }

    public function updateAddress(array $postData)
    {
        $controller = $this->getController();


    }

    /**
     * @param Request $request
     * @return bool
     */
    public function updateIndustry(Request $request)
    {
        $user = $this->Users->get($this->__user->refid, [
            'contain' => [
                'Profiles' => [
                    'Industries',
                    'Roles',
                    'Genres'
                ]
            ]
        ]);

        $ProfilesTable = (new TableLocator())->get('Profiles');
        /**
         * Retrieving post data and verifying their existence
         */
        /********* Industries **********/
        $industriesNames = $request->getData('profile.industries');
        $industriesNamesArray = explode(',', $industriesNames);
        $industriesNamesArray = array_filter($industriesNamesArray);
        $industries = collection($industriesNamesArray)->map(
            function ($industryName) use($ProfilesTable) {
                return $ProfilesTable->Industries->findByName($industryName)->first();
            }
        )
            ->toArray();

        /********** Roles ************/
        $rolesNames = $request->getData('profile.roles');
        $rolesNamesArray = explode(',', $rolesNames);
        $rolesNamesArray = array_filter($rolesNamesArray);
        $roles = collection($rolesNamesArray)->map(
            function ($roleName) use ($ProfilesTable) {
                return $ProfilesTable->Roles->findByName($roleName)->first();
            }
        )
            ->toArray();

        /********** Genres **********/
        $genresNames = $request->getData('profile.genres');
        $genresNamesArray = explode(',', $genresNames);
        $genresNamesArray = array_filter($genresNamesArray);
        $genres = collection($genresNamesArray)->map(
            function ($genreName) use ($ProfilesTable) {
                return $ProfilesTable->Genres->findByName($genreName)->first();
            }
        )
            ->toArray();

        /********* Saving Data ************/
        $ProfileIndustries = (new TableLocator())->get('ProfilesIndustries');
        $ids = collection($industries)->map(function (Industry $industry) {
            return $industry->id;
        })->toArray();
        $ids = array_filter($ids);
        if (count($ids)) {
            $ProfileIndustries->deleteAll([
                'profile_id' => $user->profile->id,
                'industry_id NOT IN' => $ids
            ]);
            foreach ($industries as $industry) {
                if ($ProfileIndustries->exists([
                    'profile_id' => $user->profile->id,
                    'industry_id' => $industry->id
                ])) {
                    continue;
                }
                $profileIndustry = $ProfileIndustries->newEntity([
                    'profile_id' => $user->profile->id,
                    'industry_id' => $industry->id
                ]);
                if (!$ProfileIndustries->save($profileIndustry)) {
                    $this->_message = 'Oops! We are having issues updating your ' .
                        'profile at the moment. Please try again.';
                    return false;
                }
            }
        } else {
            $ProfileIndustries->deleteAll([
                'profile_id' => $user->profile->id
            ]);
        }

        unset($ProfileIndustries);
        unset($industries);
        unset($ids);

        $ProfileRoles = (new TableLocator())->get('ProfilesRoles');
        $ids = collection($roles)->map(function (Role $role) {
            return $role->id;
        })->toArray();
        if (count($ids)) {
            $ProfileRoles->deleteAll([
                'profile_id' => $user->profile->id,
                'role_id NOT IN' => $ids
            ]);

            foreach ($roles as $role) {
                if ($ProfileRoles->exists([
                    'profile_id' => $user->profile->id,
                    'role_id' => $role->id
                ])) {
                    continue;
                }
                $profileRole = $ProfileRoles->newEntity([
                    'profile_id' => $user->profile->id,
                    'role_id' => $role->id
                ]);
                if (!$ProfileRoles->save($profileRole)) {
                    $this->_message = 'Oops! We are having issues updating your ' .
                        'profile at the moment. Please try again.';
                    return false;
                }
            }
        } else {
            $ProfileRoles->deleteAll([
                'profile_id' => $user->profile->id
            ]);
        }
        unset($ProfileRoles);
        unset($roles);
        unset($ids);

        $ProfileGenres = (new TableLocator())->get('ProfilesGenres');
        $ids = collection($genres)->map(function (Genre $genre) {
            return $genre->id;
        })->toArray();
        if (count($ids)) {
            $ProfileGenres->deleteAll([
                'profile_id' => $user->profile->id,
                'genre_id NOT IN' => $ids
            ]);

            foreach ($genres as $genre) {
                if ($ProfileGenres->exists([
                    'profile_id' => $user->profile->id,
                    'genre_id' => $genre->id
                ])) {
                    continue;
                }
                $profileGenre = $ProfileGenres->newEntity([
                    'profile_id' => $user->profile->id,
                    'genre_id' => $genre->id
                ]);
                if (!$ProfileGenres->save($profileGenre)) {
                    $this->_message = 'Oops! We are having issues updating your ' .
                        'profile at the moment. Please try again.';
                    return false;
                }
            }
        } else {
            $ProfileGenres->deleteAll([
                'profile_id' => $user->profile->id
            ]);
        }

        unset($ProfileGenres);
        unset($genres);
        unset($ids);

        $this->_message = 'Profile updated successfully.';
        return true;
    }

    public function updateBackground(Request $request)
    {
        $user = $this->Users->get($this->__user->refid, [
            'contain' => [
                'Profiles'
            ]
        ]);
        $postData = $request->getData('profile');


        if (array_key_exists('languages', $postData)) {
            $this->updateLanguages($request);
            unset($postData['languages']);
        }

        $profileData = collection($postData)->map(function ($item) {
            return CustomString::sanitize($item);
        })->toArray();

        $data = [
            'profile' => $profileData
        ];

        $user = $this->Users->patchEntity($user, $data);
        if ($this->Users->save($user)) {
            $this->_message = 'Profile updated successfully';
            return true;
        } else {
            $this->_message = 'Profile update failed Please try again.';
            return false;
        }
    }

    public function updateResidentialInfo(Request $request)
    {
        $user = $this->Users->get($this->__user->refid, [
            'contain' => [
                'Profiles'
            ]
        ]);
        $postData = $request->getData('profile');
        $profileData = collection($postData)->map(function ($item) {
            return CustomString::sanitize($item);
        })->toArray();

        $data = [
            'profile' => $profileData
        ];

        $user = $this->Users->patchEntity($user, $data);
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

    /**
     * @param Request $request
     * @return \Cake\Http\Response|null
     */
    public function updateLanguages(Request $request)
    {
        $user = $this->Users->get($this->__user->refid, [
            'contain' => [
                'Profiles' => [
                    'Languages',
                    'Educations',
                ]
            ]
        ]);
        $postData = $request->getData('profile.languages');
        $languages = array_map(function ($row) {
            $row['language'] = CustomString::sanitize($row['language']);
            $row['proficiency'] = CustomString::sanitize($row['proficiency']);
            return $row;
        }, $postData);
        $languageNamesSlug = array_map(function ($row) {
            return Text::slug($row['language']);
        }, $languages);


        $ProfileLanguages = (new TableLocator())->get('ProfilesLanguages');
//        $ids = collection($languages)->map(function (Language $language) {
//            return $language->id;
//        })->toArray();
        if (count($languageNamesSlug)) {
            $ProfileLanguages->deleteAll([
                'profile_id' => $user->profile->id,
                'language_slug NOT IN' => $languageNamesSlug
            ]);

            foreach ($languages as $language) {
                if ($ProfileLanguages->exists([
                    'profile_id' => $user->profile->id,
                    'language_slug' => Text::slug($language['language'])
                ])) {
                    continue;
                }
                $profileLanguage = $ProfileLanguages->newEntity([
                    'profile_id' => $user->profile->id,
                    'language' => $language['language'],
                    'language_slug' => Text::slug($language['language']),
                    'proficiency' => $language['proficiency'],
                ]);
                if (!$ProfileLanguages->save($profileLanguage)) {
                    $this->_message = 'Oops! We are having issues updating your ' .
                        'profile at the moment. Please try again.';
                    return false;
                }
            }
        } else {
            $ProfileLanguages->deleteAll([
                'profile_id' => $user->profile->id
            ]);
        }
    }
}
