<?php

declare(strict_types=1);

namespace Mistrfilda\Pid\Api\Parking\ParkingLot;

use Mistrfilda\Pid\Api\Http\Response\Response;
use Nette\Schema\Expect;
use Nette\Schema\Schema;

class ParkingLotResponse extends Response
{
	/** @var int */
	private $count;

	/** @var ParkingLot[] */
	private $parkingLots = [];

	public function getCount(): int
	{
		return $this->count;
	}

	/**
	 * @return ParkingLot[]
	 */
	public function getParkingLots(): array
	{
		return $this->parkingLots;
	}

	/**
	 * @param array<mixed, mixed> $response
	 */
	protected function createFromArrayResponse(array $response): void
	{
		$count = 0;
		foreach ($response['features'] as $parkingLot) {
			$this->parkingLots[] = new ParkingLot(
				$parkingLot['properties']['id'],
				$parkingLot['geometry']['coordinates'][1],
				$parkingLot['geometry']['coordinates'][0],
				$parkingLot['properties']['address']['address_formatted'],
				$parkingLot['properties']['parking_type']['description'],
				$parkingLot['properties']['parking_type']['id'],
				$parkingLot['properties']['name'],
				$parkingLot['properties']['last_updated'],
				$parkingLot['properties']['total_num_of_places'],
				$parkingLot['properties']['num_of_taken_places'],
				$parkingLot['properties']['num_of_free_places'],
				$parkingLot['properties']['payment_link'],
				$parkingLot['properties']['average_occupancy']
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
					'id' => Expect::anyOf(Expect::int(), Expect::string(), Expect::float())->castTo('string'),
					'address' => Expect::arrayOf('string'),
					'parking_type' => Expect::structure([
						'description' => Expect::string(),
						'id' => Expect::int(),
					])->castTo('array'),
					'name' => Expect::string(),
					'last_updated' => Expect::int()->before(function ($value): int {
						return (int) $value;
					}),
					'total_num_of_places' => Expect::int(),
					'num_of_free_places' => Expect::int(),
					'num_of_taken_places' => Expect::int(),
					'payment_link' => Expect::string()->nullable(),
					'average_occupancy' => Expect::arrayOf(Expect::mixed()),
				])->otherItems(Expect::anyOf(Expect::int(), Expect::string(), Expect::float(), Expect::null()))->castTo('array'),
				'type' => Expect::string(),
			])->castTo('array')),
			'type' => Expect::string(),
		])->castTo('array');
	}
}
