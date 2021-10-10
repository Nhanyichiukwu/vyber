<?php
declare(strict_types=1);

namespace App\Controller\Component;

use App\Model\Entity\Guest;
use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\ORM\Locator\TableLocator;
use Detection\MobileDetect;
use Cake\ORM\Query;
use Cake\Utility\Inflector;
use Cake\Utility\Text;
use Cake\Http\Cookie\CookieCollection;
use Cake\Http\Cookie\Cookie;

/**
 * GuestsHandler component
 *
 * @property \App\Model\Table\GuestsTable $Guests The guests table object
 * @property Cookie $Cookie Description
 */
class GuestsManagerComponent extends Component
{
    /**
     * Components accessible to and used by this component
     *
     * @var array
     * @access public
     */
//    public $components = ['Cookie'];

    /**
     * @var string
     */
    private const COOKIE_NAME = 'Guest';

    /**
     * Default configuration.
     *
     * @var array
     * @access protected
     */
    protected $_defaultConfig = [];

    /**
     *
     * @var type
     * @access private
     */
    private $__guest = null;

    protected $components = [
        'LocationService'
    ];

    /**
     * @var string
     */
    private $Cookie;

    public function initialize(array $config): void
    {
        parent::initialize($config);

        $tableLocator = new TableLocator();
        $this->Guests = $tableLocator->get('Guests');
//        $this->Cookie = new Cookie(static::COOKIE_NAME);
    }


    public function trackGuests()
    {
        $newGuestLocation = (object) $this->LocationService->getLocationInfo(
            $this->getUserClientAddress(),
            'Location'
        );
        $data = [
            'ip' => $this->getUserClientAddress(),
            'device' => $this->getUserDevice(),
            'browser' => $this->getUserBrowser(),
            'os' => $this->getUserOS()
        ];

        if (property_exists($newGuestLocation, 'country')) {
            $data['city']               = $newGuestLocation->city;
            $data['state']              = $newGuestLocation->state;
            $data['region']             = $newGuestLocation->region;
            $data['region_code']        = $newGuestLocation->region_code;
            $data['country']            = $newGuestLocation->country;
            $data['country_code']       = $newGuestLocation->country_code;
            $data['continent']          = $newGuestLocation->continent;
            $data['continent_code']     = $newGuestLocation->continent_code;
//            $data['continent_symbol']   = $newGuestLocation->continent_symbol;
            $data['currency_code']      = $newGuestLocation->currency_code;
            $data['currency_symbol']    = $newGuestLocation->currency_symbol;
            $data['timezone']           = $newGuestLocation->timezone;
            $data['longitude']          = $newGuestLocation->longitude;
            $data['latitude']           = $newGuestLocation->latitude;
        }

        try {
            if ($this->Guests->exists(['ip' => $data['ip']])) {
                $guest = $this->Guests->find(
                    'byIp', [
                        'ip' => $data['ip']
                    ]
                )
                    ->first();
            } else if ($this->isKnownGuest()) {
                $guest = $this->Guests->find(
                    'byId', [
                        'id' => $this->getGuestInCookie()->id
                    ]
                )
                    ->first();
            } else {
                $guest = $this->Guests->newEmptyEntity();
            }
            $guest = $this->Guests->patchEntity($guest, $data);
            $this->Guests->save($guest);
        } catch (\Throwable $e) {
            $this->log(__("Failed to save guest's data: {0}",
                implode(';', $guest->getErrors()))
            );

        }


        // Save the guest in the cookie as well
        $this->saveGuestIntoCookie([
            'id'    => $guest->id,
            'ip'    => $guest->ip
        ]);

        $this->setGuest($guest);
    }

    /**
     *
     * @param Guest $guest
     * @return $this
     */
    public function setGuest($guest)
    {
        $this->__guest = $guest;

        return $this;
    }


    /**
     * Get the current site guest, whether logged in or not
     *
     * @return array|\Cake\Datasource\EntityInterface|Query|null
     */
    public function getGuest()
    {
        $guestIp = $this->getController()->getRequest()->clientIp();
        $guest = $this->Guests->find('byIp', ['ip' => $guestIp])->first();

        return $guest;
    }

