<?php

declare(strict_types=1);

namespace Ofce\Pid\Api\Client;

use Psr\Http\Client\ClientInterface;

interface IClientFactory
{
    /**
     * @param array<string> $parameters
     */
    public function createClient(array $parameters): ClientInterface;
}
