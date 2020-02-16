<?php

declare(strict_types=1);


use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Nette\Schema\ValidationException;
use Nette\Utils\FileSystem;
use Ofce\Pid\Api\Client\GuzzlePsr18Client;
use Ofce\Pid\Api\Client\IClientFactory;
use Ofce\Pid\Api\PidService;
use Ofce\Pid\Test\TestDataGetter;
use Tester\Assert;


require __DIR__ . '/../Bootstrap.php';

$mockedHandler = new MockHandler([
	new Response(200, [], FileSystem::read(TestDataGetter::AVAILABLE_DATA['20190216']['stop'])),
	new Response(200, [], FileSystem::read(TestDataGetter::AVAILABLE_DATA['20190216']['stopTime'])),
]);

$mockedGuzzleClient = new GuzzlePsr18Client(['handler' => HandlerStack::create($mockedHandler)]);

$clientFactoryMock = Mockery::mock(IClientFactory::class);
$clientFactoryMock->shouldReceive('createClient')->andReturn($mockedGuzzleClient);

$pidService = new PidService('aaaa', 'http://ofce.cz', $clientFactoryMock);

$stopResponse = $pidService->sendGetStopsRequest();

Assert::equal($stopResponse->getCount(), 20);
$stops = $stopResponse->getStops();
Assert::count($stopResponse->getCount(), $stops);

Assert::equal($stops[0]->getLatitude(), 49.94344);
Assert::equal($stops[3]->getLongitude(), 14.46406);
Assert::equal($stops[16]->getName(), 'Jílové u Prahy,Náměstí');
Assert::equal($stops[19]->getStopId(), 'U210Z2P');



Assert::exception(function () use ($pidService) {
	$stopResponse = $pidService->sendGetStopsRequest();
}, ValidationException::class);