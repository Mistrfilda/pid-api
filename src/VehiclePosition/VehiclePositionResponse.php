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
    private $vehiclePositions = [];

    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @return VehiclePosition[]
     */
    public function getVehiclePositions(): array
    {
        return $this->vehiclePositions;
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
                $vehiclePosition['properties']['trip']['agency_name']['real'],
                $vehiclePosition['properties']['trip']['agency_name']['scheduled'],
                $vehiclePosition['properties']['trip']['gtfs']['route_id'],
                $vehiclePosition['properties']['trip']['gtfs']['route_short_name'],
                $vehiclePosition['properties']['trip']['gtfs']['trip_id'],
                $vehiclePosition['properties']['trip']['vehicle_type']['id'],
                $vehiclePosition['properties']['trip']['vehicle_registration_number'],
                $vehiclePosition['properties']['trip']['wheelchair_accessible'],
                $vehiclePosition['properties']['last_position']['delay']['actual'],
                $vehiclePosition['properties']['last_position']['last_stop']['id'],
                $vehiclePosition['properties']['last_position']['next_stop']['id'],
                $vehiclePosition['properties']['trip']['gtfs']['trip_headsign'],
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
                    'last_position' => Expect::structure([
                        'bearing' => Expect::int(),
                        'delay' => Expect::structure([
                            'actual' => Expect::int(),
                            'last_stop_arrival' => Expect::int()->nullable(),
                            'last_stop_departure' => Expect::int()->nullable(),
                        ])->castTo('array'),
                        'is_canceled' => Expect::bool(),
                        'last_stop' => Expect::structure([
                            'arrival_time' => Expect::string(),
                            'departure_time' => Expect::string(),
                            'id' => Expect::string(),
                            'sequence' => Expect::int(),
                        ])->castTo('array'),
                        'next_stop' => Expect::structure([
                            'arrival_time' => Expect::string(),
                            'departure_time' => Expect::string(),
                            'id' => Expect::string(),
                            'sequence' => Expect::int(),
                        ])->castTo('array'),
                        'origin_timestamp' => Expect::string(),
                        'shape_dist_traveled' => Expect::string()->nullable(),
                        'speed' => Expect::anyOf(Expect::int(), Expect::float())->nullable(),
                    ])->castTo('array'),
                    'trip' => Expect::structure([
                        'agency_name' => Expect::structure([
                            'real' => Expect::string(),
                            'scheduled' => Expect::string(),
                        ])->castTo('array'),
                        'cis' => Expect::structure([
                            'line_id' => Expect::string(),
                            'trip_number' => Expect::int(),
                        ])->castTo('array'),
                        'gtfs' => Expect::structure([
                            'route_id' => Expect::string(),
                            'route_short_name' => Expect::string(),
                            'trip_headsign' => Expect::string(),
                            'trip_id' => Expect::string(),
                        ])->castTo('array'),
                        'origin_route_name' => Expect::string(),
                        'sequence_id' => Expect::int(),
                        'start_timestamp' => Expect::string(),
                        'vehicle_registration_number' => Expect::int(),
                        'vehicle_type' => Expect::structure([
                            'description_cs' => Expect::string(),
                            'description_en' => Expect::string(),
                            'id' => Expect::int(),
                        ])->castTo('array'),
                        'wheelchair_accessible' => Expect::bool(),
                    ])->castTo('array'),
                    'all_positions' => Expect::arrayOf(Expect::mixed()),
                ])->castTo('array'),
                'type' => Expect::string(),
            ])->castTo('array')),
            'type' => Expect::string(),
        ])->castTo('array');
    }
}
