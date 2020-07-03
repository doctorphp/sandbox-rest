<?php

declare(strict_types=1);

use Doctor\Http\RequestFactory;
use Doctor\Rest\Application;
use Doctor\Rest\Route\Router;
use Doctor\Rest\Route\RouterCache;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;

return [
	RequestInterface::class => function(ContainerInterface $container): RequestInterface {
		return $container->get(RequestFactory::class)->createFromGlobals();
	},
	Router::class => DI\autowire()->constructor(DI\get('cacheDir'), DI\get('debugMode')),
	RouterCache::class => DI\autowire()->constructor(DI\get('cacheDir')),
	Application::class => DI\autowire()->constructor(DI\get('debugMode')),
];
