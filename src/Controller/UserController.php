<?php

declare(strict_types=1);

namespace App\Controller;

use Doctor\Rest\Controller\Controller;
use Doctor\Rest\Response\JsonResponse;
use Doctor\Rest\Response\Response;

final class UserController extends Controller
{

	public function get(int $id): Response
	{
		return new JsonResponse([
			'user' => [
				'id' => $id,
				'name' => 'Joe - ' . $id,
			],
		]);
	}
}
