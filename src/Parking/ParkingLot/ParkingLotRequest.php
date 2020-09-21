<?php

declare(strict_types=1);

namespace Mistrfilda\Pid\Api\Parking\ParkingLot;

use Mistrfilda\Pid\Api\Http\Request\Request;
use Mistrfilda\Pid\Api\Http\Response\Response;
use Psr\Http\Message\ResponseInterface;

class ParkingLotRequest extends Request
{
	public const URL = 'parkings';

	public function __construct()
	{
		parent::__construct(Request::METHOD_GET, self::URL, [], []);
	}

	public function processResponse(ResponseInterface $response): Response
	{
		return new ParkingLotResponse($response);
	}
}
