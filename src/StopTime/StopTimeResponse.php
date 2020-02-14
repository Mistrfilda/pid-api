<?php

declare(strict_types=1);

namespace Ofce\Pid\Api\StopTime;

use Nette\Schema\Expect;
use Nette\Schema\Schema;
use Ofce\Pid\Api\Http\Response\Response;

class StopTimeResponse extends Response
{
    /** @var int */
    private $count;

    /** @var StopTime[] */
    private $stopTimes;

    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @return StopTime[]
     */
    public function getStopTimes(): array
    {
        return $this->stopTimes;
    }

    /**
     * @param array<mixed, mixed> $response
     */
    protected function createFromArrayResponse(array $response): void
    {
        $count = 0;
        foreach ($response as $stopTime) {
            $this->stopTimes[] = new StopTime(
                $stopTime['arrival_time'],
                $stopTime['departure_time'],
                $stopTime['trip_id'],
                $stopTime['stop_sequence']
            );
            $count++;
        }

        $this->count = $count;
    }

    protected function getResponseSchema(): Schema
    {
        return Expect::arrayOf(
            Expect::structure([
                'arrival_time' => Expect::string(),
                'arrival_time_seconds' => Expect::anyOf(Expect::string(), Expect::int())->nullable(),
                'departure_time' => Expect::string(),
                'departure_time_seconds' => Expect::anyOf(Expect::string(), Expect::int())->nullable(),
                'drop_off_type' => Expect::string()->nullable(),
                'pickup_type' => Expect::string(),
                'shape_dist_traveled' => Expect::anyOf(Expect::int(), Expect::float()),
                'stop_headsign' => Expect::string()->nullable(),
                'stop_id' => Expect::string(),
                'stop_sequence' => Expect::int(),
                'timepoint' => Expect::anyOf(Expect::string(), Expect::int())->nullable(),
                'trip_id' => Expect::string(),
            ])->castTo('array')
        );
    }
}
