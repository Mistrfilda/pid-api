<?php

declare(strict_types=1);

namespace Mistrfilda\Pid\Api\Rss;

class RssFileGetter implements IRssFileGetter
{
	public function getRssFileContents(string $url): string
	{
		$contents = @file_get_contents($url);
		if ($contents === false) {
			throw new RssFileException(
				sprintf('Unable to read contents from url %s', $url)
			);
		}

		return $contents;
	}
}
