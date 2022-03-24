<?php
declare(strict_types=1);

namespace App\Controller\Component;

use App\Utility\ServiceMessages;
use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Http\Exception\NotFoundException;
use Cake\ORM\Locator\TableLocator;
use Cake\Utility\Inflector;

/**
 * ProfileMenus component
 */
class ProfileMenusComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    protected $components = ['Auth'];

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
        $content = 'ProfileMenu';
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

    protected function _userProfileMenu()
    {
        $request = $this->getController()->getRequest();
        $username = $request->getQuery('user');
        $username = ($username === 'me' || $username === null)
            ? $this->Auth->user('username')
            : $username;

        if ($username === null) {
            throw new NotFoundException(ServiceMessages::getMissingPageMessage());
        }

        try {
            $Users = (new TableLocator)->get('Users');
            $user = $Users->getUser($username);
        } catch (\Exception $exception) {

        }

        $this->getController()->set(compact('user'));
    }
}
