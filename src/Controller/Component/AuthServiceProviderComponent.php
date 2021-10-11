<?php
declare(strict_types=1);

namespace App\Controller\Component;

use App\Model\Entity\User;
use App\Model\Table\UsersTable;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Controller\Component;
use Cake\Core\Exception\Exception;
use Cake\Dataource\EntityInterface;
use Cake\Http\Cookie\Cookie;
use Cake\Http\Response;
use Cake\I18n\Date;
use Cake\ORM\Locator\TableLocator;
use Cake\Validation\Validation;

/**
 * AuthServiceProvider component
 *
 * @property Component\AuthComponent $Auth
 * @property UsersTable $Users
 */
class AuthServiceProviderComponent extends Component
{
    const PASSWORD_FORMAT = '/^(?=.*[a-z].*[a-z])(?=.*[A-Z].*[A-Z])(?=.*\d.*\d)(?=.*\W.*\W)[a-zA-Z0-9\S]{8,255}$/';
    const PASSWORD_FORMAT_HINT = "Password must not be less than 8 "
        . "characters, and must contain at least 2 lowercase "
        . "letters, 2 uppercase letters, 2 numbers, 2 "
        . "special characters and no white spaces";
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    /**
     * @var string
     */
    protected $_redirectTo = '';

    /**
     * @var string
     */
    protected $_authMessage;

    /**
     * @var string
     */
    public $authStatus;

    /**
     * @var array
     */
    protected $_errors = [];

    /**
     * @var array
     */
    protected $_formData = [];

    /**
     * @var string
     */
    protected $_errorField;

    /**
     * @var array
     */
    public $components = ['Auth','GuestsManager'];

    /**
     * @var User|array|EntityInterface|null
     */
    protected $_authenticatedUser;

    public function initialize(array $config): void
    {
        parent::initialize($config);

        $tableLocator = new TableLocator;
        $this->Users = $tableLocator->get('Users');

    }

    /**
     * Check if a user is authenticated or not
     * @return bool
     */
    public function isAuthenticated()
    {
        if (null == $this->Auth->user('id')) {
            return false;
        }
        return true;
    }

    /**
     * @param array $requiredFields
     * @return bool|Response|null
     */
    public function authenticate(array $requiredFields = [])
    {
        $options = [
            'requiredFields' => $requiredFields,
            'swapFields' => [
                'varchar' => 'username'
            ]
        ];

        if (!$this->validate('login', $options)) {
            return false;
        }

        $loginID = $this->getLoginIdUsed();
        $loginIdType = $this->getDataType($loginID) === 'varchar'
            ? 'username'
            : $this->getDataType($loginID);
        $supportedLoginMethods = $this->getConfig('supportedLoginMethods');
        $loginIdFieldName = $this->getLoginIdFieldName();

        if (!Validation::inList($loginIdType, $supportedLoginMethods)) {
            $this->authStatus = 'error';
            $this->_errors[$loginIdFieldName]['invalid'] = 'Please enter a valid ' . $loginIdFieldName;
            return false;
        }

        $this->_configureAuthenticate($loginIdType);

        if ($this->isSegmented('login')) {
            return $this->__segmentAuthenticate();
        } else {
            return $this->__simpleAuthenticate();
        }
    }

