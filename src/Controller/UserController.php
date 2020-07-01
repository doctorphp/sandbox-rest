<?php

declare(strict_types=1);

namespace App\Route

use Doctor\Rest\Controller\Controller;
use Doctor\Rest\Response\JsonResponse;
use Doctor\Rest\Route\Route;
use Doctor\Rest\Route\RouteCollection;
use Doctor\Rest\Route\RouteFactoryInterface;

final class UserController extends Controller
{

	public function get(): void
	{
		return new JsonResponse([
			'users' => [
				[
					'id' => 1,
					'name' => 'John Doe',
				],
				[
					'id' => 2,
					'name' => 'Fou Pou',
				]
			]
		]);
	}
}
