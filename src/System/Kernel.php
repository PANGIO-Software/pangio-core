<?php
declare(strict_types = 1);

namespace Pangio\Core\System;

use Dotenv\Dotenv;

class Kernel {
    /**
     * Indicates whether the kernel has already been booted.
     *
     * @var bool
     */
    private static bool $booted = false;

    public static function run() :void {
        self::boot();
    }

    /**
     * Bootstraps all core systems of the framework.
     *
     * @return void
     */
    private static function boot() :void {
        if (self::$booted) {
            return;
        }

        self::loadEnv();
        self::loadConfig();
        self::loadSession();

        self::$booted = true;
    }

    /**
     * Loads environment variables from the .env file.
     *
     * @return void
     */
    private static function loadEnv() :void {
        $path = dirname(__DIR__, 2);

        if (!file_exists("$path/.env")) {
            return;
        }

        $dotenv = Dotenv::createImmutable($path);
        $dotenv->safeLoad();
    }

    /**
     * Loads config data from the /config folder.
     *
     * @return void
     */
    private static function loadConfig() :void {
        Config::load();
    }

    /**
     * Starts a PHP session.
     *
     * @return void
     */
    private static function loadSession() :void {
        Session::start();
    }
}