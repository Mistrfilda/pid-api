<?php

declare(strict_types=1);

namespace Mistrfilda\Pid\Api\Rss\TransportRestriction\ShortTerm;

use Mistrfilda\Pid\Api\Rss\IRssFileGetter;
use Mistrfilda\Pid\Api\Rss\RssXmlParser;

class ShortTermTransportRestrictionService
{
	public const LONG_TERM_RESTRICTIONS_URL = 'https://pid.cz/feed/rss-vyluky';

	private const ITEM_XML_TAG = 'item';

	/** @var IRssFileGetter */
	private $rssFileGetter;

	/** @var RssXmlParser */
	private $rssXmlParser;

	public function __construct(IRssFileGetter $rssFileGetter, RssXmlParser $rssXmlParser)
	{
		$this->rssXmlParser = $rssXmlParser;
		$this->rssFileGetter = $rssFileGetter;
	}

	/**
	 * @return ShortTermTransportRestriction[]
	 */
	public function getCurrentShortTermRestrictions(): array
	{
	}
}
