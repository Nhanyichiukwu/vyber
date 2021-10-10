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

//$routes->connect(
//    '/:username',
//    array(
//        'controller' => 'Profiles',
//        'action' => 'view'
//    ),
//    array(
//        'username' => '[a-zA-Z0-9_]+',
//        'routeClass' => 'UsernameRoute',
//    )
//);


//$usernameRoutes = clone $routes;
//
//$usernameRoutes->setRouteClass(UsernameRoute::class);
//$usernameRoutes->scope('/{username}', ['controller' => 'Profiles'], function (RouteBuilder $builder) {
//    $builder->connect('/', ['action' => 'index'], [
//        'routeClass' => 'UsernameRoute',
//        'pass' => ['username', 'path']
//    ])
//        ->setPatterns([
//            'username' => '[a-zA-Z0-9_]+',
//        ]);
//
//    $builder->fallbacks(UsernameRoute::class);
//});

$routes->setRouteClass(DashedRoute::class);

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

    $builder->connect('/logout', ['controller' => 'Auth', 'action' => 'logout']);

    $builder->connect('/post/*', ['controller' => 'Posts', 'action' => 'view']);

    $builder->connect('/people/*', ['controller' => 'People', 'action' => 'display']);

    $builder->connect('/music', ['controller' => 'Music', 'action' => 'index']);
    $builder->connect('/music/*', ['controller' => 'Music', 'action' => 'display']);


    $builder->scope('/media', function (RouteBuilder $builder) {
        $builder->connect('/static-bg/:img_name', [
            'controller' => 'DynamicFiles',
            'action' => 'load'
        ], ['routeClass' => 'DashedRoute',
            'pass' => [
                'img_name'
            ]
        ]);

        $builder->connect('/:refid', [
            'controller' => 'DynamicFiles',
            'action' => 'load'
        ], [
            'routeClass' => 'DashedRoute',
            'pass' => [
                'refid'
            ]
        ]);
    });
    $builder->scope('/events/', ['controller' => 'Events'], function (RouteBuilder $builder) {

        $builder->connect('/', ['action' => 'Events']);
        $builder->connect('/*', ['controller' => 'Events']);

        //    $routes->connect('/videos/edit/:id/*', ['controller' => 'DynamicFiles', 'action' => 'view'], ['routeClass' => 'DashedRoute', 'pass' => [
        //        'id', 'path'
        //    ]]);
    });
    $builder->scope('/music/', ['controller' => 'Music'], function (RouteBuilder $builder) {

        $builder->connect('/', ['action' => 'index']);
        $builder->connect('/songs', ['action' => 'songs']);
        $builder->connect('/videos', ['action' => 'videos']);
        $builder->connect('/lyrics', ['action' => 'lyrics']);
        $builder->connect('/my-music/*', ['action' => 'myMusic']);
        $builder->connect('/albums', ['action' => 'albums']);
        $builder->connect('/artists', ['action' => 'artists']);
        $builder->connect('/categories', ['action' => 'categories']);
        $builder->connect('/categories/{category}', [
            'action' => 'listCategoryItems'
        ], [
            'routeClass' => 'DashedRoute',
            'pass' => ['category']
        ]);
        $builder->connect('/genres', ['action' => 'genres']);
        $builder->connect('/trends', ['action' => 'trends']);
        $builder->connect('/discover/*', ['action' => 'discover']);
    });
//    $builder->get('/xhrs/*', ['Elements/ajaxified']);
//    $builder->get('/xhrs/{*}', [
//        'controller' => 'Xhrs',
//        'action' => 'ajaxify'
//    ]);
//    $builder->connect('/xhrs/{path}', ['action' => 'ajaxify'], [
//        'routeClass' => 'DashedRoute',
//        'pass' => ['path']
//    ]);

    $builder->scope(
        '/xhrs/:page',
        ['controller' => 'Xhrs'],
        function (RouteBuilder $builder) {
            $builder
                ->connect('/', ['action' => 'ajaxify'], [
                    'routeClass' => 'DashedRoute',
                    'pass' => ['page', 'path']
                ])
                ->setPatterns([
                    'page' => '[a-zA-Z0-9_]+',
                ]);
        }
    );

