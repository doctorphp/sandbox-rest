<?php

declare(strict_types=1);

namespace Doctor\Rest;

use DI\Container;
use Doctor\Rest\Response\Response;
use Doctor\Rest\Response\ResponseSender;
use Doctor\Rest\Response\ResponseStatus;
use Doctor\Rest\Response\TextResponse;
use Doctor\Rest\Route\Exception\RouteNotFoundException;
use Doctor\Rest\Route\Router;
use Psr\Http\Message\RequestInterface;

class Application
{

	private bool $debugMode;
	private Container $diContainer;
	private Router $router;
	private RequestInterface $request;
	private ResponseSender $responseSender;


	public function __construct(
		bool $debugMode,
		Container $diContainer,
		Router $router,
		RequestInterface $request,
		ResponseSender $responseSender
	) {
		$this->debugMode = $debugMode;
		$this->diContainer = $diContainer;
		$this->router = $router;
		$this->request = $request;
		$this->responseSender = $responseSender;
	}


	public function run(): void
	{
		try {
			$match = $this->router->findMatch($this->request);
		} catch (InvalidMethodNameException $e) {
			$this->handleError($e);
		}

		$controller = $this->diContainer->get($match->getRoute()->getControllerClass());
		$response = $controller->run($match->getMethod(), $match->getParams());

		$this->responseSender->send($response);
	}


	/**
	 * @param \Exception
	 */
	protected function handleError(\Exception $e): void
	{
		if ($this->debugMode) {
			throw $e;
		}

		if ($e instanceof MethodNotAllowedException) {
			$this->responseSender->send(
				new TextResponse(
					'Method Not Allowed',
					ResponseStatus::STATUS_405_METHOD_NOT_ALLOWED
				)
			);
		} elseif ($e instanceof MethodNotAllowedException) {
			$this->responseSender->send(
				new TextResponse(
					'Not Found',
					ResponseStatus::STATUS_404_NOT_FOUND
				)
			);
		}

		$this->responseSender->send(
			new TextResponse(
				'Internal Server Error',
				ResponseStatus::STATUS_500_INTERNAL_SERVER_ERROR
			)
		);
	}
}
