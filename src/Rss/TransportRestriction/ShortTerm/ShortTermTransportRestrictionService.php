<?php

declare(strict_types=1);

namespace Mistrfilda\Pid\Api\Rss\TransportRestriction\ShortTerm;

use DateTimeImmutable;
use Mistrfilda\Pid\Api\Rss\IRssFileGetter;
use Mistrfilda\Pid\Api\Rss\RssFileParsingException;
use Mistrfilda\Pid\Api\Rss\RssXmlParser;
use Nette\Schema\Expect;
use Nette\Schema\Processor;
use Nette\Utils\Html;
use Nette\Utils\Strings;
use SimpleXMLElement;

class ShortTermTransportRestrictionService
{
	public const SHORT_TERM_RESTRICTIONS_URL = 'https://pid.cz/feed/rss-mimoradnosti';

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
	 * @return ShortTermTransportRestriction[]
	 */
	public function getCurrentShortTermRestrictions(): array
	{
		$data = $this->rssXmlParser->parseContents(
			self::ITEM_XML_TAG,
			$this->rssFileGetter->getRssFileContents(self::SHORT_TERM_RESTRICTIONS_URL)
		);

		$parsedRestrictions = [];
		foreach ($data as $item) {
			$parsedItem = $this->processSimpleXmlElement(
				(array) $item
			);

			$description = Strings::trim(Html::htmlToText($parsedItem['description']));
			$parsedRestrictions[] = new ShortTermTransportRestriction(
				$parsedItem['guid'],
				$parsedItem['title'],
				$parsedItem['link'],
				$parsedItem['pubDate'],
				$this->parseLines($description),
				$description
			);
		}

		return $parsedRestrictions;
	}

	/**
	 * @param mixed[] $element
	 * @return array{'title': string, 'link': string, 'guid': string, 'pubDate': DateTimeImmutable, 'description': string}
	 */
	private function processSimpleXmlElement(array $element): array
	{
		$structure = Expect::structure([
			'title' => Expect::string(),
			'link' => Expect::string(),
			'guid' => Expect::string(),
			'pubDate' => Expect::type('object')->nullable()->before(
				function (SimpleXMLElement $value): ?DateTimeImmutable {
					$value = (string) $value;
					if ($value === '') {
						return null;
					}

					return new DateTimeImmutable($value);
				}
			),
			'description' => Expect::anyOf(Expect::string(), Expect::type('object'))->castTo('string'),
		])->otherItems(Expect::mixed())->castTo('array');

		return $this->schemaProcessor->process($structure, $element);
	}

	/**
	 * @return string[]
	 */
	private function parseLines(string $description): array
	{
		$linesString = preg_split('~Dotčené linky:~', $description);
		if ($linesString === false || count($linesString) !== 2) {
			throw new RssFileParsingException('Can\'t parse lines');
		}

		return explode(', ', Strings::trim($linesString[1]));
	}
}
