<?php

declare(strict_types=1);

namespace Doctor\Rest\Response;

class TextResponse extends Response
{

	private string $data;


	public function __construct(string $data, int $status = ResponseStatus::STATUS_200_OK)
	{
		$this->data = $data;
		$this->status = $status;

		$this->setContentType('text/plain');
	}


	public function getResponseData(): string
	{
		return $this->data;
	}
}
