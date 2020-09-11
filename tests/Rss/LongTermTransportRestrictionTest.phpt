<?php

declare(strict_types=1);

use Mistrfilda\Pid\Api\Rss\IRssFileGetter;
use Mistrfilda\Pid\Api\RssService;
use Tester\Assert;

require __DIR__ . '/../Bootstrap.php';


$fileGetterMock = Mockery::mock(IRssFileGetter::class)->makePartial();
$fileGetterMock
	->shouldReceive('getRssFileContents')
	->with('https://pid.cz/feed/rss-vyluky')
	->andReturn(file_get_contents(__DIR__ . '/../Data/TransportRestrictions/long-term-9-9-2020.xml'));

$rssService = new RssService($fileGetterMock);

$response = $rssService->getLongTermRestrictions();

Assert::count(120, $response);
Assert::same('https://pid.cz/?post_type=exclusion&p=22589', $response[1]->getGuid());
Assert::count(4, $response[4]->getLines());
Assert::same('https://pid.cz/?post_type=exclusion&p=22604', $response[5]->getGuid());
Assert::same(1592776800, $response[9]->getDateFromTimestamp());
Assert::same(
	'Linky: 480<br>od 21.9.2020 do 18.12.2020 Vážení cestující, z důvodu rekonstrukce ulice ČSA v Lysé nad Labem dochází k dopravnímu opatření na následujících linkách PID:',
	$response[15]->getDescription()
);
Assert::same('https://pid.cz/vyluky/benesov-u-prahy-strancice-praha-hl-n/', $response[22]->getLink());
Assert::same('Dočasné zrušení linky 13', $response[55]->getTitle());
Assert::same(1599854700, $response[78]->getPublishedDate()->getTimestamp());
