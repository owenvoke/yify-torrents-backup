<?php

namespace pxgamer\YifyTorrents\Routing;

use System\App;
use System\Request;
use System\Route;

/**
 * Class Router
 */
class Router
{
    public function __construct()
    {
        $app = App::instance();
        $app->request = Request::instance();
        $app->route = Route::instance($app->request);
        $route = $app->route;

        // Main
        $route->any('/', ['pxgamer\YifyTorrents\Modules\Base\Controller', 'index']);
        $route->any('/search', ['pxgamer\YifyTorrents\Modules\Torrents\Controller', 'search']);
        $route->any('/torrent/{id}:([0-9]+)', ['pxgamer\YifyTorrents\Modules\Torrents\Controller', 'show']);

        // Route fallback for page not found
        $route->any('/*', ['pxgamer\YifyTorrents\Modules\Base\Controller', 'errorNotFound']);

        $route->end();
    }

    public static function redirect($location = '/')
    {
        if (!headers_sent()) {
            header('Location: ' . $location);
        }
    }
}
