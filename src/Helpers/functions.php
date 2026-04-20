<?php

use Pangio\Core\System\Config;

if (!function_exists('baseURL')) {
    /**
     * Builds a URL out of the config baseURL and the given URI and returns it.
     *
     * @param string $uri
     * @return string
     */
    function baseURL(string $uri = '') :string {
        $baseURL = $_ENV['BASE_URL'] ?? Config::get('app.baseURL');

        return $baseURL . $uri;
    }
}