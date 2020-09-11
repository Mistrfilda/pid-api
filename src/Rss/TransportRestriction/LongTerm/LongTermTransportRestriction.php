<?php

declare(strict_types=1);

namespace Mistrfilda\Pid\Api\Rss\TransportRestriction\LongTerm;

use DateTimeImmutable;

class LongTermTransportRestriction
{
	/** @var string */
	private $guid;

	/** @var string */
	private $title;

	/** @var string */
	private $link;

	/** @var string */
	private $dateString;

	/** @var int */
	private $dateFromTimestamp;

	/** @var int|null */
	private $dateToTimestamp;

	/** @var DateTimeImmutable */
	private $publishedDate;

	/** @var int */
	private $priority;

	/** @var string[] */
	private $lines;

	/** @var string */
	private $description;

	/**
	 * @param string[] $lines
	 */
	public function __construct(
		string $guid,
		string $title,
		string $link,
		string $dateString,
		int $dateFromTimestamp,
		?int $dateToTimestamp,
		DateTimeImmutable $publishedDate,
		int $priority,
		array $lines,
		string $description
	) {
		$this->guid = $guid;
		$this->title = $title;
		$this->link = $link;
		$this->dateString = $dateString;
		$this->dateFromTimestamp = $dateFromTimestamp;
		$this->dateToTimestamp = $dateToTimestamp;
		$this->publishedDate = $publishedDate;
		$this->priority = $priority;
		$this->lines = $lines;
		$this->description = $description;
	}

	public function getGuid(): string
	{
		return $this->guid;
	}

	public function getTitle(): string
	{
		return $this->title;
	}

	public function getLink(): string
	{
		return $this->link;
	}

	public function getDateString(): string
	{
		return $this->dateString;
	}

	public function getDateFromTimestamp(): int
	{
		return $this->dateFromTimestamp;
	}

	public function getDateToTimestamp(): ?int
	{
		return $this->dateToTimestamp;
	}

	public function getPublishedDate(): DateTimeImmutable
	{
		return $this->publishedDate;
	}

	public function getPriority(): int
	{
		return $this->priority;
	}

	/**
	 * @return string[]
	 */
	public function getLines(): array
	{
		return $this->lines;
	}

	public function getDescription(): string
	{
		return $this->description;
	}
}
