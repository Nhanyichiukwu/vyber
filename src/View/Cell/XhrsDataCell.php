<?php
namespace App\View\Cell;

use Cake\View\Cell;

/**
 * XhrsData cell
 */
class XhrsDataCell extends Cell
{

    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    /**
     * Initialization logic run at the end of object construction.
     *
     * @return void
     */
    public function initialize()
    {
    }
    
    public function about() {
        
    }
    
    public function connections() {
        
    }
    
    public function events() {
        
    }
    
    public function familiarUsers() {
        
    }
    
    public function photos() {
        
    }
    
    public function posts($account) {
        $this->loadModel('s');
        $posts = $this->s->getPostsBySingleAuthor($account->get('refid'))->limit(12);
        
        $this->set(compact('posts','account'));
    }
    
    public function relatedArticles() {
        
    }
    
    public function songs() {
        
    }
    
    public function similarAccounts() {
        
    }
    
    public function videos() {
        
    }
}
