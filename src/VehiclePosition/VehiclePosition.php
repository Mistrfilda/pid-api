<?php

declare(strict_types=1);

namespace Ofce\Pid\Api\VehiclePosition;

class VehiclePosition
{
    /** @var float */
    private $latitude;

    /** @var float */
    private $longitude;

    /** @var string */
    private $company;

    /** @var string */
    private $routeId;

    /** @var string */
    private $shortRouteId;

    /** @var string */
    private $tripId;

    /** @var string */
    private $dateId;

    /**
     * @var int
     * WAITING FOR API V2
     */
    private $vehicleType;

    /**
     * @var string
     * WAITING FOR API V2
     */
    private $vehicleRegistrationNumber;

    /** @var bool */
    private $wheelchairAccessible;

    /** @var int */
    private $delay;

    /** @var string */
    private $lastStopId;

    /** @var string */
    private $nextStopId;

    /**
     * VehiclePosition constructor.
     */
    public function __construct(
        float $latitude,
        float $longitude,
        string $company,
        string $routeId,
        string $shortRouteId,
        string $tripId,
        string $dateId,
        int $vehicleType,
        string $vehicleRegistrationNumber,
        bool $wheelchairAccessible,
        int $delay,
        string $lastStopId,
        string $nextStopId
    ) {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->company = $company;
        $this->routeId = $routeId;
        $this->shortRouteId = $shortRouteId;
        $this->tripId = $tripId;
        $this->dateId = $dateId;
        $this->vehicleType = $vehicleType;
        $this->vehicleRegistrationNumber = $vehicleRegistrationNumber;
        $this->wheelchairAccessible = $wheelchairAccessible;
        $this->delay = $delay;
        $this->lastStopId = $lastStopId;
        $this->nextStopId = $nextStopId;
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

    public function getDateId(): string
    {
        return $this->dateId;
    }

    public function getVehicleType(): int
    {
        return $this->vehicleType;
    }

    public function getVehicleRegistrationNumber(): string
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
}
