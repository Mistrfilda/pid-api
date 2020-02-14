<?php

declare(strict_types=1);

namespace Ofce\Pid\Api;

use GuzzleHttp\Psr7\Request as GuzzleRequest;
use Ofce\Pid\Api\Client\ClientFactory;
use Ofce\Pid\Api\Client\IClientFactory;
use Ofce\Pid\Api\Http\Request\Request;
use Ofce\Pid\Api\Http\Response\InvalidResponseException;
use Ofce\Pid\Api\Http\Response\Response;
use Ofce\Pid\Api\Http\UrlFactory;
use Ofce\Pid\Api\Stop\StopRequest;
use Ofce\Pid\Api\Stop\StopResponse;
use Ofce\Pid\Api\StopTimes\StopTimeRequest;
use Ofce\Pid\Api\StopTimes\StopTimeResponse;
use Psr\Http\Client\ClientInterface;

class PidService
{
    public const BASE_URI = 'https://api.golemio.cz/v1';

    /** @var string */
    private $baseUri;

    /** @var string */
    private $accessToken;

    /** @var ClientInterface */
    private $client;

    public function __construct(
        string $accessToken,
        string $baseUri = self::BASE_URI,
        ?IClientFactory $clientFactory = null
    ) {
        $this->baseUri = $baseUri;
        $this->accessToken = $accessToken;

        if ($clientFactory === null) {
            $clientFactory = new ClientFactory();
        }

        $this->client = $clientFactory->createClient();
    }

    public function getBaseUri(): string
    {
        return $this->baseUri;
    }

    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    public function getClient(): ClientInterface
    {
        return $this->client;
    }

    public function sendGetStopsRequest(int $limit, int $offset): StopResponse
    {
        $request = new StopRequest($limit, $offset);
        $response = $this->sendRequest($request);

        if (! $response instanceof StopResponse) {
            throw new InvalidResponseException('Invalid response returned from request');
        }

        return $response;
    }

    public function sendGetStopTimesRequest(string $stopId, int $limit, int $offset): StopTimeResponse
    {
        $request = new StopTimeRequest($stopId, $limit, $offset);
        $response = $this->sendRequest($request);

        if (! $response instanceof StopTimeResponse) {
            throw new InvalidResponseException('Invalid response returned from request');
        }

        return $response;
    }

    private function sendRequest(Request $request): Response
    {
        $urlFactory = new UrlFactory(self::BASE_URI, $request->getEndpoint());

        if ($request->hasQueryParameters()) {
            $urlFactory->addParameters($request->getQueryParameters());
        }

        $guzzleRequest = new GuzzleRequest(
            $request->getMethod(),
            $urlFactory->getUrl(),
            [
                'x-access-token' => $this->accessToken,
            ]
        );

        $response = $this->client->sendRequest($guzzleRequest);
        return $request->processResponse($response);
    }
}
