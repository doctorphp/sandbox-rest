<?php

declare(strict_types=1);

namespace Doctor\Rest;

use DI\Container;
use Doctor\Rest\Route\Router;
use Psr\Http\Message\RequestInterface;

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
		$match = $this->router->findMatch($this->request);

		$controller = $this->diContainer->get($match->getRoute()->getControllerClass());
		$response = $controller->run($match->getMethod(), $match->getParams());

		echo $response->getResponseData() . PHP_EOL;
	}
}
