<?php
/**
 * Routes configuration.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * It's loaded within the context of `Application::routes()` method which
 * receives a `RouteBuilder` instance `$routes` as method argument.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use App\Middleware\UsernameLookupMiddleware;
use App\Routing\Route\UsernameRoute;
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

/*
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 */
/** @var \Cake\Routing\RouteBuilder $routes */




//$usernameRoutes = clone $routes;

$routes->setRouteClass(DashedRoute::class);


$routes->scope('/:username', ['controller' => 'Profiles'], function (RouteBuilder $builder) {
    $builder
        ->connect('/', ['action' => 'index'], [
            'routeClass' => 'DashedRoute',
            'pass' => ['username', 'path']
        ])
        ->setPatterns([
            'username' => '[a-zA-Z0-9_]+',
        ]);

//    $builder->connect('/:action /*', ['action' => 'display']);
    $builder->connect('/*', ['action' => 'display'], [
        'routeClass' => 'DashedRoute',
        'pass' => ['username','path']
    ]);
//    $builder
//        ->connect('/:action/*', ['action' => 'display'], [
//            'routeClass' => 'DashedRoute',
//            'pass' => ['username', 'path']
//        ])
//        ->setPatterns([
//            'username' => '[a-zA-Z0-9_]+',
////            'action' => '[a-zA-Z0-9_-]+',
//        ]);

//    $builder
//        ->connect('/:action/*', [], [
//            'routeClass' => 'DashedRoute',
//            'pass' => ['username', 'path']
//        ])
//        ->setPatterns([
//            'username' => '[a-zA-Z0-9_]+',
//        ]);
});
$routes->scope('/groups/', ['controller' => 'Groups'], function (RouteBuilder $builder) {
    $builder->connect('/', ['action' => 'index']);
//    $builder->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);
    $builder->connect('/:action/*', [], ['routeClass' => 'DashedRoute']);
});

