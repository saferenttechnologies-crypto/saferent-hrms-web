<?php
declare(strict_types=1);
namespace App\Core;
use PDO;

final class Application
{
    public Container $container; public Router $router;
    public function __construct(public string $basePath)
    {
        $this->loadEnvironment($basePath.'/.env');
        session_set_cookie_params(['httponly'=>true,'secure'=>!empty($_SERVER['HTTPS']),'samesite'=>'Lax']); session_start();
        $this->container = new Container(); $this->router = new Router();
        $this->container->singleton(Router::class, fn()=> $this->router);
        $this->container->singleton(Database::class, fn()=> new Database(new PDO(...array_values(require $basePath.'/config/database.php'))));
    }
    public function run(): void { $this->router->dispatch($this->container); }

    private function loadEnvironment(string $path): void
    {
        if (!is_file($path) || !is_readable($path)) return;

        foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [] as $line) {
            $line = trim($line);
            if ($line === '' || str_starts_with($line, '#')) continue;

            if (str_starts_with($line, 'export ')) {
                $line = trim(substr($line, 7));
            }

            $separatorPosition = strpos($line, '=');
            if ($separatorPosition === false) continue;

            $key = trim(substr($line, 0, $separatorPosition));
            if ($key === '' || !preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/', $key)) continue;

            $value = trim(substr($line, $separatorPosition + 1));
            $value = $this->normaliseEnvironmentValue($value);

            $_ENV[$key] = $value;
            $_SERVER[$key] = $value;
            putenv("{$key}={$value}");
        }
    }

    private function normaliseEnvironmentValue(string $value): string
    {
        if ($value === '') return '';

        $quote = $value[0];
        if (($quote === '"' || $quote === "'") && str_ends_with($value, $quote)) {
            $value = substr($value, 1, -1);
            return $quote === '"' ? stripcslashes($value) : $value;
        }

        $commentPosition = strpos($value, ' #');
        if ($commentPosition !== false) {
            $value = substr($value, 0, $commentPosition);
        }

        return trim($value);
    }
}
