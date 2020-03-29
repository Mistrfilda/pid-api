<?php

declare(strict_types=1);

namespace Mistrfilda\Pid\Api\Stop;

class Stop
{
    /** @var string */
    private $stopId;

    /** @var float */
    private $latitude;

    /** @var float */
    private $longitude;

    /** @var string */
    private $name;

    public function __construct(
        string $stopId,
        float $latitude,
        float $longitude,
        string $name
    ) {
        $this->stopId = $stopId;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->name = $name;
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

    public function getName(): string
    {
        return $this->name;
    }
}
