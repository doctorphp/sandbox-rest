<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Doctor\Http\DI\Bootstrap;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

require __DIR__ . '/../vendor/autoload.php';

$bootstrap = new Bootstrap;

//$bootstrap->enableDebugMode();

$bootstrap->addConfigFile(__DIR__ . '/../config/routes.php');
$bootstrap->setCacheDir(__DIR__ . '/../cache');

return $bootstrap->createContainer();
