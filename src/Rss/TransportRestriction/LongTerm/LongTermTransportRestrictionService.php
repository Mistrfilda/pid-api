<?php

declare(strict_types=1);

namespace Mistrfilda\Pid\Api\Rss\TransportRestriction\LongTerm;

use DateTimeImmutable;
use Mistrfilda\Pid\Api\Rss\IRssFileGetter;
use Mistrfilda\Pid\Api\Rss\RssFileException;
use Mistrfilda\Pid\Api\Rss\RssXmlParser;
use Nette\Schema\Expect;
use Nette\Schema\Processor;

class LongTermTransportRestrictionService
{
	public const LONG_TERM_RESTRICTIONS_URL = 'https://pid.cz/feed/rss-vyluky';

	private const ITEM_XML_TAG = 'item';

	/** @var IRssFileGetter */
	private $rssFileGetter;

	/** @var RssXmlParser */
	private $rssXmlParser;

	/** @var Processor */
	private $schemaProcessor;

	public function __construct(IRssFileGetter $rssFileGetter, RssXmlParser $rssXmlParser)
	{
		$this->rssXmlParser = $rssXmlParser;
		$this->rssFileGetter = $rssFileGetter;
		$this->schemaProcessor = new Processor();
	}

	/**
	 * @return LongTermTransportRestriction[]
	 * @throws RssFileException
	 */
	public function getCurrentLongTermRestrictions(): array
	{
		$data = $this->rssXmlParser->parseContents(
			self::ITEM_XML_TAG,
			$this->rssFileGetter->getRssFileContents(self::LONG_TERM_RESTRICTIONS_URL)
		);

		$parsedRestrictions = [];
		foreach ($data as $item) {
			$parsedItem = $this->processSimpleXmlElement(
				array_merge((array) $item, ['description' => (string) $item->children('content', true)])
			);

			$parsedRestrictions[] = new LongTermTransportRestriction(
				$parsedItem['guid'],
				$parsedItem['title'],
				$parsedItem['link'],
				$parsedItem['date'],
				$parsedItem['dateFrom'],
				$parsedItem['dateTo'],
				new DateTimeImmutable($parsedItem['pubDate']),
				$parsedItem['priority'],
				$this->parseLines($parsedItem['lines']),
				$parsedItem['description']
			);
		}

		return $parsedRestrictions;
	}

	/**
	 * @param mixed[] $element
	 * @return array{'title': string, 'link': string, 'guid': string, 'date': string, 'dateFrom': int, 'dateTo': int|null, 'pubDate': string, 'priority': int, 'lines': mixed[], 'description': string}
	 */
	private function processSimpleXmlElement(array $element): array
	{
		$structure = Expect::structure([
			'title' => Expect::string(),
			'link' => Expect::string(),
			'guid' => Expect::string(),
			'date' => Expect::string(),
			'dateFrom' => Expect::string()->castTo('int'),
			'dateTo' => Expect::int()->nullable()->before(
				function ($value): ?int {
					$value = (int) $value;
					if ($value === 0) {
						return null;
					}

					return $value;
				}
			),
			'pubDate' => Expect::string(),
			'priority' => Expect::string()->castTo('int'),
			'lines' => Expect::type('object')->castTo('array'),
			'description' => Expect::string(),
		])->otherItems(Expect::mixed())->castTo('array');

		return $this->schemaProcessor->process($structure, $element);
	}

	/**
	 * @param mixed[] $linesArray
	 * @return string[]
	 */
	private function parseLines(array $linesArray): array
	{
		$parsedLine = $linesArray['line'];
		//Well, this is ugly but didnt found better way to deal with single line element (simple xml element does that)
		if (is_string($parsedLine)) {
			return [$parsedLine];
		}

		return $parsedLine;
	}
}