$routes->scope('/', function (RouteBuilder $builder) {
    /**
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, src/Template/Index/common.ctp)...
     */
    $builder->connect('/', ['controller' => 'Home']);

    /**
     * ...and connect the rest of 'Pages' controller's URLs.
     */

    $builder->connect('/settings', ['controller' => 'Settings', 'action' => 'index']);
    $builder->connect('/settings/*', ['controller' => 'Settings', 'action' => 'display']);
    $builder->connect('/activities', ['controller' => 'Activities', 'action' => 'index']);
    $builder->connect('/activities/*', ['controller' => 'Activities', 'action' => 'display']);
    $builder->connect('/notifications', ['controller' => 'Notifications', 'action' => 'index']);
    $builder->connect('/notifications/*', ['controller' => 'Notifications', 'action' => 'display']);

    $builder->connect('/signup', ['controller' => 'Signup']);
    $builder->connect('/login', ['controller' => 'Login']);
    $builder->connect('/logout', ['controller' => 'Auth', 'action' => 'logout']);
    $builder->connect('/post/*', ['controller' => 'Posts', 'action' => 'view']);
    $builder->connect('/people', ['controller' => 'People', 'action' => 'index']);
    $builder->connect('/people/*', ['controller' => 'People', 'action' => 'display']);
//    $builder->connect('/people/similar-people/*', ['controller' => 'People', 'action' => 'display']);
    $builder->connect('/music', ['controller' => 'Music', 'action' => 'index']);
    $builder->connect('/music/*', ['controller' => 'Music', 'action' => 'display']);

    $builder->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);
    $builder->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);
    $builder->connect('/feeds', ['controller' => 'Feeds']);

    /**
     * Connect catchall routes for all controllers.
     *
     * Using the argument `DashedRoute`, the `fallbacks` method is a shortcut for
     *
     * ```
     * $routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);
     * $routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);
     * ```
     *
     * Any route class can be used with this method, such as:
     * - DashedRoute
     * - InflectedRoute
     * - Route
     * - Or your own route class
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
    $builder->fallbacks(DashedRoute::class);
});

$routes->scope('/media', ['controller' => 'DynamicFiles'], function (RouteBuilder $builder) {
    $builder->connect('/', ['action' => 'index']);
//    $builder->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);
    $builder->connect('/:action/*', [], ['routeClass' => 'DashedRoute']);

//    $builder->connect('/static-bg/:img_name', [
//        'controller' => 'DynamicFiles',
//        'action' => 'load'
//    ], ['routeClass' => 'DashedRoute',
//        'pass' => [
//            'img_name'
//        ]
//    ]);
//    $builder->connect('/*', [
//        'controller' => 'DynamicFiles',
//        'action' => 'load'
//    ], ['routeClass' => 'DashedRoute',
////        'pass' => [
////            'img_name'
////        ]
//    ]);
//
//    $builder->connect('/:refid', [
//        'controller' => 'DynamicFiles',
//        'action' => 'media'
//    ], [
//        'routeClass' => 'DashedRoute',
//        'pass' => [
//            'refid'
//        ]
//    ]);
});
$routes->scope('/events/', ['controller' => 'Events'], function (RouteBuilder $builder) {
    $builder->connect('/', ['action' => 'index']);
    $builder->connect('/*', ['action' => 'display']);
});
$routes->scope('/posts/', ['controller' => 'Posts'], function (RouteBuilder $builder) {
    $builder->connect('/', ['action' => 'index']);
//    $builder->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);
    $builder->connect('/:action/*', [], ['routeClass' => 'DashedRoute']);
});
$routes->scope('/explore/', ['controller' => 'Explore'], function (RouteBuilder $builder) {
    $builder->connect('/', ['action' => 'index']);
//    $builder->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);
    $builder->connect('/:action/*', [], ['routeClass' => 'DashedRoute']);
});
$routes->scope('/talents-hub/', ['controller' => 'TalentsHub'], function (RouteBuilder $builder) {
    $builder->connect('/', ['action' => 'index']);
    $builder->connect('/:action/*', [], ['routeClass' => 'DashedRoute']);
});
$routes->scope('/my-network/', ['controller' => 'MyNetwork'], function (RouteBuilder $builder) {
    $builder->connect('/', ['action' => 'index']);
    $builder->connect('/:action/*', [], ['routeClass' => 'DashedRoute']);
});
$routes->scope('/hall-of-fame/', ['controller' => 'HallOfFame'], function (RouteBuilder $builder) {
    $builder->connect('/', ['action' => 'index']);
    $builder->connect('/:action/*', [], ['routeClass' => 'DashedRoute']);
});
$routes->scope('/groups/', ['controller' => 'Groups'], function (RouteBuilder $builder) {
    $builder->connect('/', ['action' => 'index']);
//    $builder->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);
    $builder->connect('/:action/*', [], ['routeClass' => 'DashedRoute']);
});
$routes->scope('/support/', ['controller' => 'Support'], function (RouteBuilder $builder) {
    $builder->connect('/', ['action' => 'index']);
    $builder->connect('/:action/*', [], ['routeClass' => 'DashedRoute']);
});
//$routes->scope('/talent-hub/', ['controller' => 'TalentHub'], function (RouteBuilder $builder) {
//    $builder->connect('/', ['action' => 'index']);
////    $builder->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);
//    $builder->connect('/:action/*', [], ['routeClass' => 'DashedRoute']);
//});

$routes->scope(
    '/xhrs',
    ['controller' => 'Xhrs'],
    function (RouteBuilder $builder) {
        $builder
            ->connect('/*', ['action' => 'ajaxify'], [
                'routeClass' => 'DashedRoute',
                'pass' => ['page', 'path']
            ])
            ->setPatterns([
                'page' => '[a-zA-Z0-9_]+',
            ]);
//        $builder
//            ->connect('/f/*', ['action' => 'fetch'], [
//                'routeClass' => 'DashedRoute',
//                'pass' => ['page', 'path']
//            ])
//            ->setPatterns([
//                'page' => '[a-zA-Z0-9_]+',
//            ]);
//        $builder->connect('/:action/*', [], ['routeClass' => 'DashedRoute']);
//        $builder->fallbacks(DashedRoute::class);
    }
);

$routes->scope(
    '/search',
    ['controller' => 'Search'],
    function (RouteBuilder $builder) {
        $builder->connect('/:action/*', [], ['routeClass' => 'DashedRoute']);
    }
);



//$usernameRoutes->scope('/:username', ['controller' => 'Profiles'], function (RouteBuilder $builder) {
//    $builder->connect('/', ['action' => 'index'], [
//        'routeClass' => 'UsernameRoute',
//        'pass' => ['username', 'path']
//    ])
//        ->setPatterns([
//            'username' => '[a-zA-Z0-9_]+',
//        ]);
//
////    $builder->fallbacks(UsernameRoute::class);
//});
//$routes->scope('/{username}/posts/{post_id}/', function (RouteBuilder $builder) {
//    $builder->connect('/comments/', ['action' => 'comments'], [
//        'routeClass' => 'DashedRoute',
//        'pass' => ['username', 'post_id'],
//        'post_id' => '[0-9]+'
//    ]);
//
//    $builder->connect('/comments/add_comment', ['action' => 'addComment'], [
//        'routeClass' => 'DashedRoute',
//        'pass' => ['username', 'post_id'],
//        'post_id' => '[0-9]+'
//    ]);
//
//    $builder->connect('/comments/:comment_id', ['action' => 'readComment'], [
//        'routeClass' => 'DashedRoute',
//        'pass' => ['username', 'post_id', 'comment_id'],
//        'post_id' => '[0-9]+',
//        'comment_id' => '[0-9]+'
//    ]);
//    $builder->connect('/followers', ['controller' => 'Posts', 'action' => 'followers'], [
//        'routeClass' => 'DashedRoute',
//        'pass' => ['username', 'post_id'],
//        'username' => '[a-zA-Z0-9-_]+',
//        'post_id' => '[a-zA-Z0-9-_]+',
//    ]);
//    $builder->connect('/reactions', ['controller' => 'Posts', 'action' => 'reactions'], [
//        'routeClass' => 'DashedRoute',
//        'pass' => ['username', 'post_id'],
//        'post_id' => '[a-zA-Z0-9-_]+',
//    ]);
//
//    $builder->connect('/', ['controller' => 'Posts', 'action' => 'read'], [
//        'routeClass' => 'DashedRoute',
//        'pass' => ['username', 'post_id'],
//        'post_id' => '[a-zA-Z0-9-_]+'
//    ]);
//});

/**
 * If you need a different set of middleware or none at all,
 * open new scope and define routes there.
 *
 * ```
 * Router::scope('/api', function (RouteBuilder $routes) {
 *     // No $routes->applyMiddleware() here.
 *     // Connect API actions here.
 * });
 * ```
 */

