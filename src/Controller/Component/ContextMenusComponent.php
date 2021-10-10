<?php
declare(strict_types=1);

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Core\Configure;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Http\Exception\NotFoundException;
use Cake\ORM\Locator\TableLocator;
use Cake\Utility\Inflector;

/**
 * ContextMenu component
 */
class ContextMenusComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];


    /**
     * @return mixed
     */
    public function index()
    {
        $controller = $this->getController();
        $request = $controller->getRequest();
        if ($request->getQuery('for') === null) {
            throw new NotFoundException('Oh! No! You seem lost... Were you ' .
                'trying to open a context menu? You must have followed a ' .
                'broken link, as the server is finding it difficult to ' .
                'understand the request.');
        }
        $for = $request->getQuery('for');
        $content = 'ContextMenu';
        $action = '_' . lcfirst(Inflector::camelize($for)) . $content;
        if (!method_exists($this, $action)) {
            throw new NotFoundException('Oops! The menu could not be found.');
        }
        $tpl = ltrim(
            Inflector::underscore($action),
            '_'
        );
        $controller->viewBuilder()->setTemplate($tpl);
        return $this->$action();
    }

    protected function _postContextMenu()
    {
        $controller = $this->getController();
        $postID = $controller->getRequest()->getQuery('postid');
        $Posts = (new TableLocator)->get('Posts');
        try {
            $post = $Posts->getByRefid($postID);
        } catch (RecordNotFoundException $notFoundException) {
            if (Configure::read('debug')) {
                throw $notFoundException;
            }

            return $controller->getResponse()
                ->withStringBody('<h3>Sorry, we are having trouble ' .
                    'loading the menu at the moment. Please try again shortly...</h3>');
        }

        $controller->set(compact('post'));
    }
}
