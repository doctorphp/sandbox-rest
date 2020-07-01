<?php

declare(strict_types=1);

namespace Rest\Route;

use Doctor\Rest\Request\RequestMethod;
use Doctor\Rest\Route\RouteCollection;
use FastRoute\RouteCollector;
use FastRoute\cachedDispatcher;

final class Router
{

	private RouteFactoryInterface $routeFactory;


	public function __construct(RouteFactoryInterface $routeFactory)
	{
		$this->routeFactory = $routeFactory;
	}


	public function findMatch(RequestInterface $request): Match
	{
		$dispatcher = cachedDispatcher(
			function(RouteCollector $routeCollector) {
				$this->discoverRoutes($r);
			},
			[
				/* @todo Development env */
				'cacheFile' => __DIR__ . __DIR__ . '/../cache/route.cache', /* required */
				'cacheDisabled' => true,
			]
		);
	}


	private function discoverRoutes(RouteCollector $routeCollector): void
	{
		$routeCollection = $this->routeFactory->create(new RouteCollection);
		$httpMethods = RequestMethod::getAll();

		foreach ($routeCollection as $route) {
			$reflectionClass = new \ReflectionClass($route->getControllerClass());

			foreach ($reflectionClass->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
				$methodToUpper = mb_strtoupper($method);

				if (!in_array($methodToUpper, $httpMethods, true)) {
					continue;
				}

				$r->addRoute($methodToUpper, $route->getPath(), function() use ($route): Match {
					return new Match($route, []);
				});
			}
		}

		$r->addRoute('GET', '/users', 'get_all_users_handler');
	}
}
