<?php

declare(strict_types=1);

namespace Mistrfilda\Pid\Api;

use Mistrfilda\Pid\Api\Rss\IRssFileGetter;
use Mistrfilda\Pid\Api\Rss\RssFileGetter;
use Mistrfilda\Pid\Api\Rss\RssXmlParser;
use Mistrfilda\Pid\Api\Rss\TransportRestriction\LongTerm\LongTermTransportRestriction;
use Mistrfilda\Pid\Api\Rss\TransportRestriction\LongTerm\LongTermTransportRestrictionService;
use Mistrfilda\Pid\Api\Rss\TransportRestriction\ShortTerm\ShortTermTransportRestriction;
use Mistrfilda\Pid\Api\Rss\TransportRestriction\ShortTerm\ShortTermTransportRestrictionService;

class RssService
{
	/** @var LongTermTransportRestrictionService */
	private $longTermTransportRestrictionService;

	/** @var ShortTermTransportRestrictionService */
	private $shortTermTransportRestrictionService;

	public function __construct(?IRssFileGetter $rssFileGetter)
	{
		if ($rssFileGetter === null) {
			$rssFileGetter = new RssFileGetter();
		}

		$rssXmlParser = new RssXmlParser();

		$this->longTermTransportRestrictionService = new LongTermTransportRestrictionService(
			$rssFileGetter,
			$rssXmlParser
		);

		$this->shortTermTransportRestrictionService = new ShortTermTransportRestrictionService(
			$rssFileGetter,
			$rssXmlParser
		);
	}

	/**
	 * @return LongTermTransportRestriction[]
	 */
	public function getLongTermRestrictions(): array
	{
		return $this->longTermTransportRestrictionService->getCurrentLongTermRestrictions();
	}

	/**
	 * @return ShortTermTransportRestriction[]
	 */
	public function getShortTermRestrictions(): array
	{
		return $this->shortTermTransportRestrictionService->getCurrentShortTermRestrictions();
	}
}
