<?php

declare(strict_types=1);

namespace Ofce\Pid\Api\StopTime;

use Ofce\Pid\Api\Http\Request\Request;
use Ofce\Pid\Api\Http\Response\Response;
use Psr\Http\Message\ResponseInterface;

class StopTimeRequest extends Request
{
    public const URL = 'gtfs/stoptimes';

    public function __construct(string $stopId, int $limit, int $offset)
    {
        $queryParameters = [
            'limit' => $limit,
            'offset' => $offset,
        ];

        $url = self::URL . '/' . $stopId;

        parent::__construct(Request::METHOD_GET, $url, [], $queryParameters);
    }

    public function processResponse(ResponseInterface $response): Response
    {
        return new StopTimeResponse($response);
    }
}
