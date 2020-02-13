<?php

declare(strict_types=1);

namespace Ofce\Pid\Api\Http\Response;

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
     */
    protected function validateResponse(array $response): \stdClass
    {
        return (new Processor())->process($this->getResponseSchema(), $response);
    }

    abstract protected function createFromArrayResponse(\stdClass $response): void;

    abstract protected function getResponseSchema(): Schema;
}
