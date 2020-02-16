<?php

declare(strict_types=1);

namespace Ofce\Pid\Api\Client;

use GuzzleHttp\Exception\RequestException as GuzzleRequestException;
use Psr\Http\Client\RequestExceptionInterface;
use Psr\Http\Message\RequestInterface;

class RequestException extends GuzzleRequestException implements RequestExceptionInterface
{
    public function getRequest(): RequestInterface
    {
        return parent::getRequest();
    }
}
