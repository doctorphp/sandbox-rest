<?php

declare(strict_types=1);

namespace Doctor\Rest\Controller;

use Doctor\Rest\Controller\Exception\UndefinedMethodCallException;
use Doctor\Rest\Response\Response;
use Doctor\Rest\Route\Router;

abstract class Controller
{

	/**
	 * @param string $method
	 * @theow UndefinedMethodCallException
	 */
	public function run(string $method): Response
	{
		$method = strtolower($method);

		if (!method_exists($this, $method)) {
			throw new UndefinedMethodCallException(get_class($this), $method);
		}
	}
}
