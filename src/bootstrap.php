<?php

declare(strict_types=1);

use Doctor\DI\Nette\Bootstrap;

require __DIR__ . '/../vendor/autoload.php';

$bootstrap = new Bootstrap(__DIR__ . '/../cache', true);

$bootstrap->addConfigFile(__DIR__ . '/../config/routes.neon');

return $bootstrap->createContainer();
