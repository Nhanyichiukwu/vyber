<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Controller\Exception\MissingActionException;
use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Utility\Inflector;
use App\Utility\ServiceMessages;
use Cake\View\Exception\MissingTemplateException;

/**
 * Explore Controller
 *
 * @method \App\Model\Entity\Explore[]|
 * \Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ExploreController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
//        $this->enableSidebar(false);
    }

    /**
     * Get a list of people based on the value specified in category.
     * If category is set to null or not provided, it will default to
     * all, which will invoke the Explore::allPeople()
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
            return str_replace('-', '_', $item);
        }, $path);

        try {
            $this->render(implode('/', $tplPath));
        } catch (MissingTemplateException $exception) {
            try {
                $this->render('people/default');
            } catch (\Throwable $throwable) {
                if (Configure::read('debug')) {
                    throw $exception;
                }
                throw new NotFoundException(
                    ServiceMessages::getMissingPageMessage()
                );
            }
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
//                    ServiceMessages::getMissingPageMessage()
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

    public function peopleYouMayKnow()
    {
        $user = $this->getActiveUser();
        try {
            $this->loadComponent('Suggestion');
        } catch (\Exception $e) {
            if (Configure::read('debug')) {
                echo $e;
            }
            throw new NotFoundException(
                ServiceMessages::getMissingPageMessage()
            );
        }
        return $this->Suggestion->suggestPossibleAcquaintances($user);
    }

    public function whoToFollow()
    {
        $this->loadComponent('Suggestion');
        return $this->Suggestion->suggestPersonsOfInterest();
    }

    public function artists()
    {
        $this->viewBuilder()->setTemplatePath('Medias/Music');
    }

    public function actors()
    {
        $this->viewBuilder()->setTemplatePath('Medias/Movie');
    }

    public function producers()
    {
        $this->viewBuilder()->setTemplatePath('Users');
    }

    public function posts()
    {

    }

    public function music()
    {
        $Medias = $this->loadModel('Medias');
        $user = $this->getActiveUser();
        $music = $Medias->find('byEntertainmentType', [
            'entertainmentType' => 'movie'
        ]);
        $musicByUser = $Medias->findByAuthor($music, ['author' => $user->refid]);

        $this->enableSidebar(false);
        $this->set(compact('music', $musicByUser));
    }

    public function movies()
    {
//        $audios = $this->loadModel('Audios');
//        $user = $this->getActiveUser();
//        $music = $audios->find('byType', ['type' => 'music']);
//        $musicByUser = $audios->findByAuthor($music, ['author' => $user->refid]);

        $this->enableSidebar(false);
//        $this->set(compact('music', $musicByUser));
    }

    public function comedies()
    {

    }

    public function comedians()
    {

    }

    public function shows(...$path)
    {
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
            return str_replace('-', '_', $item);
        }, $path);

        try {
            $this->render(implode('/', $tplPath));
        } catch (MissingTemplateException $exception) {
            try {
                $this->render('shows/default');
            } catch (\Throwable $throwable) {
                if (Configure::read('debug')) {
                    throw $exception;
                }
                throw new NotFoundException(
                    ServiceMessages::getMissingPageMessage()
                );
            }
        }
    }

    public function events()
    {

    }

    public function marketers()
    {

    }
}