    /**
     * Form validator
     *
     * @param string|null $form
     * @param array $options
     * @return bool
     */
    public function validate(?string $form = null, ?array $options = []):bool
    {
//        if (empty($options)) {
//            $options = $this->getConfig($form);
//        } else {
//            $options += $this->getConfig($form);
//        }
        $formData = $this->getController()->getRequest()->getData();

        foreach ($formData as $fieldName => $fieldValue) {
//            $this->_formData[$fieldName] = $fieldValue;
            if (in_array($fieldName, $this->getConfig("ignore"))) {
                continue;
            }
            if (in_array($fieldName, $this->getConfig("noValidate"))) {
                $this->_formData[$fieldName] = $fieldValue;
                continue;
            }

            if (
                !Validation::notBlank($fieldValue)
                && (
                    Validation::inList(
                        $fieldName,
                        $options['requiredFields']
                    )
                    || $this->_isRequiredField($fieldName, $form)
                )
            ) {
                $this->authStatus = 'error';
                $this->_errors[$fieldName]['empty'] =  ucfirst($fieldName) . ' is required';
                return false;
            }
            if (
                isset($options['expectedValues'][$fieldName]) &&
                !Validation::equalTo(
                    $fieldValue, $options['expectedValues'][$fieldName]['value']
                )
            ) {
                $message = $options['expectedValues'][$fieldName]['message']
                    ?? 'Sorry, ' . $fieldName . ' must be '
                    . $options['expectedValues'][$fieldName]['value'];
                $this->authStatus = 'error';
                $this->_errors[$fieldName]['unacceptable'] = $message;
                return false;
            }

// Password field validation
            if ($fieldName === 'password' || $fieldName === 'confirm_password') {
                $passwordFormat = $this->getConfig('passwordFormat')
                    ?? static::PASSWORD_FORMAT;

                if (!Validation::custom($fieldValue, $passwordFormat)) {
                    $this->authStatus = 'error';
                    $passwordFormatErrorMsg =
                        $this->getConfig('passwordFormatHint')
                        ?? self::PASSWORD_FORMAT_HINT;
                    $this->_errors[$fieldName]['invalid'] = $passwordFormatErrorMsg;
                    return false;
                }

                if (
                    $fieldName === 'confirm_password'
                    && $this->hasFormData('password')
                    && !Validation::equalTo(
                        $fieldValue, $this->getFormData('password')
                    )
                ) {
                    $this->authStatus = 'error';
                    $this->_errors[$fieldName]['invalid'] = 'Passwords mismatch';
                }
                $this->_formData[$fieldName] = $fieldValue;
                continue;
            }

            $intendedDataType = 'varchar';
            if (is_string($fieldValue)) {
                $intendedDataType = $this->getDataType($fieldValue);
            }
            if ($intendedDataType === 'varchar' && isset($options['swapFields'])) {
                if (array_key_exists($intendedDataType, $options['swapFields'])) {
                    $fieldName = $options['swapFields'][$intendedDataType];
                    $intendedDataType = $fieldName;
                }
            }

            if (
                in_array(
                    $intendedDataType,
                    $this->getConfig("definedDataTypes")
                )
                && !$this->__isValidAs($intendedDataType, $fieldValue)
            ) {
                $this->authStatus = 'error';
                $this->_errors[$fieldName]['invalid'] = 'Please enter a valid ' . $intendedDataType;
                return false;
            }

            $this->_formData[$fieldName] = $fieldValue;
            $this->_formData[$intendedDataType] = $fieldValue;
        }

        return true;
    }

    /**
     * Checks if a given data is valid as a specified type
     * - For example, assuming a user enters a string that looks like an email,
     * if `email` is parsed to the $dataType parameter, then this method will
     * check the value provided in $data to see if it is a valid email address
     *
     * @param string $dataType
     * @param string $data
     * @return bool
     */
    private function __isValidAs(string $dataType, string $data): bool
    {
        switch ($dataType) {
            case 'email':
                if (Validation::email($data)) {
                    return true;
                }
                return false;
            case 'phone':
                if (Validation::numeric($data) || Validation::naturalNumber($data, true)) {
                    return true;
                }
                return false;
            case 'username':
                if (Validation::asciiAlphaNumeric($data)) {
                    return true;
                }
                return false;
            default:

        }
        return false;
    }

    /**
     * @return array
     */
    public function getAllFormData(): array
    {
        return $this->_formData;
    }

    /**
     * @param string $fieldName
     * @return mixed|null
     */
    public function getFormData(string $fieldName)
    {
        if (array_key_exists($fieldName, $this->_formData)) {
            return $this->_formData[$fieldName];
        }
        return null;
    }

    public function hasFormData(string $fieldName)
    {
        return array_key_exists($fieldName, $this->_formData);
    }

    /**
     * @param string|null $fieldName
     * @return array|mixed
     */
    public function getErrors(string $fieldName = null)
    {
        if ($fieldName === null) {
            return $this->_errors;
        } elseif (array_key_exists($fieldName, $this->_errors)) {
            return $this->_errors[$fieldName];
        }
    }

    /**
     * <b>Authenticates</b> a user using username and password. This method will first
     * check if the given username, email, or phone exists, and if so, it will
     * go ahead to compare the given password against the one in the database.
     * If both steps return positive, this method will return a user object.
     * Otherwise, it will return false.
     *
     * @param string $username
     * @param string $password
     * @return User|bool
     */
    protected function _identifyUserByUsernameAndPassword(string $username, string $password)
    {
        $user = $this->_identifyUserByUsername($username);

        if ($user) {
            if ((new DefaultPasswordHasher)->check($password, $user->password)) {
                return $user;
            }
        }

        return false;
    }

    /**
     * @param string $username
     * @return bool|User|EntityInterface
     */
    protected function _identifyUserByUsername(string $username)
    {
        $user = $this->Users->getUser($username);

        if ($user instanceof User) {
            return $user;
        }
        return false;
    }

    /**
     * Get the details of the user that was just authenticated
     *
     * @return User|array|EntityInterface|null
     */
    public function getAuthenticatedUser()
    {
        return $this->_authenticatedUser;
    }


