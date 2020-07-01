<?php

declare(strict_types=1);

namespace Doctor\Rest\Route\Exception;

final class RouteNotFoundException extends \Exception
{

	public function __construct(string $path, string $method)
	{
		parent::__construct(
			sprintf(
				'Route %s - %s not found',
				$method,
				$path
			)
		);
	}
}
