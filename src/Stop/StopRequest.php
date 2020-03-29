<?php

declare(strict_types=1);

namespace Mistrfilda\Pid\Api\Stop;

use Mistrfilda\Pid\Api\Http\Request\Request;
use Mistrfilda\Pid\Api\Http\Response\Response;
use Psr\Http\Message\ResponseInterface;

class StopRequest extends Request
{
    public const URL = 'gtfs/stops';

    public function __construct(int $limit, int $offset)
    {
        $queryParameters = [
            'limit' => $limit,
            'offset' => $offset,
        ];

        parent::__construct(Request::METHOD_GET, self::URL, [], $queryParameters);
    }

    public function processResponse(ResponseInterface $response): Response
    {
        return new StopResponse($response);
    }
}
