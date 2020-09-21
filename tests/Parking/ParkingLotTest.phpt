<?php

declare(strict_types=1);

require __DIR__ . '/../Bootstrap.php';

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Mistrfilda\Pid\Api\Client\GuzzlePsr18Client;
use Mistrfilda\Pid\Api\Client\IClientFactory;
use Mistrfilda\Pid\Api\GolemioService;
use Mistrfilda\Pid\Test\Data\TestDataGetter;
use Nette\Schema\ValidationException;
use Nette\Utils\FileSystem;
use Tester\Assert;

$mockedHandler = new MockHandler([
	new Response(200, [], FileSystem::read(TestDataGetter::AVAILABLE_DATA['20200921']['parkingLot'])),
	new Response(200, [], FileSystem::read(TestDataGetter::AVAILABLE_DATA['20190216']['stopTime'])),
]);

$mockedGuzzleClient = new GuzzlePsr18Client(['handler' => HandlerStack::create($mockedHandler)]);

$clientFactoryMock = Mockery::mock(IClientFactory::class);
$clientFactoryMock->shouldReceive('createClient')->andReturn($mockedGuzzleClient);

$pidService = new GolemioService('aaaa', 'http://ofce.cz', $clientFactoryMock);

$parkingLotResponse = $pidService->sendGetParkingLotRequest();

Assert::equal($parkingLotResponse->getCount(), 19);
$parkingLots = $parkingLotResponse->getParkingLots();
Assert::count($parkingLotResponse->getCount(), $parkingLots);

Assert::equal($parkingLots[0]->getLatitude(), 50.053432);
Assert::equal($parkingLots[3]->getLongitude(), 14.517204);
Assert::equal($parkingLots[8]->getName(), 'Wilsonova');
Assert::equal($parkingLots[10]->getParkingId(), '534016');
Assert::equal($parkingLots[12]->getParkingId(), '534012');
Assert::equal($parkingLots[11]->getTotalNumberOfPlaces(), 1205);
Assert::equal($parkingLots[11]->getFreePlaces(), 753);
Assert::equal($parkingLots[11]->getTakenPlaces(), 452);



Assert::exception(function () use ($pidService): void {
	$pidService->sendGetParkingLotRequest();
}, ValidationException::class);
