<?php
declare(strict_types = 1);

namespace Pangio\Core\Infrastructure;

use Pangio\Core\System\Config;
use RuntimeException;

class Logger {
    private string $logsDir;

    public function __construct() {
        $this->logsDir = $_ENV['LOGS_DIR'] ?? Config::get('app.logsDir');
    }

    /**
     * Writes a log entry with type and timestamp to a daily log file, creating or appending to the file and
     * throwing an exception if the file cannot be opened.
     *
     * @param string $type
     * @param string $message
     * @return void
     */
    public function log(string $type, string $message) :void {
        $date = date('Ymd');
        $timestamp = date('d.m.Y - H:i:s');
        $path = dirname(__DIR__, 2) . "$this->logsDir/$date.log";

        $handle = fopen($path, 'a');

        if (!$handle) {
            throw new RuntimeException("Unable to open log file: $path");
        }

        fwrite($handle, "$timestamp - $type - $message" . PHP_EOL);
        fclose($handle);
    }
}