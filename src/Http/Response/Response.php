<?php

declare(strict_types=1);

namespace Ofce\Pid\Api\Http\Response;

use Nette\Schema\Processor;
use Nette\Schema\Schema;

abstract class Response
{
    /**
     * @param mixed[] $response
     */
    public function __construct(array $response)
    {
        $this->validateResponse($response);
        $this->createFromArrayResponse($response);
    }

    /**
     * @param mixed[] $response
     */
    protected function validateResponse(array $response): void
    {
        (new Processor())->process($this->getResponseSchema(), $response);
    }

    /**
     * @param mixed[] $response
     */
    abstract protected function createFromArrayResponse(array $response): void;

    abstract protected function getResponseSchema(): Schema;
}
