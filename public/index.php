<?php
declare(strict_types=1);

use App\Core\Application;

spl_autoload_register(static function (string $class): void {
    $prefix = 'App\\';
    $baseDir = dirname(__DIR__) . '/app/';

    if (strncmp($class, $prefix, strlen($prefix)) !== 0) {
        return;
    }

    $relativeClass = substr($class, strlen($prefix));
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (is_file($file)) {
        require $file;
    }
});

$app = new Application(dirname(__DIR__));
(function () {
    require dirname(__DIR__) . '/routes.php';
})->call($app);
$app->run();
