<?php

declare(strict_types=1);

namespace Doctor\Http\DI;

use DI\Container;
use DI\ContainerBuilder;
use Doctor\Http\MissingHttpMethodException\MissingHttpMethodException;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

final class Bootstrap
{

	private ContainerBuilder $containerBuilder;
	private bool $debugMode = false;
	private ?string $cacheDir = null;


	public function __construct()
	{
		$this->containerBuilder = new ContainerBuilder;

		$this->addConfigFile(__DIR__ . '/doctor-config.php');
	}


	public function enableDebugMode(): void
	{
		$whoops = new Run;
		$whoops->pushHandler(new PrettyPageHandler);
		$whoops->register();

		$this->debugMode = true;
	}


	public function setCacheDir(string $cacheDir): void
	{
		$this->cacheDir = $cacheDir;
	}


	public function addConfigFile(string $configFile): void
	{
		$this->containerBuilder->addDefinitions($configFile);
	}


	public function createContainer(): Container
	{
		if ($this->cacheDir === null) {
			throw new \RuntimeException(
				sprintf(
					'Please set a cache directory using %s::setCacheDir()',
					self::class
				)
			);
		}

		if ($this->debugMode === false) {
			$this->containerBuilder->enableCompilation(rtrim($this->cacheDir, '/') . '/di');
			$this->containerBuilder->writeProxiesToFile(true, rtrim($this->cacheDir, '/') . '/proxies');
		}

		return $this->containerBuilder->build();
	}
}
