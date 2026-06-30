<?php
declare(strict_types=1);
namespace App\Core;
use PDO;

final class Database
{
    public function __construct(private PDO $pdo) {}
    public function pdo(): PDO { return $this->pdo; }
    public function fetch(string $sql, array $params = []): ?array { $stmt=$this->run($sql,$params); $row=$stmt->fetch(); return $row ?: null; }
    public function fetchAll(string $sql, array $params = []): array { return $this->run($sql,$params)->fetchAll(); }
    public function execute(string $sql, array $params = []): bool { return $this->run($sql,$params)->rowCount() >= 0; }
    private function run(string $sql, array $params): \PDOStatement { $stmt=$this->pdo->prepare($sql); $stmt->execute($params); return $stmt; }
}
