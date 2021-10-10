<?php
declare(strict_types=1);

namespace App\Controller\Component;

use App\Utility\RandomString;
use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\I18n\Time;

/**
 * VerificationServiceProvider component
 */
class VerificationServiceProviderComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    /**
     * @param string $key
     * @param $value
     * @return $this
     */
    public function write(string $key, $value): self
    {
        $request = $this->getController()->getRequest();
        $request->getSession()->write($key, $value);
        return $this;
    }

    /**
     * @param string $contact The actual contact: a valid phone number or email
     * address
     * @param string $dataType The type of data: email or phone
     * @param int $length The length of the code that should be generated
     * @param string $codeVariant Whether to send alphabet, alpha-numeric, or
     * numbers only. Valid values are 'alpha','mixed','numbers'
     */
    public function verify(string $contact, string $dataType, int $length = 6, string $codeVariant = 'numbers')
    {
        $verificationToken = RandomString::generateString(32); //sprintf("%s|%s", $contactType, $newUser->get
        $verificationCode = RandomString::generateString($length, $codeVariant);
        $this->write('pending', [
            'code' => $verificationCode,
            'contact' => $contact,
            'contact_type' => $dataType,
            'time' => Time::now()
        ]);
        $verify = "verify" . ucfirst($dataType);
        $this->{$verify}($contact, $verificationCode);

        return $this;
    }

    public function verifyPhone($number, $code)
    {
        $request = $this->getRequest();

        return true;
    }

    public function verifyEmail()
    {

    }

    public function check($key)
    {
        return $this->getController()->getRequest()->getSession()->check($key);
    }

    public function readPreviouslyVerified($fragment = null)
    {
        $verified = $this->getController()
            ->getRequest()
            ->getSession()->read('verified');
        if ($fragment) {
            if (isset($verified[$fragment])) {
                return $verified[$fragment];
            }
            return null;
        }
        return $verified;
    }

    /**
     * @return mixed|null
     */
    public function readPendingVerification($fragment = null)
    {

        $pending = $this->getController()
            ->getRequest()
            ->getSession()
            ->read('pending');
        if ($fragment){
            if (isset($pending[$fragment])) {
                return $pending[$fragment];
            }
            return null;
        }
        return $pending;
    }

    public function getVerificationTime()
    {
        return $this->getController()
            ->getRequest()
            ->getSession()
            ->read('verified.time');
    }
}
