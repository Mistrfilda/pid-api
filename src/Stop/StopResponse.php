<?php

declare(strict_types=1);

namespace Ofce\Pid\Api\Stop;

use Nette\Schema\Expect;
use Nette\Schema\Schema;
use Ofce\Pid\Api\Http\Response\Response;

class StopResponse extends Response
{
    /** @var int */
    private $count;

    /** @var Stop[] */
    private $stops;

    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @return Stop[]
     */
    public function getStops(): array
    {
        return $this->stops;
    }

    protected function createFromArrayResponse(\stdClass $response): void
    {
        $count = 0;
        foreach ($response->features as $stop) {
            $this->stops[] = new Stop(
                $stop->properties->stop_id,
                $stop->geometry->coordinates[0],
                $stop->geometry->coordinates[1]
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
                    'coordinates' => Expect::array('float')->min(2)->max(2),
                    'type' => Expect::string(),
                ]),
                'properties' => Expect::structure([
                    'level_id' => Expect::string()->nullable(),
                    'location_type' => Expect::int()->nullable(),
                    'parent_station' => Expect::string()->nullable(),
                    'platform_code' => Expect::string()->nullable(),
                    'stop_code' => Expect::string()->nullable(),
                    'stop_desc' => Expect::string()->nullable(),
                    'stop_id' => Expect::string(),
                    'stop_lat' => Expect::float(),
                    'stop_lon' => Expect::float(),
                    'stop_name' => Expect::string(),
                    'stop_timezone' => Expect::string()->nullable(),
                    'stop_url' => Expect::string()->nullable(),
                    'wheelchair_boarding' => Expect::int()->nullable(),
                    'zone_id' => Expect::string()->nullable(),
                    'create_batch_id' => Expect::string()->nullable(),
                    'created_at' => Expect::string()->nullable(),
                    'created_by' => Expect::string()->nullable(),
                    'update_batch_id' => Expect::string()->nullable(),
                    'updated_at' => Expect::string()->nullable(),
                    'updated_by' => Expect::string()->nullable(),
                ]),
                'type' => Expect::string(),
            ]))->min(1),
            'type' => Expect::string(),
        ]);
    }
}
