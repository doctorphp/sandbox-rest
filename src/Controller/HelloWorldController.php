<?php

declare(strict_types=1);

namespace App\Controller;

use Doctor\Rest\Controller\Controller;
use Doctor\Rest\Response\Response;
use Doctor\Rest\Response\TextResponse;

final class HelloWorldController extends Controller
{

	public function get(): Response
	{
		return new TextResponse('Hello, world');
	}
}
