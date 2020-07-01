<?php

declare(strict_types=1);

use App\Controller\HelloWorldController;
use App\Controller\UserController;
use App\Controller\UsersController;
use Doctor\Rest\Route\RouteCollection;
use Psr\Container\ContainerInterface;

return [
	RouteCollection::class => function(): RouteCollection {
		return (new Doctor\Rest\Route\RouteCollection)
			->add('/hello-world', HelloWorldController::class)
			->add('/users', UsersController::class)
			->add('/user/{id:\d+}', UserController::class);
	}
];
