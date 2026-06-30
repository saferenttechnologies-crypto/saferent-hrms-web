<?php
declare(strict_types=1);
namespace App\Services;
use App\Core\Security; use App\Repositories\UserRepository;

final class AuthService
{
    public function __construct(private UserRepository $users) {}
    public function attempt(string $email, string $password, bool $remember = false): bool
    {
        $user = $this->users->findByEmail($email);
        if (!$user || $user['status'] !== 'active' || !Security::verifyPassword($password, $user['password_hash'])) return false;
        session_regenerate_id(true);
        $_SESSION['user'] = ['id'=>$user['id'], 'name'=>$user['name'], 'email'=>$user['email'], 'role'=>$user['primary_role'] ?? 'Employee'];
        $_SESSION['last_activity'] = time();
        return true;
    }
    public function logout(): void { $_SESSION = []; session_destroy(); }
}
