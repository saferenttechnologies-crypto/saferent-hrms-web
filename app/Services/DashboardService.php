<?php
declare(strict_types=1);
namespace App\Services;
use App\Core\Database;

final class DashboardService
{
    public function __construct(private Database $db) {}
    public function metrics(): array
    {
        return [
            'employees' => $this->count('employees', 'employment_status="active"'),
            'interns' => $this->count('interns', 'status IN ("active","ongoing")'),
            'departments' => $this->count('departments'),
            'tasks' => $this->count('tasks', 'status NOT IN ("done","cancelled")'),
            'attendance_today' => $this->count('attendance', 'attendance_date = CURDATE()'),
            'pending_approvals' => $this->count('approval_requests', 'status="pending"'),
        ];
    }
    private function count(string $table, string $where='1=1'): int { return (int)($this->db->fetch("SELECT COUNT(*) c FROM {$table} WHERE {$where}")['c'] ?? 0); }
}
