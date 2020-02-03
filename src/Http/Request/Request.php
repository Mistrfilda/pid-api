<?php

declare(strict_types=1);

namespace Ofce\Pid\Api\Http\Request;

use GuzzleHttp\Psr7\Request as GuzzleRequest;
use Ofce\Pid\Api\Http\InvalidParameterException;
use Ofce\Pid\Api\Http\Response\Response;
use Psr\Http\Message\ResponseInterface;

abstract class Request
{
    public const METHOD_GET = 'get';

    public const METHOD_POST = 'post';

    /** @var GuzzleRequest */
    private $httpRequest;

    /** @var string[] */
    private $body;

    /**
     * Request constructor.
     * @param string[] $body
     * @throws InvalidParameterException
     */
    public function __construct(string $method, string $endpoint, array $body)
    {
        if (! in_array($method, [self::METHOD_GET, self::METHOD_POST], true)) {
            throw new InvalidParameterException('Unsupported METHOD type');
        }

        $this->httpRequest = new GuzzleRequest(
            $method,
            $endpoint
        );

        $this->body = $body;
    }

    /**
     * @return string[]
     */
    public function getBody(): array
    {
        return $this->body;
    }

    public function getHttpRequest(): GuzzleRequest
    {
        return $this->httpRequest;
    }

    public function hasBody(): bool
    {
        return count($this->body) > 0;
    }

    abstract public function processResponse(ResponseInterface $response): Response;
}
