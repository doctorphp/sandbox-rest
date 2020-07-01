<?php

declare(strict_types=1);

namespace App\Route;

use Doctor\Rest\Route\RouteCollection;
use Doctor\Rest\Route\RouteFactoryInterface;

final class RouteFactory implements RouteFactoryInterface
{

	public function create(RouteCollection $routeCollection): void
	{
		$routeCollection->add('/users', UsersController::class);
		$routeCollection->add('/user/{id:\d+}', UserController::class);
	}
}
