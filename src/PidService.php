<?php

declare(strict_types=1);

namespace Ofce\Pid\Api;

use Ofce\Pid\Api\Client\IClientFactory;
use Psr\Http\Client\ClientInterface;

class PidService
{
    /** @var string */
    private $baseUri;

    /** @var string */
    private $accessToken;

    /** @var ClientInterface */
    private $client;

    public function __construct(
        string $baseUri,
        string $accessToken,
        IClientFactory $clientFactory
    ) {
        $this->baseUri = $baseUri;
        $this->accessToken = $accessToken;
        $this->client = $clientFactory->createClient(['base_uri' => $baseUri]);
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
}
