<?php
declare(strict_types=1);

use App\Core\Application;

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Application(dirname(__DIR__));
require dirname(__DIR__) . '/routes.php';
$app->run();
