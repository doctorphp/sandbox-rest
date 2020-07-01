<?php

declare(strict_types=1);

namespace Doctor\Http\MissingHttpMethodException;

final class MissingHttpMethodException extends \Exception
{

	public function __construct()
	{
		parent::__construct('No HTTP Method found');
	}
}
