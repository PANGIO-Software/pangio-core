<?php

use Pangio\Core\System\Config;
use Pangio\Core\Http\Router;

if (!function_exists('baseURL')) {
    /**
     * Builds a URL out of the config baseURL and the given URI and returns it.
     *
     * @param string $path
     * @return string
     */
    function baseURL(string $path = ''): string {
        return Router::baseURL($path);
    }
}

if (!function_exists('trans')) {
    /**
     * @param string $key
     * @param array $replace
     * @return string
     */
    function trans(string $key, array $replace = []) :string {
        $locale = $_ENV['APP_LOCALE'] ?? Config::get('app.locale') ?? 'de';

        static $lines = [];

        if (!isset($lines[$locale])) {
            $path = __DIR__ . "/../Lang/{$locale}.php";
            $path = dirname(__DIR__, 2) . "/app/Lang/$locale.php";

            $lines[$locale] = file_exists($path)
                ? require $path
                : [];
        }

        $value = dataGet($lines[$locale], $key, $key);

        foreach ($replace as $search => $replaceValue) {
            $value = str_replace(":$search", $replaceValue, $value);
        }

        return $value;
    }
}

if (!function_exists('dataGet')) {
    /**
     * @param array $array
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    function dataGet(array $array, string $key, mixed $default = null) :mixed {
        foreach (explode('.', $key) as $segment) {
            if (!is_array($array) || !array_key_exists($segment, $array)) {
                return $default;
            }
            $array = $array[$segment];
        }

        return $array;
    }
}

if (!function_exists('esc')) {
    /**
     * Escapes a string for safe HTML output by converting special characters to their corresponding HTML entities.
     *
     * @param string $string
     * @return string
     */
    function esc(string $string) :string {
        return htmlspecialchars($string, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8', false);
    }
}

if (!function_exists('contains')) {
    /**
     * Checks whether a string contains a given substring.
     *
     * @param string $haystack
     * @param string $needle
     * @return bool
     */
    function contains(string $haystack, string $needle) :bool {
        return str_contains($haystack, $needle);
    }
}