    protected function _configureAuthenticate(?string $loginIdType): void
    {
        $loginMethod = '_loginWith' . ucfirst($loginIdType);
        $this->{$loginMethod}();
    }

    public function requireAuthentication(array $queryParams = null)
    {
        $qParams = [
            'redirect' => $this
                ->getController()
                ->getRequest()
                ->getRequestTarget()
        ];
        if (is_array($queryParams)) {
            $qParams = array_merge($qParams, $queryParams);
        }
        return $this->getController()->redirect([
            'controller' => 'login',
            'action' => 'index',
            '?' => $qParams
        ]);
    }

    /**
     * Checks whether the app is being launched for the first time.
     *
     * @return bool true if this is the first launch and false otherwise
     */
    public function isFirstLaunch()
    {
        $app = $this->getAppLaunchInfo();
        return $app === null;
    }

    public function getAppLaunchInfo()
    {
        $request = $this->getController()->getRequest();
        return $request->getCookie('App');
    }

    public function launchApp()
    {
        $response = $this->getController()->getResponse();
//        $guestManager = (new TableLocator())->get('GuestsManager');
        $launchDetails = [
            'launchDate' => Date::now(),
            'userAgent' => $this->GuestsManager->getUserBrowser(),
            'userDevice' => $this->GuestsManager->getUserDevice(),
            'userOS'=> $this->GuestsManager->getUserOS(),
        ];
        $app = new Cookie('App', $launchDetails);
        $app->withPath('/')
            ->withSecure(false)
            ->withNeverExpire();
        $response = $response->withCookie($app);
        $this->getController()->setResponse($response);
    }

    /**
     * @return void
     */
    protected function _loginWithEmail(): void
    {
        $email = $this->getFormData('email');
        $request = $this->getController()->getRequest();
        if (Validation::email($email))
        {
            $this->Auth->setConfig('authenticate', [
                'Form' => [
                    'fields' => ['username' => 'email']
                ]
            ]);

            $this->Auth->constructAuthenticate();
            $request = $request
                ->withoutData('username')->withData('email', $email);

            $this->getController()->setRequest($request);
        }
    }

    /**
     * @return void
     */
    protected function _loginWithUsername(): void
    {
        $request = $this->getController()->getRequest();
        $username = $this->getFormData('username');

//        try {
//            if (empty($username)) {
//                throw new Exception('Sorry we encountered an error while trying to process your request... Please try again.');
//            }
//        } catch (Exception $authException) {
//
//        }

        $this->Auth->setConfig('authenticate', [
            'Form' => [
                'fields' => ['username' => 'username']
            ]
        ]);

        $this->Auth->constructAuthenticate();

        // Re-assign the request data username to the validated and
        // sanitized username
        $request = $request->withData('username', $username);
        if ($request->getData('email')) {
            $request = $request->withoutData('email');
        }
        $this->getController()->setRequest($request);
    }


