<?php

declare(strict_types=1);

namespace Mistrfilda\Pid\Api\VehiclePosition;

class VehiclePosition
{
    /** @var float */
    private $latitude;

    /** @var float */
    private $longitude;

    /** @var string */
    private $company;

    /** @var string */
    private $scheduledCompany;

    /** @var string */
    private $routeId;

    /** @var string */
    private $shortRouteId;

    /** @var string */
    private $tripId;

    /** @var ?int */
    private $vehicleType;

    /** @var int */
    private $vehicleRegistrationNumber;

    /** @var bool */
    private $wheelchairAccessible;

    /** @var int */
    private $delay;

    /** @var string */
    private $lastStopId;

    /** @var string */
    private $nextStopId;

    /** @var string */
    private $tripHeadsign;

    /**
     * VehiclePosition constructor.
     */
    public function __construct(
        float $latitude,
        float $longitude,
        string $company,
        string $scheduledCompany,
        string $routeId,
        string $shortRouteId,
        string $tripId,
        ?int $vehicleType,
        int $vehicleRegistrationNumber,
        bool $wheelchairAccessible,
        int $delay,
        string $lastStopId,
        string $nextStopId,
        string $tripHeadsign
    ) {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->company = $company;
        $this->scheduledCompany = $scheduledCompany;
        $this->routeId = $routeId;
        $this->shortRouteId = $shortRouteId;
        $this->tripId = $tripId;
        $this->vehicleType = $vehicleType;
        $this->vehicleRegistrationNumber = $vehicleRegistrationNumber;
        $this->wheelchairAccessible = $wheelchairAccessible;
        $this->delay = $delay;
        $this->lastStopId = $lastStopId;
        $this->nextStopId = $nextStopId;
        $this->tripHeadsign = $tripHeadsign;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function getCompany(): string
    {
        return $this->company;
    }

    public function getRouteId(): string
    {
        return $this->routeId;
    }

    public function getShortRouteId(): string
    {
        return $this->shortRouteId;
    }

    public function getTripId(): string
    {
        return $this->tripId;
    }

    public function getVehicleType(): ?int
    {
        return $this->vehicleType;
    }

    public function getVehicleRegistrationNumber(): int
    {
        return $this->vehicleRegistrationNumber;
    }

    public function getWheelchairAccessible(): bool
    {
        return $this->wheelchairAccessible;
    }

    public function getDelay(): int
    {
        return $this->delay;
    }

    public function getLastStopId(): string
    {
        return $this->lastStopId;
    }

    public function getNextStopId(): string
    {
        return $this->nextStopId;
    }

    public function getScheduledCompany(): string
    {
        return $this->scheduledCompany;
    }

    public function getTripHeadsign(): string
    {
        return $this->tripHeadsign;
    }
}
