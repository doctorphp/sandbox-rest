<?php

declare(strict_types=1);

namespace Doctor\Rest\Controller\Exception;

use Doctor\Rest\Response\Response;
use Doctor\Rest\Route\Router;

abstract class UndefinedMethodCallException extends \Exception
{

	public function __construct(string $controllerClass, string $method)
	{
		parent::__construct(
			sprintf('Undefined method call: %s::%s()', $controllerClass, $method)
		);
	}
}
