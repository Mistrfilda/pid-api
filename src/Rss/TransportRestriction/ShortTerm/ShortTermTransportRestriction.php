<?php

declare(strict_types=1);

namespace Mistrfilda\Pid\Api\Rss\TransportRestriction\ShortTerm;

use DateTimeImmutable;

class ShortTermTransportRestriction
{
	/** @var string */
	private $guid;

	/** @var string */
	private $title;

	/** @var string */
	private $link;

	/** @var DateTimeImmutable|null */
	private $publishedDate;

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
		?DateTimeImmutable $publishedDate,
		array $lines,
		string $description
	) {
		$this->guid = $guid;
		$this->title = $title;
		$this->link = $link;
		$this->publishedDate = $publishedDate;
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

	public function getPublishedDate(): ?DateTimeImmutable
	{
		return $this->publishedDate;
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
