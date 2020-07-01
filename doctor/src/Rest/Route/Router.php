<?php

declare(strict_types=1);

namespace Rest\Route;

final class Router
{

	private RouteFactoryInterface $routeFactory;


	public function __construct(RouteFactoryInterface $routeFactory)
	{
		$this->routeFactory = $routeFactory;
	}


	public function findRoute(RequestInterface $request): string
	{
		
	}
}
