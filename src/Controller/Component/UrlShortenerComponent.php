<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;

/**
 * UrlShortener component
 */
class UrlShortenerComponent extends Component
{

    public $components = ['CustomString'];
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    
    private $_allowExternalUrls = false;


    public function initialize(array $config) {
        parent::initialize($config);
        
        $this->ShortUrls = $this->getController()->getTableLocator()->get('ShortUrls');
    }
    
    public function shorten($url) {
        $controller = $this->getController();
        
        if (!$url) {
            $controller->Flash->error('Please provide a url');
            return;
        }

//      Ensure the url is in proper url format
//      Note: this validation is for external urls only
        
        if (true === $this->getExternalUrlAllowance()) {
            if (false === $this->_validateUrl($url)) {
                $controller->Flash->error(__('The url is not in a valid format'));
                return false;
            }
            
//        Check if the given url is actually in existence
//        ie: it can be accessed
            if (false === $this->_verifyUrlExistence($url)) {
                $controller->Flash->error(__('This url does not exist!'));
                return false;
            }
        }

        // Check to see whether the url is already in the database
        // If so, we return the code, else we create a new one
        $existingUrl = $this->_findUrlInDb($url);
        if ($existingUrl)
            return $existingUrl->short_code;

        // Create a new shortcode since there is none found in the database
        $shortcode = $this->_createShortCode($url);

        return $shortcode;
    }

    private function _createShortCode($url) 
    {
        $controller = $this->getController();
        $code = $this->CustomString->generateRandom(7);
        $shortUrl = $controller->request->getAttribute('base') . '/t/' . $code;
        
        if ($this->_saveUrl($url, $code))
            return $shortUrl;
    }

    private function _validateUrl($url) {
        $validatedUrl = filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED);
        return $validatedUrl;
    }

    private function _saveUrl($fullUrl, $code) {
        $url = $this->ShortUrls->newEntity();
        $date = date('Y-m-d h:i:s');
        $data = [
            "full_url" => $fullUrl,
            "short_code" => $code,
            "created" => $date,
            "modified" => $date
        ];

        $url = $this->ShortUrls->patchEntity($url, $data);

        if ($this->ShortUrls->save($url))
            return true;
        
        return false;
    }

    private function _findUrlInDb($url) {
        $query = $this->ShortUrls->find('all')->where(['ShortUrls.full_url =' => $url]);
        $result = $query->all()->toArray();
        
        if (count($result) < 1)
            return false;
        
        $url = $data[0];
        
        return $url;
    }

    /**
     * Url existence verification method
     *
     * Checks if the given url is a valid working url and can be accessed
     * @param $url The url to be verified
     * @return string url | false on failure
     */
    private function _verifyUrlExistence($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_NOBODY, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_exec($curl);
        $response = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        
        return (!empty($response) && $response != 404 );
    }

    public function decode(... $path) {
        // print_r( get_class_methods( $this ) );
        // exit;
        if (empty($path) || count($path) > 1) {
            throw new NotFoundException($this->pageNotFoundMessage);
        }
        $code = $path[0];
        if (strlen($code) <> 7) {
            throw new NotFoundException($this->pageNotFoundMessage);
        }
        $url = $this->getUrl($code);
        if ($url) {
            if (stripos($url, $this->request->base) !== false) {
                $url = str_replace($this->request->base, '', $url);
                $this->redirect($url);
            } else {
                $this->redirect($url); // External redirect
            }
        }
    }

    public function getUrl($code) {
        $query = $this->ShortUrls->find('all')->where(['ShortUrls.short_code =' => $code]);
        $result = $query->all();
        $result = $result->toArray();
        $data = $result[0];
        return $data->full_url;
    }
    
    public function setExternalUrlAllowance(bool $option)
    {
        $this->_allowExternalUrls = $option;
    }

    public function getExternalUrlAllowance()
    {
        return $this->_allowExternalUrls;
    }
}
