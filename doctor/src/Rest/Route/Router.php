<?php

declare(strict_types=1);

namespace Doctor\Rest\Route;

use Doctor\Rest\Request\RequestMethod;
use Doctor\Rest\Route\Exception\InvalidMethodNameException;
use Doctor\Rest\Route\Exception\MethodNotAllowedException;
use Doctor\Rest\Route\Exception\RouteNotFoundException;
use Doctor\Rest\Route\RouteCollection;
use FastRoute;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Psr\Http\Message\RequestInterface;

final class Router
{

	private string $cacheDir;
	private bool $debugMode;
	private RouteCollection $routeCollection;
	private RouterCache $routerCache;


	public function __construct(
		string $cacheDir,
		bool $debugMode,
		RouteCollection $routeCollection,
		RouterCache $routerCache
	) {
		$this->cacheDir = $cacheDir;
		$this->debugMode = $debugMode;
		$this->routeCollection = $routeCollection;
		$this->routerCache = $routerCache;
	}


	/**
	 * @throws RouteNotFoundException
	 * @throws MethodNotAllowedException
	 * @throws InvalidMethodNameException
	 */
	public function findMatch(RequestInterface $request): Match
	{
		$dispatcher = FastRoute\cachedDispatcher(
			function(RouteCollector $routeCollector): void {
				$this->discoverRoutes($routeCollector);
			},
			[
				'cacheFile' => $this->cacheDir . '/router/CompiledRoutes.php', /* required */
				'cacheDisabled' => $this->debugMode,
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
		$httpMethods = RequestMethod::getAll();

		foreach ($this->routeCollection as $route) {
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
					/*function() use ($route): Route {
						return $route;
					}*/
					[RouterCache::class, 'route1']
				);
			}
		}
	}
}
