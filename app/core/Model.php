<?php
declare(strict_types=1);

namespace App\Core;

use PDO;

abstract class Model
{
    protected PDO $db;
    protected string $table = '';

    public function __construct()
    {
        $this->db = \Database::connection();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function all(): array
    {
        return $this->db->query("SELECT * FROM {$this->table}")->fetchAll();
    }
}