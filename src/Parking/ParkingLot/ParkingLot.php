<?php

declare(strict_types=1);

namespace Mistrfilda\Pid\Api\Parking\ParkingLot;

class ParkingLot
{
	/** @var string */
	private $parkingId;

	/** @var float */
	private $latitude;

	/** @var float */
	private $longitude;

	/** @var string */
	private $formattedAddress;

	/** @var string */
	private $parkingType;

	/** @var int */
	private $parkingTypeId;

	/** @var string */
	private $name;

	/** @var int */
	private $lastUpdatedTimestamp;

	/** @var int */
	private $totalNumberOfPlaces;

	/** @var int */
	private $takenPlaces;

	/** @var int */
	private $freePlaces;

	/** @var ?string */
	private $paymentLink;

	/**
	 * Key is number of week day
	 * @var array<int, array<int, float>>
	 */
	private $averageOccupancy;

	/**
	 * ParkingLot constructor.
	 * @param array<int, array<int, float>> $averageOccupancy
	 */
	public function __construct(
		string $parkingId,
		float $latitude,
		float $longitude,
		string $formattedAddress,
		string $parkingType,
		int $parkingTypeId,
		string $name,
		int $lastUpdatedTimestamp,
		int $totalNumberOfPlaces,
		int $takenPlaces,
		int $freePlaces,
		?string $paymentLink,
		array $averageOccupancy
	) {
		$this->parkingId = $parkingId;
		$this->latitude = $latitude;
		$this->longitude = $longitude;
		$this->formattedAddress = $formattedAddress;
		$this->parkingType = $parkingType;
		$this->parkingTypeId = $parkingTypeId;
		$this->name = $name;
		$this->lastUpdatedTimestamp = $lastUpdatedTimestamp;
		$this->totalNumberOfPlaces = $totalNumberOfPlaces;
		$this->takenPlaces = $takenPlaces;
		$this->freePlaces = $freePlaces;
		$this->paymentLink = $paymentLink;
		$this->averageOccupancy = $averageOccupancy;
	}

	public function getParkingId(): string
	{
		return $this->parkingId;
	}

	public function getLatitude(): float
	{
		return $this->latitude;
	}

	public function getLongitude(): float
	{
		return $this->longitude;
	}

	public function getFormattedAddress(): string
	{
		return $this->formattedAddress;
	}

	public function getParkingType(): string
	{
		return $this->parkingType;
	}

	public function getParkingTypeId(): int
	{
		return $this->parkingTypeId;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function getLastUpdatedTimestamp(): int
	{
		return $this->lastUpdatedTimestamp;
	}

	public function getTotalNumberOfPlaces(): int
	{
		return $this->totalNumberOfPlaces;
	}

	public function getTakenPlaces(): int
	{
		return $this->takenPlaces;
	}

	public function getFreePlaces(): int
	{
		return $this->freePlaces;
	}

	/**
	 * @return string
	 */
	public function getPaymentLink(): ?string
	{
		return $this->paymentLink;
	}

	/**
	 * @return array<int, array<int, float>>
	 */
	public function getAverageOccupancy(): array
	{
		return $this->averageOccupancy;
	}
}
