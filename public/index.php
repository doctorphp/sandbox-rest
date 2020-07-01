<?php

declare(strict_types=1);

use DI\Container;
use Doctor\Rest\Application;

/**
 * @var Container
 */
$container = require __DIR__ . '/../src/bootstrap.php';

$container->get(Application::class)->run();
