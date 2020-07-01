<?php

declare(strict_types=1);

namespace App\Route

use Doctor\Rest\Route\Route;
use Doctor\Rest\Route\RouteCollection;
use Doctor\Rest\Route\RouteFactoryInterface;

final class RouteFactory implements RouteFactoryInterface
{

	public function create(RouteCollection $routeCollection): void;
	{
		$routeCollection->add('/users', Users::class);
		$routeCollection->add('/user/{id:\d+}', UserController::class);
	}
}
