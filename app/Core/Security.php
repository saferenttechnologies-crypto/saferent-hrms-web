<?php
declare(strict_types=1);
namespace App\Core;

final class Security
{
    public static function e(?string $value): string { return htmlspecialchars($value ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
    public static function csrfToken(): string { if (empty($_SESSION['_csrf_token'])) $_SESSION['_csrf_token']=bin2hex(random_bytes(32)); return $_SESSION['_csrf_token']; }
    public static function verifyCsrf(?string $token): void { if (!$token || !hash_equals($_SESSION['_csrf_token'] ?? '', $token)) throw new \RuntimeException('Invalid CSRF token'); }
    public static function hashPassword(string $password): string { return password_hash($password, PASSWORD_ARGON2ID); }
    public static function verifyPassword(string $password, string $hash): bool { return password_verify($password, $hash); }
}
