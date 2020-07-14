<?php

declare(strict_types=1);

use Doctor\Rest\Application;
use Nette\DI\Container;

/**
 * @var Container
 */
$container = require __DIR__ . '/../src/bootstrap.php';

$container->getByType(Application::class)->run();
