<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\View\Exception\MissingTemplateException;

/**
 * Static content controller
 *
 * This controller will render views from Template/Home/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class HomeController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->Auth->allow(['index','starter']);
    }

    /**
     * @return \Cake\Http\Response|null|void
     */
    public function index()
    {
        if (!$this->AuthServiceProvider->isFirstLaunch()) {
            if (!$this->AuthServiceProvider->isAuthenticated()) {
                return $this->AuthServiceProvider->requireAuthentication();
            }
            return $this->redirect(
                $this->Auth->redirectUrl()
            );
        } else {
            $this->AuthServiceProvider->launchApp();
        }
    }

    public function dashboard(...$path)
    {
    }

    /**
     * Displays a view
     *
     * @param array ...$path Path segments.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Http\Exception\ForbiddenException When a directory traversal attempt.
     * @throws \Cake\Http\Exception\NotFoundException When the view file could not
     *   be found or \Cake\View\Exception\MissingTemplateException in debug mode.
     */
//    public function display($path)
//    {
//        $count = count($path);
//        if (!$count) {
//            return $this->redirect('/');
//        }
//        if (in_array('..', $path, true) || in_array('.', $path, true)) {
//            throw new ForbiddenException();
//        }
//        $page = $subpage = null;
//
//        if (!empty($path[0])) {
//            $page = $path[0];
//        }
//        if (!empty($path[1])) {
//            $subpage = $path[1];
//        }
//        $this->set(compact('page', 'subpage'));
//
//        try {
//            $this->render(implode('/', $path));
//        } catch (MissingTemplateException $exception) {
//            if (Configure::read('debug')) {
//                throw $exception;
//            }
//            throw new NotFoundException();
//        }
//    }

    public function starter(...$path)
    {
        if (!count($path)) {
            $path += ['starter-screens','welcome'] ;
        }
        return $this->display($path);
    }
}
