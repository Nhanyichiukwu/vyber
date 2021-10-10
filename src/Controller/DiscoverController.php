<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Controller\Exception\MissingActionException;
use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Utility\Inflector;
use App\Utility\CustomMessages;
use Cake\View\Exception\MissingTemplateException;

/**
 * Explore Controller
 *
 * @method \App\Model\Entity\Discover[]|
 * \Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DiscoverController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        ;
    }

    /**
     * Get a list of people based on the value specified in category.
     * If category is set to null or not provided, it will default to
     * all, which will invoke the Discover::allPeople()
     * @param string|null $category
     * @throws \Exception
     * @throws MissingActionException
     * @throws NotFoundException
     */
    public function people(...$path)
    {
//        $count = count($path);
//        if (!$count) {
//            return $this->redirect('/');
//        }
        if (in_array('..', $path, true) || in_array('.', $path, true)) {
            throw new ForbiddenException();
        }
        $page = $subpage = null;

        if (!empty($path[0])) {
            $page = $path[0];
        }
        if (!empty($path[1])) {
            $subpage = $path[1];
        }

        $this->set(compact('page', 'subpage'));

        array_unshift($path, 'people');
        $tplPath = array_map(function ($item) {
            return str_replace('-','_', $item);
        }, $path);

        try {
            $this->render(implode('/', $tplPath));
        } catch (MissingTemplateException $exception) {
            if (Configure::read('debug')) {
                throw $exception;
            }
            throw new NotFoundException(
                CustomMessages::getMissingPageMessage()
            );
        }
//        if ($category === null) {
//            $category = 'all-people';
//        }
//
//        $subpage = str_replace('-','_', $category);
//        $this->set(compact('subpage'));

//        if ($this->getRequest()->is('ajax')) {
//            $isAjax = true;
//            $this->set(compact('isAjax'));
//        } else {
//            $endPoint = '__' . lcfirst(
//                    Inflector::camelize($category, '-')
//                );
//            try {
//                $users = $this->{$endPoint}();
//            } catch (\Exception $exception) {
//                if (Configure::read('debug')) {
//                    throw new MissingActionException();
//                }
//                throw new NotFoundException(
//                    CustomMessages::getMissingPageMessage()
//                );
//            }
//            $this->set(compact('users'));
//        }
    }

    public function places()
    {

    }

    public function trends()
    {

    }

    public function hashtags()
    {

    }

    private function __allPeople()
    {

    }

    private function __peopleYouMayKnow()
    {
        $user = $this->getActiveUser();
        try {
            $this->loadComponent('Suggestion');
        } catch (\Exception $e) {
            if (Configure::read('debug')) {
                echo $e;
            }
            throw new NotFoundException(
                CustomMessages::getMissingPageMessage()
            );
        }
        return $this->Suggestion->suggestPossibleAcquaintances($user);
    }

    private function __whoToFollow()
    {
        $this->loadComponent('Suggestion');
        return $this->Suggestion->suggestPersonsOfInterest();
    }

    private function __artists()
    {

    }

    private function __marketers()
    {

    }
}
