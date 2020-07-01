<?php

declare(strict_types=1);

use Doctor\Http\RequestFactory;
use GuzzleHttp\Psr7\Request;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;

return [
	RequestInterface::class => function(ContainerInterface $container): RequestInterface {
		return $container->get(RequestFactory::class)->createFromGlobals();
	},
];
