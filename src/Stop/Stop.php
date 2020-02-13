<?php

declare(strict_types=1);

namespace Ofce\Pid\Api\Stop;

class Stop
{
    /** @var string */
    private $stopId;

    /** @var float */
    private $latitude;

    /** @var float */
    private $longitude;

    public function __construct(
        string $stopId,
        float $latitude,
        float $longitude
    ) {
        $this->stopId = $stopId;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function getStopId(): string
    {
        return $this->stopId;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }
}
