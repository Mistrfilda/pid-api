<?php

declare(strict_types=1);

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Nette\Utils\FileSystem;
use Ofce\Pid\Api\Client\GuzzlePsr18Client;
use Ofce\Pid\Api\Client\IClientFactory;
use Ofce\Pid\Api\PidService;
use Ofce\Pid\Test\TestDataGetter;
use Tester\Assert;

require __DIR__ . '/../Bootstrap.php';

$mockedHandler = new MockHandler([
    new Response(200, [], FileSystem::read(TestDataGetter::AVAILABLE_DATA['20190216']['trip'])),
]);

$mockedGuzzleClient = new GuzzlePsr18Client(['handler' => HandlerStack::create($mockedHandler)]);

$clientFactoryMock = Mockery::mock(IClientFactory::class);
$clientFactoryMock->shouldReceive('createClient')->andReturn($mockedGuzzleClient);

$pidService = new PidService('aaaa', 'http://ofce.cz', $clientFactoryMock);

$tripResponse = $pidService->sendGetStopTripsRequest('1234');

Assert::equal($tripResponse->getCount(), 20);
$trips = $tripResponse->getTrips();
Assert::count($tripResponse->getCount(), $trips);

Assert::equal($trips[0]->getTripId(), '910_206_190901');
Assert::equal($trips[5]->getRouteId(), 'L910');
Assert::equal($trips[11]->getServiceId(), '0000011-1');
Assert::equal($trips[14]->getTripHeadsign(), 'Letiště');
Assert::equal($trips[19]->isWheelchairAccessible(), true);
