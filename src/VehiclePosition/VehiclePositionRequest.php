<?php

declare(strict_types=1);

namespace Mistrfilda\Pid\Api\VehiclePosition;

use Mistrfilda\Pid\Api\Http\Request\Request;
use Mistrfilda\Pid\Api\Http\Response\Response;
use Psr\Http\Message\ResponseInterface;

class VehiclePositionRequest extends Request
{
    public const URL = 'vehiclepositions';

    public function __construct(
        int $limit,
        int $offset,
        ?string $routeId = null,
        ?string $routeShortName = null
    ) {
        $queryParameters = [
            'limit' => $limit,
            'offset' => $offset,
        ];

        if ($routeId !== null) {
            $queryParameters['routeId'] = $routeId;
        }

        if ($routeShortName !== null) {
            $queryParameters['routeShortName'] = $routeShortName;
        }

        parent::__construct(Request::METHOD_GET, self::URL, [], $queryParameters);
    }

    public function processResponse(ResponseInterface $response): Response
    {
        return new VehiclePositionResponse($response);
    }
}
