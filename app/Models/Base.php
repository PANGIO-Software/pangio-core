<?php
namespace App\Models;

use Pangio\Core\Infrastructure\Database;
use Pangio\Core\Infrastructure\Logger;
use Exception;

class Base {
    protected Logger $logger;
    protected string $table;
    protected array $fields;
    protected Database $db;

    public function __construct() {
        $this->logger = new Logger();
        $this->db = new Database();
    }

    /**
     * Retrieves all entries from the database table, filtered by where conditions.
     *
     * @param array $wheres Assoziatives Array [Spalte => Wert]
     * @return array
     */
    public function all(array $wheres = []): array {
        $sql = "SELECT " . implode(', ', $this->fields) . " FROM {$this->table}";

        if (!empty($wheres)) {
            $clauses = array_map(fn($field) => "{$field} = :{$field}", array_keys($wheres));
            $sql .= " WHERE " . implode(' AND ', $clauses);
        }

        try {
            return $this->db->select($sql, $wheres);
        }
        catch (Exception $exception) {
            $this->logger->log('error', 'Failed to fetch database data: ' . $exception->getMessage());

            return [];
        }
    }

    /**
     * Retrieves a single entry from the database entry, filtered by id.
     *
     * @param int $id
     * @return array
     */
    public function find(int $id) :array {
        $sql = "SELECT " . implode(', ', $this->fields) . " FROM {$this->table} WHERE id = :id";

        try {
            $result = $this->db->select($sql, ['id' => $id]);

            return $result[0] ?? [];
        }
        catch (Exception $exception) {
            $this->logger->log('error', 'Failed to fetch database record: ' . $exception->getMessage());

            return [];
        }
    }

    /**
     * Inserts a new entry into the database table.
     *
     * @param array $params
     * @return bool
     */
    public function insert(array $params) :bool {
        $keys = array_keys($params);
        $fields = implode(', ', $keys);
        $placeholders = ':' . implode(', :', $keys);
        $sql = "INSERT INTO {$this->table} ({$fields}) VALUES ({$placeholders})";

        try {
            return $this->db->execute($sql, $params);
        }
        catch (Exception $exception) {
            $this->logger->log('error', 'Failed to insert database record: ' . $exception->getMessage());

            return false;
        }
    }
}