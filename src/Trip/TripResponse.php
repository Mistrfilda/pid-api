<?php

declare(strict_types=1);

namespace Mistrfilda\Pid\Api\Trip;

use Mistrfilda\Pid\Api\Http\Response\Response;
use Nette\Schema\Expect;
use Nette\Schema\Schema;

class TripResponse extends Response
{
	/** @var int */
	private $count;

	/** @var Trip[] */
	private $trips = [];

	public function getCount(): int
	{
		return $this->count;
	}

	/**
	 * @return Trip[]
	 */
	public function getTrips(): array
	{
		return $this->trips;
	}

	/**
	 * @param array<mixed, mixed> $response
	 */
	protected function createFromArrayResponse(array $response): void
	{
		$count = 0;
		foreach ($response as $trip) {
			$this->trips[] = new Trip(
				$trip['route_id'],
				$trip['service_id'],
				$trip['trip_id'],
				$trip['trip_headsign'],
				$trip['wheelchair_accessible']
			);
			$count++;
		}

		$this->count = $count;
	}

	protected function getResponseSchema(): Schema
	{
		return Expect::arrayOf(
			Expect::structure([
				'bikes_allowed' => Expect::int(),
				'block_id' => Expect::anyOf(Expect::string(), Expect::int())->nullable(),
				'direction_id' => Expect::anyOf(Expect::string(), Expect::int())->nullable(),
				'exceptional' => Expect::anyOf(Expect::string(), Expect::int())->nullable(),
				'route_id' => Expect::string(),
				'service_id' => Expect::string(),
				'shape_id' => Expect::string(),
				'trip_headsign' => Expect::string(),
				'trip_id' => Expect::string(),
				'trip_operation_type' => Expect::anyOf(Expect::string(), Expect::int())->nullable(),
				'trip_short_name' => Expect::string()->nullable(),
				'wheelchair_accessible' => Expect::int()->castTo('bool'),
			])->castTo('array')
		);
	}
}
