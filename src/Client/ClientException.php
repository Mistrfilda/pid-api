<?php

declare(strict_types=1);

namespace Mistrfilda\Pid\Api\Client;

use GuzzleHttp\Exception\ClientException as GuzzleException;
use Psr\Http\Client\ClientExceptionInterface;

class ClientException extends GuzzleException implements ClientExceptionInterface
{
}
