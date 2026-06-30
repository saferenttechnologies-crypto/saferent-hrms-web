<?php
declare(strict_types=1);
namespace App\Core;

abstract class Controller
{
    protected function view(string $view, array $data = []): void
    {
        extract($data, EXTR_SKIP);
        $viewFile = dirname(__DIR__) . "/Views/{$view}.php";
        require dirname(__DIR__) . '/Views/layouts/app.php';
    }
    protected function redirect(string $path): void { header("Location: {$path}"); exit; }
}
