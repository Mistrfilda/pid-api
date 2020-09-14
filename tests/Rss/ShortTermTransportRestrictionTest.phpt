<?php

declare(strict_types=1);

use Mistrfilda\Pid\Api\Rss\IRssFileGetter;
use Mistrfilda\Pid\Api\RssService;
use Tester\Assert;

require __DIR__ . '/../Bootstrap.php';


$fileGetterMock = Mockery::mock(IRssFileGetter::class)->makePartial();
$fileGetterMock
	->shouldReceive('getRssFileContents')
	->with('https://pid.cz/feed/rss-mimoradnosti')
	->andReturn(file_get_contents(__DIR__ . '/../Data/TransportRestrictions/short-term-13-9-2020.xml'));

$rssService = new RssService($fileGetterMock);

$response = $rssService->getShortTermRestrictions();

Assert::count(5, $response);
Assert::same('11315-1', $response[0]->getGuid());
Assert::same(
	'Strossmayerovo náměstí (od zastávky Vltavská) - Provoz omezen, Zpoždění spojů',
	$response[0]->getTitle()
);
Assert::same('14.9. 09:29 - do odvolání; Dotčené linky: 1, 12, 25', $response[0]->getDescription());
Assert::count(3, $response[0]->getLines());

Assert::same('11312-1', $response[3]->getGuid());
Assert::same('zpoždění v autobusové síti DPP - Zpoždění spojů', $response[3]->getTitle());
Assert::same('https://pid.cz/mimoradnost/?id=11312-1', $response[3]->getLink());
Assert::same(
	'14.9. 07:00 - do odvolání; Dotčené linky: 124, 129, 135, 136, 139, 140, 165, 175, 177, 180, 181, 182, 183, 184, 193, 195, 201, 225, 241, 244, 250, 340, 347, 351, 364',
	$response[3]->getDescription()
);
Assert::count(25, $response[3]->getLines());
