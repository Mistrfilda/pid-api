<?php

declare(strict_types=1);

namespace Mistrfilda\Pid\Api\Rss;

interface IRssFileGetter
{
	public function getRssFileContents(string $url): string;
}
