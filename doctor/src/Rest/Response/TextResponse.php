<?php

declare(strict_types=1);

namespace Doctor\Rest\Response;

class TextResponse extends Response
{

	/**
	 * @var mixed
	 */
	private $data;


	/**
	 * @param mixed $data
	 */
	public function __construct($data)
	{
		$this->data = $data;

		$this->setContentType('text/plain');
	}


	public function getResponseData(): string
	{
		return $this->data;
	}
}
