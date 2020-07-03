<?php

declare(strict_types=1);

namespace Doctor\Http\DI;

use DI\Container;
use DI\ContainerBuilder;
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


	public function setDebugMode(bool $debugMode = true): void
	{
		if ($debugMode) {
			$whoops = new Run;
			$whoops->pushHandler(new PrettyPageHandler);
			$whoops->register();
		}

		$this->debugMode = $debugMode;
	}


	public function setCacheDir(string $cacheDir): void
	{
		$this->cacheDir = rtrim($cacheDir, '/');
		$routerCacheDir = $this->cacheDir . '/router';

		if (!is_dir($routerCacheDir)) {
			mkdir($routerCacheDir, 0777, true);

			if (!is_dir($routerCacheDir)) {
				throw new \RuntimeException(
					sprintf('Could not created cache directory %s', $routerCacheDir)
				);
			}
		}
	}


	public function addConfigFile(string $configFile): void
	{
		$this->containerBuilder->addDefinitions($configFile);
	}


	public function createContainer(): Container
	{
		if ($this->cacheDir === null) {
			throw new \RuntimeException(
				sprintf('Please set a cache directory using %s::setCacheDir()', self::class)
			);
		}

		$this->containerBuilder->addDefinitions([
			'cacheDir' => $this->cacheDir,
			'debugMode' => $this->debugMode,
		]);

		if ($this->debugMode === false) {
			$this->containerBuilder->enableCompilation($this->cacheDir . '/di');
			$this->containerBuilder->writeProxiesToFile(true, $this->cacheDir . '/proxies');
		}

		return $this->containerBuilder->build();
	}
}
