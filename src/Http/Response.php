<?php
declare(strict_types = 1);

namespace Pangio\Core\Http;

use JetBrains\PhpStorm\NoReturn;

class Response {
    /**
     * Sends a plain text response.
     *
     * @param string $content
     * @param int $statusCode
     * @return void
     */
    public static function send(string $content, int $statusCode = 200): void {
        http_response_code($statusCode);
        echo $content;
    }

    /**
     * Sends a JSON response.
     *
     * @param array $data
     * @param int $statusCode
     * @return void
     */
    public static function json(array $data, int $statusCode = 200): void {
        http_response_code($statusCode);

        header('Content-Type: application/json');

        echo json_encode($data);
    }

    /**
     * Redirects to another URL.
     *
     * @param string $url
     * @param int $statusCode
     * @return void
     */
    #[NoReturn]public static function redirect(string $url, int $statusCode = 302): void {
        http_response_code($statusCode);
        header("Location: $url");
        exit;
    }
}