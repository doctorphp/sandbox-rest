<?php

declare(strict_types=1);

namespace Doctor\Rest\Controller\Exception;

use Doctor\Rest\Response\Response;
use Doctor\Rest\Route\Router;

abstract class InvalidResponseException extends \Exception
{

	public function __construct(string $controllerClass, string $method)
	{
		parent::__construct(
			sprintf(
				'Method %s::%s() has to return a %s instance',
				$controllerClass,
				$method,
				Response::class
			)
		);
	}
}
