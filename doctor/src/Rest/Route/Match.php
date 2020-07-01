<?php

declare(strict_types=1);

namespace Doctor\Rest\Route;

final class Match
{

	private Route $route;
	private string $method;
	private array $params;


	public function __construct(Route $route, string $method, array $params)
	{
		$this->route = $route;
		$this->method = $method;
		$this->params = $params;
	}


	public function getRoute(): Route
	{
		return $this->route;
	}


	public function getMethod(): string
	{
		return $this->method;
	}


	public function getParams(): array
	{
		return $this->params;
	}
}
