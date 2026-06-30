<?php
declare(strict_types=1);
namespace App\Core;
use Dotenv\Dotenv; use PDO;

final class Application
{
    public Container $container; public Router $router;
    public function __construct(public string $basePath)
    {
        if (file_exists($basePath.'/.env')) Dotenv::createImmutable($basePath)->safeLoad();
        session_set_cookie_params(['httponly'=>true,'secure'=>!empty($_SERVER['HTTPS']),'samesite'=>'Lax']); session_start();
        $this->container = new Container(); $this->router = new Router();
        $this->container->singleton(Router::class, fn()=> $this->router);
        $this->container->singleton(Database::class, fn()=> new Database(new PDO(...array_values(require $basePath.'/config/database.php'))));
    }
    public function run(): void { $this->router->dispatch($this->container); }
}