/**
 * Plugins Router
 */

/**
 * Messenger Plugin
 */
$routes->scope('/messages', function ($routes) {
    // Connect other routes.
//    $routes->scope('/', function ($routes) {
//        $routes->loadPlugin('Messenger');
//    });

//    $routes->scope('/messenger', function ($routes) {
//        $routes->loadPlugin('Messenger');
//    });
});

$routes->scope('/messages/', ['controller' => 'Messages'], function (RouteBuilder $builder) {
    $builder->loadPlugin('Messenger');
    $builder->connect('/', ['action' => 'index']);
    $builder->connect('/:action/*', [], ['routeClass' => 'DashedRoute']);
});

/**
 * Administrator
 */
//$routes->scope('/console', function ($routes) {
//    // Connect other routes.
//    $routes->scope('/', function ($routes) {
//        $routes->loadPlugin('AdminConsole');
//        $routes->connect('/', [ 'controller' => 'Index']);
//    });
//
//
//});

/*
 * If you need a different set of middleware or none at all,
 * open new scope and define routes there.
 *
 * ```
 * $routes->scope('/api', function (RouteBuilder $builder) {
 *     // No $builder->applyMiddleware() here.
 *
 *     // Parse specified extensions from URLs
 *     // $builder->setExtensions(['json', 'xml']);
 *
 *     // Connect API actions here.
 * });
 * ```
 */
