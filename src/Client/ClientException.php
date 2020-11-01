<?php

declare(strict_types=1);

namespace Mistrfilda\Pid\Api\Client;

use Exception;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class ClientException extends Exception implements ClientExceptionInterface
{
	/** @var RequestInterface */
	private $request;

	/** @var ResponseInterface|null */
	private $response;

	public function __construct(
		string $message,
		RequestInterface $request,
		?ResponseInterface $response,
		?Throwable $previous
	) {
		parent::__construct($message, 0, $previous);
		$this->request = $request;
		$this->response = $response;
	}

	public function getRequest(): RequestInterface
	{
		return $this->request;
	}

	public function getResponse(): ?ResponseInterface
	{
		return $this->response;
	}
}
