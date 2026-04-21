<?php
namespace App\Models;

use Pangio\Core\Infrastructure\Database;

class Base {
    protected string $table;
    protected array $fields;
    protected Database $db;

    public function __construct() {
        $this->db = new Database();
    }
}