    public function getUserBrowser($user_ip_or_id = null)
    {
        $browser = 'Unknown Browser';
        $detector = new MobileDetect();
        if ($detector->isChrome()) {
            $browser = 'Google Chrome';
        }
        if ($detector->isOpera()) {
            $browser = 'Opera Browser';
        }
        if ($detector->isUCBrowser()) {
            $browser = 'UC Browser';
        }
        if ($detector->isFirefox()) {
            $browser = 'Mozilla Firefox';
        }
        if ($detector->isEdge()) {
            $browser = 'Microsoft Edge';
        }
        if ($detector->isIE()) {
            $browser = 'Microsoft Internet Explorer';
        }
        if ($detector->isBolt()) {
            $browser = 'Bolt Browser';
        }
        if ($detector->isTeaShark()) {
            $browser = 'TeaShark';
        }
        if ($detector->isSafari()) {
            $browser = 'Apple Safari';
        }
        if ($detector->isGenericBrowser()) {
            $browser = 'Assumed Nokia/Ovi Browser';
        }

        return $browser;
    }

    public function getUserDevice()
    {
        $device = 'Desktop';
        $detector = new MobileDetect();
        if ($detector->isMobile()) {
            $device = 'Mobile';
        }
        if ($detector->isTablet()) {
            $device = 'Tablet';
        }

        return $device;
    }

    /**
     * Identify a user's Operating System
     *
     * @return string
     */
    public function getUserOS(): string
    {
        $os = 'Unknown OS';
        $detector = new MobileDetect();
        if ($detector->isAndroidOS()) {
            $os = 'Google Android';
        }
        if ($detector->isWindowsPhoneOS()) {
            $os = 'Microsoft Windows Phone OS';
        }
        if ($detector->isWindowsMobileOS()) {
            $os = 'Microsoft Windows Mobile OS';
        }
//        if ($detector->isMac()) {
//            $os = 'Apple Mac OS';
//        }
//        if ($detector->isJava()) {
//            $os = 'Java OS';
//        }
        if ($detector->isWebOS()) {
            $os = 'Web OS';
        }
        if ($detector->isiOS()) {
            $os = 'Apple iOS';
        }
        if ($detector->isBlackBerryOS()) {
            $os = 'BlackBery OS';
        }
        if ($detector->isSymbianOS()) {
            $os = 'Symbian OS';
        }

        return $os;
    }

    /**
     * Lookup an ip address to see if the ip is already in the system or
     * is a new one
     *
     * @param null $ip
     * @return bool
     */
    public function identifyGuest($ip = null): bool
    {
        if ($this->Guests->exists(['ip' => $ip])) {
            return true;
        }

        $cookieUser = $this->getGuestInCookie();
        if ($cookieUser !== null) {
            return true;
        }

        return false;
    }

    public function getGuestInCookie()
    {
        $guest = null;
        if ($this->isKnownGuest()) {
            $guest = $this->Cookie->read('Guest');
            $guest = json_decode($guest, false);
        }

        return $guest;
    }

    /**
     * Checks whether there is a cookie with the name 'Guest'
     *
     * @param void
     * @return bool
     */
    public function isKnownGuest(): bool
    {
        $cookies = new CookieCollection();

        return $cookies->has(self::COOKIE_NAME);
    }

    /**
     * Stores a given guest data in the cookie
     * <b>Please Note:</b> Cookies set at the CakePHP component level must be attached
     * to the controller response object, otherwise, the cookie will not be set
     *
     * @param array $guest
     * @return $this
     */
    public function saveGuestIntoCookie(array $guest): self
    {
        $response = $this->getController()->getResponse();
        $cookies = new CookieCollection();
        if ($cookies->has(self::COOKIE_NAME)) {
            $cookie = $cookies->get(self::COOKIE_NAME);
        }
        if (isset($cookie)) {
            $cookie = $cookie->withAddedValue('/', $guest);
        } else {
            $cookie = (new Cookie(self::COOKIE_NAME))
                ->withPath('/')
                ->withNeverExpire()
                ->withHttpOnly(true)
                ->withSecure(true)
                ->withValue(json_encode($guest));
        }

        $response = $response->withCookie($cookie);

        $this->getController()->setResponse($response);

        return $this;
    }

    public function getUserClientAddress() {

        return $this->getController()->getRequest()->clientIp();
    }
}
