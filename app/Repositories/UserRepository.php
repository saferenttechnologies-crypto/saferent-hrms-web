<?php
declare(strict_types=1);
namespace App\Repositories;
use App\Core\Database;

final class UserRepository
{
    public function __construct(private Database $db) {}
    public function findByEmail(string $email): ?array { return $this->db->fetch('SELECT * FROM users WHERE email = :email AND deleted_at IS NULL', ['email'=>$email]); }
    public function dashboardMetrics(): array { return $this->db->fetch('SELECT COUNT(*) total_users, SUM(status="active") active_users FROM users') ?? ['total_users'=>0,'active_users'=>0]; }
}
