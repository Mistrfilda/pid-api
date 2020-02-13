<?php

declare(strict_types=1);

namespace Ofce\Pid\Api\Http;

use Nette\Http\Url;

class UrlFactory
{
    /** @var Url */
    private $url;

    public function __construct(string $baseUrl, string $endpointUrl)
    {
        $this->url = new Url($baseUrl . '/' . $endpointUrl);
    }

    public function addParameter(string $key, $value): void
    {
        $this->url->setQueryParameter($key, $value);
    }

    /**
     * @param array<string, mixed> $parameters
     */
    public function addParameters(array $parameters): void
    {
        foreach ($parameters as $key => $value) {
            $this->addParameter($key, $value);
        }
    }

    public function getUrl(): string
    {
        return $this->url->getAbsoluteUrl();
    }
}
