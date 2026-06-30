<?php
use App\Controllers\AuthController; use App\Controllers\DashboardController; use App\Controllers\ModuleController; use App\Middleware\AuthMiddleware;

$this->router->get('/', [DashboardController::class, 'index'], [AuthMiddleware::class]);
$this->router->get('/dashboard', [DashboardController::class, 'index'], [AuthMiddleware::class]);
$this->router->get('/login', [AuthController::class, 'login']);
$this->router->post('/login', [AuthController::class, 'authenticate']);
$this->router->post('/logout', [AuthController::class, 'logout'], [AuthMiddleware::class]);
$this->router->get('/modules', [ModuleController::class, 'index'], [AuthMiddleware::class]);
$this->router->get('/404', [ModuleController::class, 'notFound']);
