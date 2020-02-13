<?php

declare(strict_types=1);

namespace Ofce\Pid\Api\Client;

use Exception;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\BadResponseException;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class GuzzlePsr18Client extends GuzzleClient implements ClientInterface
{
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        try {
            return $this->send($request);
        } catch (BadResponseException $e) {
            throw new ClientException($e->getMessage(), $request, $e->getResponse(), $e);
        } catch (Exception $e) {
            throw new ClientException($e->getMessage(), $request, null, $e);
        }
    }
}
