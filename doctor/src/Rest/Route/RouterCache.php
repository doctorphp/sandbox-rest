<?php

declare(strict_types=1);

namespace Doctor\Rest\Route;

use Doctor\Rest\Request\RequestMethod;
use Doctor\Rest\Route\Exception\InvalidMethodNameException;
use Doctor\Rest\Route\Exception\MethodNotAllowedException;
use Doctor\Rest\Route\Exception\RouteNotFoundException;
use Doctor\Rest\Route\RouteCollection;
use FastRoute;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Psr\Http\Message\RequestInterface;

final class RouterCache
{

	public const KEY_HTTP_METHOD = 0;
	public const KEY_PATH = 1;
	public const KEY_CONTROLLER_CLASS = 2;

	private string $cacheFile;
	private static array $data = [];
	private int $routeNumber = 0;


	public function __construct(string $cacheDir)
	{
		$this->cacheFile = $cacheDir . '/router/CompiledRouter.php';

		if (file_exists($this->cacheFile)) {
			self::$data = require $this->cacheFile;
			$this->routeNumber = count(self::$data);
		}
	}


	public function add(string $httpMethod, string $path, string $controllerClass): string
	{
		$this->routeNumber++;
		$key = 'route' . $this->routeNumber;
		self::$data[$key] = [
			self::KEY_HTTP_METHOD => $httpMethod,
			self::KEY_PATH => $path,
			self::KEY_CONTROLLER_CLASS => $controllerClass,
		];

		return $key;
	}


	public function clear(): void
	{
		@unlink($this->cacheFile); // @ - File may not exist
		self::$data = [];
		$this->routeNumber = 0;
	}


	public function store(): void
	{
		file_put_contents(
			$this->cacheFile,
			'<?php return ' . var_export(self::$data, true) . ';'
		);
	}


	public static function __callStatic(string $name, array $arguments): array
	{
		if (!isset(self::$data[$name])) {
			throw new \InvalidArgumentException(
				sprintf('Cached route with index [%d] not found', $name)
			);
		}

		return self::$data[$name];
	}
}
