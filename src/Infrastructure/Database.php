<?php
declare(strict_types = 1);

namespace Pangio\Core\Infrastructure;

use Pangio\Core\System\Config;
use RuntimeException;
use PDOException;
use Exception;
use PDO;

class Database {
    private string $host, $user, $pass, $db;
    private static ?PDO $instance = null;

    public function __construct() {
        $config = Config::get('database');

        $this->host = $_ENV['DB_HOST'] ?? $config['host'];
        $this->user = $_ENV['DB_USER'] ?? $config['user'];
        $this->pass = $_ENV['DB_PASS'] ?? $config['password'];
        $this->db   = $_ENV['DB_NAME'] ?? $config['name'];
    }

    /**
     * Returns a single PDO instance (singleton).
     *
     * @return PDO
     */
    public function connect(): PDO {
        try {
            $connection = new PDO(
                "mysql:host$this->host;dbname=$this->db", $this->user, $this->pass
            );

            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            self::$instance = $connection;

        } catch (PDOException $exception) {
            throw new RuntimeException('Database connection failed: ' . $exception->getMessage(), 0, $exception);
        }

        return self::$instance;
    }

    /**
     * Execute a SELECT query and return all results.
     *
     * @param string $query
     * @param array $params
     * @return array
     * @throws Exception
     */
    public function select(string $query, array $params = []) :array {
        $stmt = $this->connect()->prepare($query);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    /**
     * Execute INSERT/UPDATE/DELETE query.
     *
     * @param string $query
     * @param array $params
     * @return bool
     * @throws Exception
     */
    public function execute(string $query, array $params = []) :bool {
        $stmt = $this->connect()->prepare($query);

        return $stmt->execute($params);
    }
}