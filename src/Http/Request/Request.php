<?php

declare(strict_types=1);

namespace Ofce\Pid\Api\Http\Request;

use Ofce\Pid\Api\Http\InvalidParameterException;
use Ofce\Pid\Api\Http\Response\Response;
use Psr\Http\Message\ResponseInterface;

abstract class Request
{
    public const METHOD_GET = 'get';

    public const METHOD_POST = 'post';

    /** @var string[] */
    private $body;

    /** @var string[] */
    private $queryParameters;

    /** @var string */
    private $endpoint;

    /** @var string */
    private $method;

    /**
     * Request constructor.
     * @param array<string, mixed> $body
     * @param array<string, mixed> $queryParameters
     * @throws InvalidParameterException
     */
    public function __construct(string $method, string $endpoint, array $body, array $queryParameters)
    {
        if (! in_array($method, [self::METHOD_GET, self::METHOD_POST], true)) {
            throw new InvalidParameterException('Unsupported METHOD type');
        }

        $this->body = $body;
        $this->endpoint = $endpoint;
        $this->queryParameters = $queryParameters;
        $this->method = $method;
    }

    /**
     * @return string[]
     */
    public function getBody(): array
    {
        return $this->body;
    }

    public function hasBody(): bool
    {
        return count($this->body) > 0;
    }

    /**
     * @return string[]
     */
    public function getQueryParameters(): array
    {
        return $this->queryParameters;
    }

    public function hasQueryParameters(): bool
    {
        return count($this->queryParameters) > 0;
    }

    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    abstract public function processResponse(ResponseInterface $response): Response;
}
