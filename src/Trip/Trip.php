<?php

declare(strict_types=1);

namespace Mistrfilda\Pid\Api\Trip;

class Trip
{
	/** @var string */
	private $routeId;

	/** @var string */
	private $serviceId;

	/** @var string */
	private $tripId;

	/** @var string */
	private $tripHeadsign;

	/** @var bool */
	private $wheelchairAccessible;

	public function __construct(
		string $routeId,
		string $serviceId,
		string $tripId,
		string $tripHeadsign,
		bool $wheelchairAccessible
	) {
		$this->routeId = $routeId;
		$this->serviceId = $serviceId;
		$this->tripId = $tripId;
		$this->tripHeadsign = $tripHeadsign;
		$this->wheelchairAccessible = $wheelchairAccessible;
	}

	public function getRouteId(): string
	{
		return $this->routeId;
	}

	public function getServiceId(): string
	{
		return $this->serviceId;
	}

	public function getTripId(): string
	{
		return $this->tripId;
	}

	public function getTripHeadsign(): string
	{
		return $this->tripHeadsign;
	}

	public function isWheelchairAccessible(): bool
	{
		return $this->wheelchairAccessible;
	}
}
