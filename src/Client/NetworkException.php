<?php

declare(strict_types=1);

namespace Mistrfilda\Pid\Api\Client;

use GuzzleHttp\Exception\ConnectException;
use Psr\Http\Client\NetworkExceptionInterface;
use Psr\Http\Message\RequestInterface;

class NetworkException extends ConnectException implements NetworkExceptionInterface
{
    public function getRequest(): RequestInterface
    {
        return parent::getRequest();
    }
}
