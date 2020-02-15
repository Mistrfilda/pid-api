<?php

declare(strict_types=1);

namespace Ofce\Pid\Api\VehiclePosition;

use Nette\Schema\Expect;
use Nette\Schema\Schema;
use Ofce\Pid\Api\Http\Response\Response;

class VehiclePositionResponse extends Response
{
    /** @var int */
    private $count;

    /** @var VehiclePosition[] */
    private $vehiclePositions;

    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @param array<mixed, mixed> $response
     */
    protected function createFromArrayResponse(array $response): void
    {
        $count = 0;
        foreach ($response['features'] as $vehiclePosition) {
            $this->vehiclePositions[] = new VehiclePosition(
                $vehiclePosition['geometry']['coordinates'][1],
                $vehiclePosition['geometry']['coordinates'][0],
                $vehiclePosition['properties']['trip']['cis_agency_name'],
                $vehiclePosition['properties']['trip']['gtfs_route_id'],
                $vehiclePosition['properties']['trip']['gtfs_route_short_name'],
                $vehiclePosition['properties']['trip']['gtfs_trip_id'],
                $vehiclePosition['properties']['trip']['id'],
                $vehiclePosition['properties']['trip']['vehicle_type'],
                'TODO VERSION V2',
                $vehiclePosition['properties']['trip']['wheelchair_accessible'],
                $vehiclePosition['properties']['last_position']['delay'],
                $vehiclePosition['properties']['last_position']['gtfs_last_stop_id'],
                $vehiclePosition['properties']['last_position']['gtfs_next_stop_id']
            );

            $count++;
        }

        $this->count = $count;
    }

    protected function getResponseSchema(): Schema
    {
        return Expect::structure([
            'features' => Expect::arrayOf(Expect::structure([
                'geometry' => Expect::structure([
                    'coordinates' => Expect::arrayOf(Expect::anyOf(Expect::int(), Expect::float()))->min(2)->max(2),
                    'type' => Expect::string(),
                ])->castTo('array'),
                'properties' => Expect::structure([
                    'trip' => Expect::arrayOf(Expect::mixed()), //TODO VALIDATION FOR VERSION V2
                    'last_position' => Expect::arrayOf(Expect::mixed()), //TODO VALIDATION FOR VERSION V2
                    'all_positions' => Expect::arrayOf(Expect::mixed()),
                ])->castTo('array'),
                'type' => Expect::string(),
            ])->castTo('array')),
            'type' => Expect::string(),
        ])->castTo('array');
    }
}
