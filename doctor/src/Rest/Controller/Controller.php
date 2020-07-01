<?php

declare(strict_types=1);

namespace Doctor\Rest\Controller;

use Doctor\Rest\Controller\Exception\InvalidResponseException;
use Doctor\Rest\Controller\Exception\UndefinedMethodCallException;
use Doctor\Rest\Response\Response;

abstract class Controller
{

	/**
	 * @theow UndefinedMethodCallException
	 * @theow InvalidResponseException
	 */
	public function run(string $method, array $params): Response
	{
		$method = strtolower($method);

		if (!method_exists($this, $method)) {
			throw new UndefinedMethodCallException(static::class, $method);
		}

		$response = call_user_func_array([$this, $method], $params);

		if (!$response instanceof Response) {
			throw new InvalidResponseException(static::class, $method);
		}

		return $response;
	}
}
