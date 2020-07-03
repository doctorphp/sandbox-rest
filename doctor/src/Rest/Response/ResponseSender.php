<?php

declare(strict_types=1);

namespace Doctor\Rest\Response;

use GuzzleHttp\Psr7\Response as PsrResponse;

class ResponseSender
{

	public function send(Response $response): void
	{
		$httpResponse = new PsrResponse(
			$response->getStatus(),
			['Conte-Type' => $response->getContentType()],
			$response->getResponseData(),
			'1.1',
			null
		);

		$protocolHeader = sprintf('HTTP/%s %s %s',
			$httpResponse->getProtocolVersion(),
			$httpResponse->getStatusCode(),
			$httpResponse->getReasonPhrase()
		);

		header($protocolHeader, true, $httpResponse->getStatusCode());

		$httpResponse = $httpResponse->withHeader(
			'Content-Length',
			(string) $httpResponse->getBody()->getSize()
		);

		foreach ($httpResponse->getHeaders() as $name => $values) {
			foreach ($values as $value) {
				header("$name: $value", false);
			}
		}

		$body = $httpResponse->getBody();

		if ($body->isSeekable()) {
			$body->rewind();
		}

		while (!$body->eof()) {
			echo $body->read(1024 * 8);
		}

		exit(0);
	}
}
