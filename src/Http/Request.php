<?php
declare(strict_types = 1);

namespace Pangio\Core\Http;

class Request {
    /**
     * Retrieves HTTP method (POST, GET, etc.)
     *
     * @return string
     */
    public static function method() :string {
        return strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
    }

    /**
     * Retrieves GET parameter.
     *
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public static function get(string $key, mixed $default = null) :mixed {
        return $_GET[$key] ?? $default;
    }

    /**
     * Retrieves POST parameter.
     *
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public static function post(string $key, mixed $default = null) :mixed {
        return $_POST[$key] ?? $default;
    }

    /**
     * Retrieves all request data (GET & POST)
     *
     * @return array
     */
    public static  function all() :array {
        return array_merge($_GET, $_POST);
    }

    /**
     * Validates that all required request fields are present and not empty, returning false if any are missing.
     *
     * @param array $requiredFields
     * @param string $method
     * @return bool
     */
    public static function validate(array $requiredFields, $method = 'POST') :bool {
        $input = $method === 'POST' ? $_POST : $_GET;

        foreach ($requiredFields as $field) {
            if (empty($input[$field])) {
                return false;
            }
        }

        return true;
    }
}