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

final class RouterCache
{

	private array $data = [];


	public function addRoute(): void
	{
		// Code here
	}


	public function __call($name, $arguments)
	{
		var_dump($this->data); die;
	}


	public static function __callStatic($name, $arguments)
	{
		var_dump(1); die;
	}
}
