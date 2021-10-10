<?php
namespace App\View\Helper;

use Cake\Core\Configure;
use Cake\Http\Response;
use Cake\View\Helper;
use Cake\View\Helper\HtmlHelper;
use Cake\View\Helper\UrlHelper;
use Cake\View\StringTemplateTrait;
use Cake\View\View;

/**
 * UiDefaults helper
 */
class UiDefaultsHelper extends Helper
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    
    public $helpers = ['Html','Url', 'Form'];

    
    public function getDefaultProfileImageUrl() {
        return $this->Url->assetUrl('img/profile/profile-photos/intertainer.jpg', ['fullBase' => true]);
    }
    
    public function getDefaultProfileHeaderImageUrl() {
        return $this->Url->assetUrl('img/profile/header-images/intertainer-header.png', ['fullBase' => true]);
    }
}