//    $builder->registerMiddleware(
//        'username_lookup',
//        UsernameLookupMiddleware::class
//    );
    $builder->scope(
        '/i/{username}',
        ['controller' => 'Profiles'],
        function (RouteBuilder $builder) {
            $builder
                ->connect('/', ['action' => 'index'], [
                    'routeClass' => 'DashedRoute',
                    'pass' => ['username', 'path']
                ])
                ->setPatterns([
                    'username' => '[a-zA-Z0-9_]+',
                ]);
        }
    );

    $builder->scope('/{username}/posts/{post_id}/', function (RouteBuilder $builder) {
        $builder->connect('/comments/', ['action' => 'comments'], [
            'routeClass' => 'DashedRoute',
            'pass' => ['username', 'post_id'],
            'post_id' => '[0-9]+'
        ]);

        $builder->connect('/comments/add_comment', ['action' => 'addComment'], [
            'routeClass' => 'DashedRoute',
            'pass' => ['username', 'post_id'],
            'post_id' => '[0-9]+'
        ]);

        $builder->connect('/comments/:comment_id', ['action' => 'readComment'], [
            'routeClass' => 'DashedRoute',
            'pass' => ['username', 'post_id', 'comment_id'],
            'post_id' => '[0-9]+',
            'comment_id' => '[0-9]+'
        ]);
        $builder->connect('/followers', ['controller' => 'Posts', 'action' => 'followers'], [
            'routeClass' => 'DashedRoute',
            'pass' => ['username', 'post_id'],
            'username' => '[a-zA-Z0-9-_]+',
            'post_id' => '[a-zA-Z0-9-_]+',
        ]);
        $builder->connect('/reactions', ['controller' => 'Posts', 'action' => 'reactions'], [
            'routeClass' => 'DashedRoute',
            'pass' => ['username', 'post_id'],
            'post_id' => '[a-zA-Z0-9-_]+',
        ]);

        $builder->connect('/', ['controller' => 'Posts', 'action' => 'read'], [
            'routeClass' => 'DashedRoute',
            'pass' => ['username', 'post_id'],
            'post_id' => '[a-zA-Z0-9-_]+'
        ]);
    });
/*
    $routes->connect('/e', ['controller' => 'Error']);
    $routes->connect('/notifications', ['controller' => 'notifications', 'action' => 'index']);
    $routes->connect('/notifications/*', ['controller' => 'notifications', 'action' => 'view']);
    $routes->connect('/calendar/:action', ['action' => 'goto-date'], ['routeClass' => 'DashedRoute']);
    $routes->connect('/message/*', ['controller' => 'Messages', 'action' => 'view']);
    $routes->connect('/content', ['controller' => 'Error']);
*/

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

//$routes->scope('/my-network/', ['controller' => 'MyNetwork'], function (RouteBuilder $builder) {
//    $builder->connect('/connections', ['action' => 'connections']);
//    $builder->connect('/connections/pending', ['action' => 'pendingConnections']);
//    $builder->connect('/connections/sent-requests', ['action' => 'requestedConnections']);
//    $builder->connect('/connections/{category}', ['action' => 'connectionsByCategory']);
//    $builder->connect('/introductions', ['action' => 'introductions']);
//    $builder->connect('/introductions/sent', ['action' => 'sentIntroductions']);
//    $builder->connect('/introductions/pending', ['action' => 'pendingIntroductions']);
//    $builder->connect('/recommendations', ['action' => 'recommendations']);
//    $builder->connect('/recommendations/sent', ['action' => 'sentRecommendations']);
//    $builder->connect('/recommendations/pending', ['action' => 'pendingRecommendations']);
//    $builder->connect('/meetings', ['action' => 'meetings']);
//    $builder->connect('/meetings/requested', ['action' => 'requestedMeetings']);
//    $builder->connect('/meetings/pending', ['action' => 'pendingMeetings']);
//    $builder->connect('/', ['action' => 'index']);
//
//    $builder->fallbacks(DashedRoute::class);
//});

$routes->scope('/notifications/', ['controller' => 'Notifications'], function (RouteBuilder $routes) {
    $routes->connect('/', ['action' => 'index']);
    $routes->connect('/read', ['action' => 'read']);
    $routes->connect('/unread', ['action' => 'unread']);
});

$routes->scope('/videos/', ['controller' => 'Videos'], function (RouteBuilder $builder) {
    $builder->connect('/', ['action' => 'index']);

    $builder->fallbacks(DashedRoute::class);
});

// $routes->connect('/videos/edit/:id/*', ['controller' => 'DynamicFiles', 'action' => 'view'], ['routeClass' => 'DashedRoute', 'pass' => [
//        'id', 'path'
//    ]]);


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
