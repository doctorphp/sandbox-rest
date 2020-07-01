<?php

declare(strict_types=1);

namespace Doctor\Rest;

use DI\Container;
use Doctor\Rest\Route\Router;

class Application
{

	private Container $diContainer;
	private Router $router;
	private RequestInterface $request;


	public function __construct(
		Container $diContainer,
		Router $router,
		RequestInterface $request
	) {
		$this->diContainer = $diContainer;
		$this->router = $router;
		$this->request = $request;
	}


	public function run(): void
	{
		$controllerClass = $this->router->findRoute($this->request);

		$controller = $this->diContainer->get($controllerClass);
		$response = $controller->run($method, );
	}
}
