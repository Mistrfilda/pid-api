<?php

declare(strict_types=1);

namespace Mistrfilda\Pid\Api\Http\Response;

use Nette\Schema\Processor;
use Nette\Schema\Schema;
use Nette\Utils\Json;
use Psr\Http\Message\ResponseInterface;

abstract class Response
{
	public function __construct(ResponseInterface $response)
	{
		$bodyContents = $response->getBody()->getContents();
		if ($bodyContents === '') {
			throw new InvalidResponseException('Invalid response, content is empty');
		}

		$parsedResponse = Json::decode($bodyContents, Json::FORCE_ARRAY);

		$normalizedResponse = $this->validateResponse($parsedResponse);
		$this->createFromArrayResponse($normalizedResponse);
	}

	/**
	 * @param mixed[] $response
	 * @return array<mixed, mixed>
	 */
	protected function validateResponse(array $response): array
	{
		return (new Processor())->process($this->getResponseSchema(), $response);
	}

	/**
	 * @param array<mixed, mixed> $response
	 */
	abstract protected function createFromArrayResponse(array $response): void;

	abstract protected function getResponseSchema(): Schema;
}
