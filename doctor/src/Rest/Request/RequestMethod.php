<?php

declare(strict_types=1);

namespace Doctor\Rest\Request;

use Doctor\Rest\Route\Router;

final class RequestMethod
{

	public const GET = 'GET';
	public const HEAD = 'HEAD';
	public const POST = 'POST';
	public const PUT = 'PUT';
	public const DELETE = 'DELETE';
	public const CONNECT = 'CONNECT';
	public const OPTIONS = 'OPTIONS';
	public const TRACE = 'TRACE';
	public const PATCH = 'PATCH';


	/**
	 * @return Array|string[]
	 */
	public function getAll(): array
	{
		return [
			self::GET,
			self::HEAD,
			self::POST,
			self::PUT,
			self::DELETE,
			self::CONNECT,
			self::OPTIONS,
			self::TRACE,
			self::PATCH,
		];
	}
}