    protected function _loginWithPhone()
    {
        $request = $this->getController()->getRequest();
        $phone = $this->getFormData('phone');
        try {
            if (empty($phone)) {
                throw new Exception('Sorry we encountered an error
                while trying to process your request... Please try again.');
            }
        } catch (Exception $authException) {

        }

        $this->Auth->setConfig('authenticate', [
            'Form' => [
                'fields' => ['username' => 'phone']
            ]
        ]);

        $this->Auth->constructAuthenticate();

        // Re-assign the request data username to the validated and
        // sanitized username
        $request = $request->withData('username', $phone);
        $this->getController()->setRequest($request);
    }

//    protected function _loginWithUsernameOrEmail()
//    {
//        if ($this->getFormData('email')) {
//            return $this->_loginWithEmail();
//        } elseif ($this->getFormData('username')) {
//            return $this->_loginWithUsername();
//        }
//    }
//
//    protected function _loginWithEmailOrPhone()
//    {
//        if ($this->getFormData('email')) {
//            return $this->_loginWithEmail();
//        } elseif ($this->getFormData('phone')) {
//            return $this->_loginWithPhone();
//        }
//    }
//
//    protected function _loginWithUsernameOrPhone()
//    {
//        if ($this->getFormData('username')) {
//            return $this->_loginWithUsername();
//        } elseif ($this->getFormData('phone')) {
//            return $this->_loginWithPhone();
//        }
//    }

    /**
     * Checks whether a data type is supported by the application for the purpose of authentication
     *
     * @param string|array $type
     * @return bool
     */
    public function supports($type, $form)
    {
        if (is_string($type) && in_array($type, $this->getSupportedLoginMethods())) {
            return true;
        } elseif (is_array($type)) {
            if (empty(array_diff($type, $this->getSupportedLoginMethods()))) {
                return true;
            }
        }
        return false;
    }

    /**
     * Checks if the authentication supports only the specified type out of the
     * following: email, phone, and username
     *
     * @param string $type
     * @return bool
     */
    public function loginSupportsOnly(string $type)
    {
        $supportedLoginMethods = $this->getSupportedLoginMethods();
        if (is_string($type) && sizeof($supportedLoginMethods) === 1 && $supportedLoginMethods[0] === $type) {
            return true;
        }
        return false;
    }

    /**
     * Checks whether a form field is required or not.
     *
     * @param string $fieldName
     * @return bool
     */
    protected function _isRequiredField(string $fieldName, string $form)
    {
        if (Validation::inList($fieldName, $this->getConfig("$form.requiredFields", []))) {
            return true;
        }
        return false;
    }

    /**
     * Checks the data type entered in a form field
     *
     * @param string $data
     * @return string|null
     */
    public function getDataType($data)
    {
        $dataType = null;
        if (Validation::numeric($data) || Validation::naturalNumber($data, true)) {
            $dataType = 'phone';
        } elseif (Validation::email($data)) {
            $dataType = 'email';
        }
        elseif (Validation::alphaNumeric($data)) {
            $dataType = 'varchar';
        }

        return $dataType;
    }

    /**
     * @param string $form
     * @return mixed
     */
    public function isSegmented(string $process)
    {
        return $this->getConfig("segmented.$process", false);
    }

    public function getSupportedLoginMethods()
    {
        return $this->getConfig("supportedLoginMethods");
    }

    public function isPresumed(string $type, string $check)
    {
        switch ($type) {
            case 'username':
                if (
                    Validation::alphaNumeric($check) &&
                    !Validation::naturalNumber($check) &&
                    !Validation::email($check) &&
                    !Validation::url($check)) {
                    return true;
                }
                break;
            case 'email':
                if (
                    (
                        Validation::email($check) || false !== mb_strpos($check, '@')
                    ) &&
                    !Validation::naturalNumber($check)
                    && !Validation::url($check)
                ) {
                    return true;
                }
                break;
            case 'phone':
                if (
                    (
                    Validation::naturalNumber($check) || Validation::numeric($check)
                    ) && !Validation::email($check) &&
                !Validation::notAlphaNumeric($check) && !Validation::url($check)) {
                    return true;
                }
                break;
            default:
                return false;
        }
    }

    /**
     * @return string
     */
    public function getLoginIdUsed()
    {
        return $this->getFormData('username') ??
            $this->getFormData('email') ??
            $this->getFormData('phone');
    }

    /**
     * @return string|null
     */
    public function getLoginIdFieldName()
    {
        $request = $this->getController()->getRequest();
        $fieldName = 'contact';
        if (null != $request->getData('username')) {
            $fieldName = 'username';
        } elseif (null != $request->getData('email')) {
            $fieldName = 'email';
        } elseif (null != $request->getData('phone')) {
            $fieldName = 'phone';
        }

        return $fieldName;
    }

    public function authoriseNewUser(User $user)
    {
        $request = $this->getController()->getRequest();

    }

    /**
     * @return bool|Response|null
     */
    private function __segmentAuthenticate()
    {
        $loginID = $this->getLoginIdUsed();
        $loginIdFieldName = $this->getLoginIdFieldName();
        $loginIdType = $this->getDataType($loginID);
        $user = $this->_identifyUserByUsername($loginID);

        if (false !== $user) {
            $request = $this->getController()->getRequest();
            $session = $request->getSession();
            $session->write(['identified_by' => 'username', 'user' => $user]);
            $this->_redirectTo = '/preAuthenticated?challenge=user_confirmation&task=enter_password';
            $queryParams = $request->getQueryParams();

            if (count($queryParams)) {
                $queryString = http_build_query($queryParams);
                $this->_redirectTo .= '&next=' . urlencode($queryString);
            }

            return $this->getController()->redirect($this->_redirectTo);
        }

        $this->authStatus = 'error';
        $this->_authMessage = "Sorry, we looked everywhere but could not find any customer by that $loginIdType";
        $this->_errors[$loginIdFieldName]['unknown_user'] = 'Unknown user!';

        return false;
    }

    /**
     * @return bool
     */
    private function __simpleAuthenticate(): bool
    {
        $usedID = $this->getLoginIdFieldName();
        $user = $this->_identifyUserByUsernameAndPassword(
            (string)$this->getFormData($usedID),
            (string)$this->getFormData('password')
        );
        if (!$user) {
            $this->authStatus = 'error';
            return false;
        }

        $this->_authenticatedUser = $this->Users->getUser(
            $user['refid']
        );

        $this->authStatus = 'success';
        return true;
    }
}
