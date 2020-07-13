<?php

declare(strict_types=1);

use Doctor\DI\PSR\Bootstrap;

require __DIR__ . '/../vendor/autoload.php';

$bootstrap = new Bootstrap;

//$bootstrap->setDebugMode(true);

$bootstrap->addConfigFile(__DIR__ . '/../config/routes.php');
$bootstrap->setCacheDir(__DIR__ . '/../cache');

return $bootstrap->createContainer();
