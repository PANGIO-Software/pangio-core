<?php
declare(strict_types = 1);

namespace Pangio\Core\Http;

use Pangio\Core\System\Config;

class Router {
    /**
     * Iterates through registered routes to resolve the current request, instantiating the corresponding controller
     * and executing its method, or returning a 404 error if no match is found.
     *
     * @return void
     */
    public static function run() :void {
        $routes = Config::get('routes');
        $route = false;

        foreach ($routes as $key => $value) {
            $controller = 'App\\Controllers\\' . $value[0];
            $method = $value[1];
            $key = $key === 0 ? '' : $key;

            $route = self::router($key, static function ($param = null) use ($controller, $method) {
                $class = new $controller;
                if ($param !== null) {
                    $class->$method($param);
                } else {
                    $class->$method();
                }
            });

            if ($route) {
               break;
            }
        }

        if (!$route) {
            header("HTTP/1.0 404 Not Found");
            echo "404 Not Found";
            exit();
        }
    }

    /**
     * Matches the current request URL against a defined route pattern and executes the associated callback with any
     * captured parameters.
     *
     * @param string $route
     * @param mixed $callback
     * @return bool
     */
    private static function router(string $route, mixed $callback) :bool {
        $fullURL = self::getFullURL();
        $urlParts = explode('/', trim(str_replace(baseURL(), '', $fullURL), '/'));
        $requestedRoute = implode('/', $urlParts);
        $routeRegex = preg_replace('/:[^\/]+/', '([^\/]+)', $route);

        if (preg_match("~^$routeRegex$~", $requestedRoute, $matches)) {
            call_user_func_array($callback, array_slice($matches, 1));
            return true;
        }

        return false;
    }

    /**
     * Constructs the absolute URL by combining the base path with the current request URI.
     *
     * @return string
     */
    private static function getFullURL() :string {
        return baseURL($_SERVER['REQUEST_URI'] ?? '/');
    }
}