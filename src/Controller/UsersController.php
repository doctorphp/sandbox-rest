<?php

declare(strict_types=1);

namespace App\Route;

use Doctor\Rest\Controller\Controller;
use Doctor\Rest\Response\JsonResponse;
use Doctor\Rest\Response\Response;

final class UsersController extends Controller
{

	public function get(): Response
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
				],
			],
		]);
	}
}
