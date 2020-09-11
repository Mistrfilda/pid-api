<?php

declare(strict_types=1);

namespace Mistrfilda\Pid\Api\Rss;

use SimpleXMLElement;
use Throwable;

class RssXmlParser
{
	/**
	 * @return SimpleXMLElement[]
	 */
	public function parseContents(string $xpathElement, string $contents): array
	{
		$simpleXmlEelement = @simplexml_load_string($contents);
		if ($simpleXmlEelement === false) {
			throw new RssFileException('Invalid xml');
		}

		try {
			$data = $simpleXmlEelement->xpath('//' . $xpathElement);
			if ($data === false) {
				throw new RssFileException(
					sprintf('Path %s not found in xml', '//' . $xpathElement)
				);
			}
		} catch (Throwable $e) {
			throw new RssFileException('Error occured while parsing xml');
		}

		return $data;
	}
}
