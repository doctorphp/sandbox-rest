<?php

declare(strict_types=1);

namespace Doctor\Rest\Route;

final class RouteCollection implements \Countable, \IteratorAggregate
{

	private array $routes = [];


	public function add(string $path, string $controllerName): self
	{
		$this->routes[$path] = new Route($path, $controllerName);

		return $this;
	}


	/**
	 * @return \ArrayIterator<Route>
	 */
	public function getIterator(): \ArrayIterator
	{
		return new \ArrayIterator($this->routes);
	}


	public function count(): int
	{
		return count($this->routes);
	}
}
