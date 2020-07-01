<?php

declare(strict_types=1);

namespace Doctor\Rest\Route;

final class Route
{

	private string $path;
	private string $controllerClass;


	public function __construct(string $path, string $controllerClass)
	{
		$this->path = $path;
		$this->controllerClass = $controllerClass;
	}


	public function getPath(): string
	{
		return $this->path;
	}


	public function getControllerClass(): string
	{
		return $this->controllerClass;
	}
}
