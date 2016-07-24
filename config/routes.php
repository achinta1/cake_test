<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

/**
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
 *
 */
Router::defaultRouteClass('DashedRoute');
 // echo Router::url(['controller' => 'Articles', 'action' => 'view', 'id' => 15]); // Will output "/articles/15"
 //echo Router::url(['_name' => 'login']);// Will output/login
Router::scope('/', function (RouteBuilder $routes) {
    /**
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, src/Template/Pages/home.ctp)...
     */
   // $routes->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);

    /**
     * ...and connect the rest of 'Pages' controller's URLs.
     */
   // $routes->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);

    
    $routes->connect('/', ['controller' => 'Articles', 'action' => 'index']);
    
    
    
    /**
     * Connect catchall routes for all controllers.
     *
     * Using the argument `DashedRoute`, the `fallbacks` method is a shortcut for
     *    `$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);`
     *    `$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);`
     *   $routes->connect('/:controller/\d+', [], ['routeClass' => 'DashedRoute']); \d+ regular expression so that only digits are matched
     *
     *  $routes->connect('/:controller/:id',['action' => 'view'],['id' => '[0-9]+']);
     *
     *  The DashedRoute class will make sure that the :controller and :plugin parameters are correctly lowercased and dashed.
     *  $routes->connect('/:controller/:id',['action' => 'view'],['id' => '[0-9]+', 'routeClass' => 'DashedRoute']);
     *
     *
     *  $routes->connect('/:controller/:year/:month/:day',['action' => 'index'],['year' => '[12][0-9]{3}','month' => '0[1-9]|1[012]','day' => '0[1-9]|[12][0-9]|3[01]']);
     *
     *
     *  Passing Parameters to Action
     *  $routes->connect('/blog/:id-:slug', // E.g. /blog/3-CakePHP_Rocks
        ['controller' => 'Blogs', 'action' => 'view'],
        [ // Define the route elements in the route template
            // to pass as function arguments. Order matters since this
            // will simply map ":id" to $articleId in your action
            'pass' => ['id', 'slug'],
            // Define a pattern that `id` must match.
            'id' => '[0-9]+'
        ]
        );
        //=======controller like ==========
        public function view($articleId = null, $slug = null){// Some code here...}
        
     *  
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
    $routes->fallbacks('DashedRoute');
});

//=================pre fix===============
/*
 *Router::scope('/api', ['_namePrefix' => 'api:'], function ($routes) {
    // This route's name will be `api:ping`
    $routes->connect('/ping', ['controller' => 'Pings'], ['_name' => 'ping']);
});
 *
 * Generate a URL for the ping route
    Router::url(['_name' => 'api:ping']);

    // Use namePrefix with plugin()
    Router::plugin('Contacts', ['_namePrefix' => 'contacts:'], function ($routes) {
    // Connect routes.
    });

    // Or with prefix()
    Router::prefix('Admin', ['_namePrefix' => 'admin:'], function ($routes) {
    // Connect routes.
    });
 *
 *  Router::prefix('admin', ['param' => 'value'], function ($routes) {
    // Routes connected here are prefixed with '/admin' and
    // have the 'param' routing key set.
    $routes->connect('/:controller');
    });
    
    
    //====================SEO-Friendly Routing ==================
    Router::plugin('ToDo', ['path' => 'to-do'], function ($routes) {
    $routes->fallbacks('DashedRoute');
    });
    
    //==============Routing File Extensions================
    Router::scope('/page', function ($routes) {
    $routes->extensions(['json', 'xml', 'html']);
    $routes->connect(
        '/:title',
        ['controller' => 'Pages', 'action' => 'view'],
        [
            'pass' => ['title']
        ]
    );
    });
    and on create must use
    $this->Html->link('Link title',['controller' => 'Pages', 'action' => 'view', 'title' => 'super-article', '_ext' => 'html']);
    
    //==================Creating RESTful Routes=================
    Router::scope('/', function ($routes) {
    $routes->extensions(['json']);
    $routes->resources('Recipes');
    });
    //**** foloow http://book.cakephp.org/3.0/en/development/routing.html
    
    //=========================Mapping Additional Resource Routes==============
    $routes->resources('Articles', [
        'map' => [
            'deleteAll' => [
                'action' => 'deleteAll',
                'method' => 'DELETE'
            ]
        ]
     ]);// This would connect /articles/deleteAll
     
     $routes->resources('Articles', [
    'map' => [
            'updateAll' => [
                'action' => 'updateAll',
                'method' => 'DELETE',
                'path' => '/update_many'
            ],
        ]
    ]);// This would connect /articles/update_many
    
    //===================Redirect Routing =====================
    Router::scope('/', function ($routes) {
        $routes->redirect('/articles/*', 'http://google.com', ['status' => 302]); //his would redirect /articles/* to http://google.com with a HTTP status of 302.
    });
*/

/**
 * Load all plugin routes.  See the Plugin documentation on
 * how to customize the loading of plugin routes.
 */
Plugin::routes();
