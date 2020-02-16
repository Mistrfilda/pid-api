<?php

declare(strict_types=1);

use GuzzleHttp\Exception\ClientException as GuzzleClientException;
use GuzzleHttp\Exception\RequestException as GuzzleRequestException;
use GuzzleHttp\Exception\ConnectException as GuzzleNetworkException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Nette\Utils\FileSystem;
use Ofce\Pid\Api\Client\ClientException;
use Ofce\Pid\Api\Client\GuzzlePsr18Client;
use Ofce\Pid\Api\Client\IClientFactory;
use Ofce\Pid\Api\Client\NetworkException;
use Ofce\Pid\Api\Client\RequestException;
use Ofce\Pid\Api\PidService;
use Ofce\Pid\Test\TestDataGetter;
use Tester\Assert;


require __DIR__ . '/../Bootstrap.php';

$mockedHandler = new MockHandler([
	new Response(200, [], FileSystem::read(TestDataGetter::AVAILABLE_DATA['20190216']['stop'])),

	//Request Exception
	new GuzzleClientException('Error test', new Request('GET', 'test'), new Response(404)),
	new GuzzleRequestException('Error test due to invalid request', new Request('GET', 'test')),
	new GuzzleNetworkException('Error due to network connection', new Request('GET', 'test'))
]);

$mockedGuzzleClient = new GuzzlePsr18Client(['handler' => HandlerStack::create($mockedHandler)]);

$clientFactoryMock = Mockery::mock(IClientFactory::class);
$clientFactoryMock->shouldReceive('createClient')->andReturn($mockedGuzzleClient);

$pidService = new PidService('aaaa', 'http://ofce.cz', $clientFactoryMock);

Assert::noError(function () use ($pidService) {
	$pidService->sendGetStopsRequest();
});

Assert::exception(function () use ($pidService) {
	$pidService->sendGetStopsRequest();
}, ClientException::class, 'Error test');

Assert::exception(function () use ($pidService) {
	$pidService->sendGetStopsRequest();
}, RequestException::class, 'Error test due to invalid request');

Assert::exception(function () use ($pidService) {
	$pidService->sendGetStopsRequest();
}, NetworkException::class, 'Error due to network connection');