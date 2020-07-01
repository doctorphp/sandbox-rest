<?php

declare(strict_types=1);

namespace Doctor\Rest\Route;

use Doctor\Rest\Request\RequestMethod;
use Doctor\Rest\Route\Exception\InvalidMethodNameException;
use Doctor\Rest\Route\Exception\MethodNotAllowedException;
use Doctor\Rest\Route\Exception\RouteNotFoundException;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Psr\Http\Message\RequestInterface;

final class Router
{

	private RouteFactoryInterface $routeFactory;


	public function __construct(RouteFactoryInterface $routeFactory)
	{
		$this->routeFactory = $routeFactory;
	}


	/**
	 * @throws RouteNotFoundException
	 * @throws MethodNotAllowedException
	 * @throws InvalidMethodNameException
	 */
	public function findMatch(RequestInterface $request): Match
	{
		$dispatcher = cachedDispatcher(
			function(RouteCollector $routeCollector): void {
				$this->discoverRoutes($routeCollector);
			},
			[
				/* @todo Development env */
				'cacheFile' => __DIR__ . __DIR__ . '/../cache/route.cache', /* required */
				'cacheDisabled' => true,
			]
		);

		$routeInfo = $dispatcher->dispatch(
			$request->getMethod(),
			$request->getUri()->getPath()
		);

		switch ($routeInfo[0]) {
			case Dispatcher::NOT_FOUND:
				throw new RouteNotFoundException(
					$request->getUri()->getPath(),
					$request->getMethod()
				);

			case Dispatcher::METHOD_NOT_ALLOWED:
				throw new MethodNotAllowedException(
					$request->getUri()->getPath(),
					$request->getMethod(),
					$routeInfo[1]
				);

			case Dispatcher::FOUND:
				$handler = $routeInfo[1];
				$vars = $routeInfo[2];

				return new Match(($handler)(), $request->getMethod(), $vars);

			default:
				throw new \UnexpectedValueException;
		}
	}


	private function discoverRoutes(RouteCollector $routeCollector): void
	{
		$routeCollection = new RouteCollection;
		$this->routeFactory->create($routeCollection);

		$httpMethods = RequestMethod::getAll();

		foreach ($routeCollection as $route) {
			$reflectionClass = new \ReflectionClass($route->getControllerClass());

			foreach ($reflectionClass->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
				$methodName = $method->name;
				$methodToUpper = mb_strtoupper($methodName);

				if (!in_array($methodToUpper, $httpMethods, true)) {
					continue;
				}

				if ($methodName !== strtolower($methodName)) {
					throw new InvalidMethodNameException(
						$route->getControllerClass(),
						strtolower($methodName),
						$methodName
					);
				}

				$routeCollector->addRoute(
					$methodToUpper,
					$route->getPath(),
					function() use ($route): Route {
						return $route;
					}
				);
			}
		}
	}
}
