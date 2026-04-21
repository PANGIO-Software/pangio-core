<?php
declare(strict_types = 1);

namespace Pangio\Core\Application;

use RuntimeException;

class View {
    /**
     * Renders a view file with optional parameters and returns the generated output as a string.
     *
     * @param string $view
     * @param array $params
     * @return string
     */
    public function render(string $view, array $params = []): string {
        $viewDirectory = dirname(__DIR__, 2) . '/app/Views/';
        $viewPath = $viewDirectory . '/' . $view . '.php';

        if (!is_file($viewPath)) {
            throw new RuntimeException("View not found: $viewPath");
        }

        extract($params, EXTR_SKIP);

        ob_start();
        include $viewPath;

        $content = ob_get_clean();

        return $content !== false ? $content : '';
    }
}