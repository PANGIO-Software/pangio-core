<?php
namespace App\Models;

use Pangio\Core\Infrastructure\Database;
use Pangio\Core\Infrastructure\Logger;

class Base {
    protected Logger $logger;
    protected string $table;
    protected array $fields;
    protected Database $db;

    public function __construct() {
        $this->logger = new Logger();
        $this->db = new Database();
    }
}