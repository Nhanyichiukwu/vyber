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
 * EWidgets helper
 */
class EWidgetsHelper extends Helper
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    
    public $helpers = ['Html','Url','Text','Number'];
    
    protected $_pageWidgets = [];
    
    /**
     *
     * @var \App\Model\Entity\User
     */
    protected $_pageActor;

//    public function initialize(array $config) {
//        parent::initialize($config);
//    }

    /**
     * Defines the required page widgets to be loaded by the loadWidget method
     * This method must be called along with the setPageActor method before 
     * the loadWidget method, otherwise it will fail
     * 
     * Example: $this->EWidgets->setPageWidgets($widgets)->setPageActor($user);
     * 
     * @param array $widgets
     * @return $this
     */
    public function setPageWidgets(array $widgets)
    {
        $this->_pageWidgets = $widgets;
        return $this;
    }
    
    /**
     * Defines the actor for the current page
     * his method must be called along with the setPageWidgets method before 
     * the loadWidget method, otherwise it will fail
     * 
     * Example: $this->EWidgets->setPageWidgets($widgets)->setPageActor($user);
     * 
     * @param \App\Model\Entity\User $actor
     * @return $this
     */
    public function setPageActor(\App\Model\Entity\User $actor)
    {
        $this->_pageActor = $actor;
        
        return $this;
    }

    /**
     * 
     * @param string $position
     * @param \App\Model\Entity\User $actor
     */
    public function loadWidgets(string $position, bool $addWrappers = false)
    {
        $widgets = $this->_pageWidgets;
        $actor = $this->_pageActor;
        
        if (! count($widgets)) {
            echo 'Sorry, no widgets defined.';
        } else if ( ! isset($widgets[$position])) {
            echo 'Sorry, no widgets defined for this position.';
        } else {
            if (count($widgets) && array_key_exists($position, $widgets)) {
                foreach ($widgets[$position] as $widget) 
                {
                    ?>
                    <e-widget-placeholder 
                        data-widget="<?= $widget ?>"
                        data-wrapper="<?= $addWrappers ?>"
                        class="card"
                        >
                        <e-widget-faker class="card-body widget-loading" role="fake-widget"></e-widget-faker>
                    </e-widget-placeholder>
                    <?php
                }
            }
        }
    }
}
