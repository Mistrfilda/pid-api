<?php

declare(strict_types=1);

namespace Ofce\Pid\Api\Trip;

use DateTimeImmutable;
use Ofce\Pid\Api\Helper\DatetimeHelper;
use Ofce\Pid\Api\Http\Request\Request;
use Ofce\Pid\Api\Http\Response\Response;
use Psr\Http\Message\ResponseInterface;

class TripRequest extends Request
{
    public const URL = 'gtfs/trips';

    public function __construct(string $stopId, int $limit, int $offset, ?DateTimeImmutable $date = null)
    {
        $queryParameters = [
            'limit' => $limit,
            'offset' => $offset,
            'stopId' => $stopId,
        ];

        if ($date !== null) {
            $queryParameters['date'] = $date->format(DatetimeHelper::API_DATE_FORMAT);
        }

        parent::__construct(Request::METHOD_GET, self::URL, [], $queryParameters);
    }

    public function processResponse(ResponseInterface $response): Response
    {
        return new TripResponse($response);
    }
}
