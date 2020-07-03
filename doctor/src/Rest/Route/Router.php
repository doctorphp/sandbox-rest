<?php

declare(strict_types=1);

namespace Doctor\Rest\Route;

use Doctor\Rest\Request\RequestMethod;
use Doctor\Rest\Route\Exception\InvalidMethodNameException;
use Doctor\Rest\Route\Exception\MethodNotAllowedException;
use Doctor\Rest\Route\Exception\RouteNotFoundException;
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

				$routeData = ($handler)();

				return new Match(
					new Route(
						$routeData[RouterCache::KEY_PATH],
						$routeData[RouterCache::KEY_CONTROLLER_CLASS]
					),
					$request->getMethod(),
					$vars
				);

			default:
				throw new \UnexpectedValueException;
		}
	}


	private function discoverRoutes(RouteCollector $routeCollector): void
	{
		$httpMethods = RequestMethod::getAll();

		$this->routerCache->clear();

		foreach ($this->routeCollection as $route) {
			$reflectionClass = new \ReflectionClass($route->getControllerClass());

			foreach ($reflectionClass->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
				$methodName = $method->name;
				$httpMethod = mb_strtoupper($methodName);

				if (!in_array($httpMethod, $httpMethods, true)) {
					continue;
				}

				if ($methodName !== strtolower($methodName)) {
					throw new InvalidMethodNameException(
						$route->getControllerClass(),
						strtolower($methodName),
						$methodName
					);
				}

				$routeCacheMethod = $this->routerCache->add(
					$httpMethod,
					$route->getPath(),
					$route->getControllerClass()
				);

				$routeCollector->addRoute(
					$httpMethod,
					$route->getPath(),
					[RouterCache::class, $routeCacheMethod]
				);
			}
		}

		$this->routerCache->store();
	}
}
