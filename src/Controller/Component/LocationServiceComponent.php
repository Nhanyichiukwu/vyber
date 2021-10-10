<?php
declare(strict_types=1);

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Core\Configure;
use Cake\Http\Client\Exception\NetworkException;

/**
 * LocationService component
 */
class LocationServiceComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    private $__continents = array(
        "AF" => "Africa",
        "AN" => "Antarctica",
        "AS" => "Asia",
        "EU" => "Europe",
        "OC" => "Australia (Oceania)",
        "NA" => "North America",
        "SA" => "South America"
    );

    private $__locationAspects = array(
        "country",
        "countrycode",
        "state",
        "region",
        "city",
        "location",
        "address"
    );

    private $__dataSource = "http://www.geoplugin.net/json.gp";

    public function getLocationInfo(
        string $ip = null,
        string $aspect = "location",
        bool $deep_detect = true
    )
    {
        $result = null;
        $request = $this->getController()->getRequest();
        $server = (object) $request->getServerParams();
        if (filter_var($ip, FILTER_VALIDATE_IP) === false) {
            $ip = $request->clientIp();
            if ($deep_detect) {
                if (filter_var(@$server->HTTP_X_FORWARDED_FOR, FILTER_VALIDATE_IP)) {
                    $ip = @$server->HTTP_X_FORWARDED_FOR;
                }
                if (filter_var(@$server->HTTP_CLIENT_IP, FILTER_VALIDATE_IP)) {
                    $ip = @$server->HTTP_CLIENT_IP;
                }
            }
        }

        $aspect = str_replace(
            array("name", "\n", "\t", " ", "-", "_"),
            '',
            strtolower(trim($aspect))
        );

        if (
            filter_var($ip, FILTER_VALIDATE_IP) &&
            in_array($aspect, $this->__locationAspects)
        ) {
            $ipdat = $this->_callLocationServiceProvider($ip);

            if (is_object($ipdat) &&
                property_exists($ipdat, 'geoplugin_regionName') &&
                @strlen(trim((string) $ipdat->geoplugin_countryCode)) == 2) {
                switch ($aspect) {
                    case "address":
                        $address = array($ipdat->geoplugin_countryName);
                        if (@strlen($ipdat->geoplugin_regionName) >= 1) {
                            $address[] = $ipdat->geoplugin_regionName;
                        }
                        if (@strlen($ipdat->geoplugin_city) >= 1) {
                            $address[] = $ipdat->geoplugin_city;
                        }
                        $result = implode(", ", array_reverse($address));
                        break;
                    case "city":
                        $result = @$ipdat->geoplugin_city;
                        break;
                    case "state":
                        $result = @$ipdat->geoplugin_regionName;
                        break;
                    case "region":
                        $result = @$ipdat->geoplugin_regionName;
                        break;
                    case "country":
                        $result = @$ipdat->geoplugin_countryName;
                        break;
                    case "countrycode":
                        $result = @$ipdat->geoplugin_countryCode;
                        break;
                    case "currency_symbol":
                        $result = @$ipdat->geoplugin_currencySymbol;
                        break;
                    case "longitude":
                        $result = @$ipdat->geoplugin_longitude;
                        break;
                    case "latitude":
                        $result = @$ipdat->geoplugin_latitude;
                        break;
                    case "timezone":
                        $result = @$ipdat->geoplugin_timezone;
                        break;
                    case "currencycode":
                        $result = @$ipdat->geoplugin_currencyCode;
                        break;
                    case "continent":
                        $result = @$this->__continents[strtoupper($ipdat->geoplugin_continentCode)];
                        break;
                    case "continentcode":
                        $result = @$ipdat->geoplugin_continentCode;
                        break;
                    default:
                        $result = array(
                            "city" => @$ipdat->geoplugin_city,
                            "state" => @$ipdat->geoplugin_regionName,
                            "region" => @$ipdat->geoplugin_region,
                            "region_code" => @$ipdat->geoplugin_regionCode,
                            "country" => @$ipdat->geoplugin_countryName,
                            "country_code" => @$ipdat->geoplugin_countryCode,
                            "continent" => @$this->__continents[strtoupper($ipdat->geoplugin_continentCode)],
                            "continent_code" => @$ipdat->geoplugin_continentCode,
                            "currency_symbol" => @$ipdat->geoplugin_currencySymbol,
                            "currency_code" => @$ipdat->geoplugin_currencyCode,
                            "currency_converter" => @$ipdat->geoplugin_currencyConverter,
                            "longitude" => @$ipdat->geoplugin_longitude,
                            "latitude" => @$ipdat->geoplugin_latitude,
                            "timezone" => @$ipdat->geoplugin_timezone,
                        );
                }
            }
        }

        return $result;
    }

    public function getLocation()
    {

    }

    /**
     * @param string $ip
     * @param null $serviceProviderUrl
     * @return mixed|null
     * @throws NetworkException
     */
    protected function _callLocationServiceProvider(string $ip, $serviceProviderUrl = null)
    {
        if (is_null($serviceProviderUrl)) {
            $serviceProviderUrl = $this->__dataSource . '?ip=' . $ip;
        }
        $data = null;

        set_error_handler(
            function ($errno, $message, $file, $line) {
                throw new \ErrorException($message, $errno, 1, $file, $line);
            }
        );
        try {
            $data = json_decode(
                (string) file_get_contents($serviceProviderUrl)
            );
        } catch (\Exception $e) {
            if (Configure::read('debug')) {
                // Log the error for an admin to review it
            }
        }
//        if (is_object($data) &&
//            property_exists($data, 'geoplugin_regionName') &&
//            strlen(@$data->geoplugin_regionName) >= 1
//        ) {
//            return null;
//        }

        return $data;
    }

    public function getCurrentLocation(string $ip = null)
    {
        if (is_null($ip)) {
            $ip = $this->__getClientAddress();
        }
        $currentLocation = $this->getLocationInfo(
            $ip,
            'address'
        );

        return $currentLocation === null ? false : $currentLocation;
    }

    private function __getClientAddress()
    {
        $request = $this->getController()->getRequest();
        return $request->clientIp();
    }
}
