<?php
/**
 * This class has been auto-generated by PHP-DI.
 */
class CompiledContainer extends DI\CompiledContainer{
    const METHOD_MAPPING = array (
  'cacheDir' => 'get1',
  'debugMode' => 'get2',
  'Doctor\\Rest\\Route\\RouteCollection' => 'get3',
  'Psr\\Http\\Message\\RequestInterface' => 'get4',
  'Doctor\\Rest\\Route\\Router' => 'get5',
  'Doctor\\Rest\\Route\\RouterCache' => 'get6',
);

    protected function get1()
    {
        return '/Users/paveljanda/www/doctor/sandbox-rest/src/../cache';
    }

    protected function get2()
    {
        return false;
    }

    protected function get3()
    {
        return $this->resolveFactory(static function(): \Doctor\Rest\Route\RouteCollection {
		return (new Doctor\Rest\Route\RouteCollection)
			->add('/hello-world', \App\Controller\HelloWorldController::class)
			->add('/users', \App\Controller\UsersController::class)
			->add('/user/{id:\d+}', \App\Controller\UserController::class);
	}, 'Doctor\\Rest\\Route\\RouteCollection');
    }

    protected function get4()
    {
        return $this->resolveFactory(static function(\Psr\Container\ContainerInterface $container): \Psr\Http\Message\RequestInterface {
		return $container->get(\Doctor\Http\RequestFactory::class)->createFromGlobals();
	}, 'Psr\\Http\\Message\\RequestInterface');
    }

    protected function get5()
    {
        return $this->resolveFactory(static function(\Psr\Container\ContainerInterface $container): \Doctor\Rest\Route\Router {
		return new \Doctor\Rest\Route\Router(
			$container->get('cacheDir'),
			$container->get('debugMode'),
			$container->get(\Doctor\Rest\Route\RouteCollection::class),
			$container->get(\Doctor\Rest\Route\RouterCache::class)
		);
	}, 'Doctor\\Rest\\Route\\Router');
    }

    protected function get6()
    {
        return $this->resolveFactory(static function(\Psr\Container\ContainerInterface $container): \Doctor\Rest\Route\RouterCache{
		return new \Doctor\Rest\Route\RouterCache($container->get('cacheDir'));
	}, 'Doctor\\Rest\\Route\\RouterCache');
    }

}
