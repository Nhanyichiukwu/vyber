<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Controller\Exception\MissingActionException;
use Cake\Controller\Exception\MissingComponentException;
use Cake\Core\Configure;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Event\EventInterface;
use Cake\Http\Exception\BadRequestException;
use Cake\Http\Exception\NotFoundException;
use Cake\Utility\Inflector;

/**
 * DynamicContents Controller
 */
class DynamicContentsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->Auth->allow();
    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
//        if (!$this->getRequest()->is('ajax')) {
//            throw new BadRequestException();
//        }
    }

    /**
     * Find the appropriate menu type and load it
     *
     * @param $type
     * @return mixed
     */
    public function menu($type)
    {
        // Manually require the user to login
        if (!$this->AuthServiceProvider->isAuthenticated()) {
            return $this->AuthServiceProvider->requireAuthentication();
        }

        $component = Inflector::camelize($type, '-') . 's';
        try {
            $this->loadComponent($component);
        } catch (MissingComponentException $missingComponentException) {
            if (Configure::read('debug')) {
                throw new $missingComponentException;
            }
            throw new NotFoundException();
        } catch (\Exception $exception) {
            if (Configure::read('debug')) {
                echo $exception->getTraceAsString();
            }
            throw new NotFoundException();
        }

        $tplPath = implode(DS, [$this->getName(), $component]);
        $this->viewBuilder()->setTemplatePath($tplPath);
        return $this->$component->index();
//        if ($this->hasAction($action)) {
//            $tplPath = implode(DS, [$this->getName(), $content]);
//            $this->viewBuilder()->setTemplatePath($tplPath);
//            return $this->{$action}();
//        }
//        if (Configure::read('debug')) {
//            throw new MissingActionException();
//        }
//        throw new NotFoundException('');
    }
}
