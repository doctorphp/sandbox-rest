<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

require __DIR__ . '/../vendor/autoload.php';

$whoops = new Run;
$whoops->pushHandler(new PrettyPageHandler);
$whoops->register();

$containerBuilder = new ContainerBuilder;

if (true /* @todo Development env */) {
	$containerBuilder->enableCompilation(__DIR__ . '/../cache/di');
	$containerBuilder->writeProxiesToFile(true, __DIR__ . '/cache/proxies');
}

return $containerBuilder->build();
