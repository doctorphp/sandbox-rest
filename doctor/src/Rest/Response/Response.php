<?php

declare(strict_types=1);

namespace Doctor\Rest\Response;

abstract class Response
{

	private int $httpCode = 200;
	private ?string $contentType = null;


	abstract public function getResponseData(): string;


	public function setHttpCode(int $httpCode): void
	{
		$this->httpCode = $httpCode;
	}


	public function getCode(): int
	{
		return $this->httpCode;
	}


	public function setContentType(?string $contentType): void
	{
		$this->contentType = $contentType;
	}


	public function getContentType(): ?string
	{
		return $this->contentType;
	}
}
