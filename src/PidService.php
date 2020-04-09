<?php

declare(strict_types=1);

namespace Mistrfilda\Pid\Api;

use DateTimeImmutable;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use Mistrfilda\Pid\Api\Client\ClientFactory;
use Mistrfilda\Pid\Api\Client\IClientFactory;
use Mistrfilda\Pid\Api\Http\Request\Request;
use Mistrfilda\Pid\Api\Http\Response\InvalidResponseException;
use Mistrfilda\Pid\Api\Http\Response\Response;
use Mistrfilda\Pid\Api\Http\UrlFactory;
use Mistrfilda\Pid\Api\Stop\StopRequest;
use Mistrfilda\Pid\Api\Stop\StopResponse;
use Mistrfilda\Pid\Api\StopTime\StopTimeRequest;
use Mistrfilda\Pid\Api\StopTime\StopTimeResponse;
use Mistrfilda\Pid\Api\Trip\TripRequest;
use Mistrfilda\Pid\Api\Trip\TripResponse;
use Mistrfilda\Pid\Api\VehiclePosition\VehiclePositionRequest;
use Mistrfilda\Pid\Api\VehiclePosition\VehiclePositionResponse;
use Psr\Http\Client\ClientInterface;

class PidService
{
	public const BASE_URI = 'https://api.golemio.cz/v2';

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

	public function sendGetStopsRequest(
		int $limit = 100,
		int $offset = 0
	): StopResponse {
		$request = new StopRequest($limit, $offset);
		$response = $this->sendRequest($request);

		if (! $response instanceof StopResponse) {
			throw new InvalidResponseException('Invalid response returned from request');
		}

		return $response;
	}

	public function sendGetStopTimesRequest(
		string $stopId,
		int $limit = 100,
		int $offset = 0,
		?DateTimeImmutable $date = null
	): StopTimeResponse {
		$request = new StopTimeRequest($stopId, $limit, $offset, $date);
		$response = $this->sendRequest($request);

		if (! $response instanceof StopTimeResponse) {
			throw new InvalidResponseException('Invalid response returned from request');
		}

		return $response;
	}

	public function sendGetStopTripsRequest(
		string $stopId,
		int $limit = 100,
		int $offset = 0,
		?DateTimeImmutable $date = null
	): TripResponse {
		$request = new TripRequest($stopId, $limit, $offset, $date);
		$response = $this->sendRequest($request);

		if (! $response instanceof TripResponse) {
			throw new InvalidResponseException('Invalid response returned from request');
		}

		return $response;
	}

	public function sendGetVehiclePositionRequest(
		int $limit = 100,
		int $offset = 0,
		?string $routeId = null,
		?string $routeShortName = null
	): VehiclePositionResponse {
		$request = new VehiclePositionRequest(
			$limit,
			$offset,
			$routeId,
			$routeShortName
		);

		$response = $this->sendRequest($request);

		if (! $response instanceof VehiclePositionResponse) {
			throw new InvalidResponseException('Invalid response returned from request');
		}

		return $response;
	}

	private function sendRequest(Request $request): Response
	{
		$urlFactory = new UrlFactory($this->baseUri, $request->getEndpoint());

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
