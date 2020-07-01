<?php

declare(strict_types=1);

namespace Doctor\Rest\Route;

interface RouteFactoryInterface
{

	public function create(RouteCollector $routeCollector): void;
}
