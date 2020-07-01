<?php

declare(strict_types=1);

use DI\ContainerBuilder;

require __DIR__ . '/../vendor/autoload.php';

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

$builder = new ContainerBuilder;

if (true /* Development env */) {
	$containerBuilder->enableCompilation(__DIR__ . '/../cache/di');
	$containerBuilder->writeProxiesToFile(true, __DIR__ . '/cache/proxies');
}

$builder

return $builder->build();
