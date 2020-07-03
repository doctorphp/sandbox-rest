<?php

declare(strict_types=1);

namespace Doctor\Rest\Response;

abstract class Response
{

	private int $status = 200;
	private ?string $contentType = null;


	abstract public function getResponseData(): string;


	public function setStatus(int $status): void
	{
		$this->status = $status;
	}


	public function getStatus(): int
	{
		return $this->status;
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
