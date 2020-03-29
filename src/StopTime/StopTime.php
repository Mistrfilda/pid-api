<?php

declare(strict_types=1);

namespace Mistrfilda\Pid\Api\StopTime;

class StopTime
{
    /** @var string */
    private $arivalTime;

    /** @var string */
    private $departureTime;

    /** @var string */
    private $tripId;

    /** @var int */
    private $stopSequence;

    public function __construct(
        string $arivalTime,
        string $departureTime,
        string $tripId,
        int $stopSequence
    ) {
        $this->arivalTime = $arivalTime;
        $this->departureTime = $departureTime;
        $this->tripId = $tripId;
        $this->stopSequence = $stopSequence;
    }

    public function getArivalTime(): string
    {
        return $this->arivalTime;
    }

    public function getDepartureTime(): string
    {
        return $this->departureTime;
    }

    public function getTripId(): string
    {
        return $this->tripId;
    }

    public function getStopSequence(): int
    {
        return $this->stopSequence;
    }
}
