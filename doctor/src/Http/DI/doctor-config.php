<?php

declare(strict_types=1);

use Doctor\Http\RequestFactory;
use Doctor\Rest\Route\RouteCollection;
use Doctor\Rest\Route\Router;
use Doctor\Rest\Route\RouterCache;
use GuzzleHttp\Psr7\Request;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;

return [
	RequestInterface::class => function(ContainerInterface $container): RequestInterface {
		return $container->get(RequestFactory::class)->createFromGlobals();
	},
	Router::class => function(ContainerInterface $container): Router {
		return new Router(
			$container->get('cacheDir'),
			$container->get('debugMode'),
			$container->get(RouteCollection::class),
			$container->get(RouterCache::class)
		);
	},
];
