<?php
declare(strict_types=1);
namespace App\Controllers;
use App\Core\Controller; use App\Core\Security; use App\Services\AuthService;

final class AuthController extends Controller
{
    public function __construct(private AuthService $auth) {}
    public function login(): void { $this->view('auth/login', ['title'=>'Sign in']); }
    public function authenticate(): void { Security::verifyCsrf($_POST['_csrf_token'] ?? null); if ($this->auth->attempt(trim($_POST['email'] ?? ''), $_POST['password'] ?? '', isset($_POST['remember']))) $this->redirect('/dashboard'); $this->view('auth/login', ['title'=>'Sign in','error'=>'Invalid credentials or locked account.']); }
    public function logout(): void { $this->auth->logout(); $this->redirect('/login'); }
}
