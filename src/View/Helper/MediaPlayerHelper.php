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
 * MediaPlayer helper
 */
class MediaPlayerHelper extends Helper
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    
    public $helpers = ['Html','Url','Text','Number'];
    
    public function load(\App\Model\Entity\Media $media) {
        $player = $media->get('media_type');
        $player = '_' . $player . 'Player';
        if (method_exists($this, $player)) {
            return $this->{$player}($media);
        }
    }
    
    protected function _audioPlayer(\App\Model\Entity\Media $audio) {
        return '<div class="card bg-dark">'
            . '<div class="h0LT_Ehfh"></div>'
        . '</div>';
    }
    
    protected function _videoPlayer(\App\Model\Entity\Media $video) {
        
    }
}
