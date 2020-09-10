<?php

declare(strict_types=1);

use GuzzleHttp\Exception\ClientException as GuzzleClientException;
use GuzzleHttp\Exception\ConnectException as GuzzleNetworkException;
use GuzzleHttp\Exception\RequestException as GuzzleRequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Mistrfilda\Pid\Api\Client\ClientException;
use Mistrfilda\Pid\Api\Client\GuzzlePsr18Client;
use Mistrfilda\Pid\Api\Client\IClientFactory;
use Mistrfilda\Pid\Api\Client\NetworkException;
use Mistrfilda\Pid\Api\Client\RequestException;
use Mistrfilda\Pid\Api\GolemioService;
use Mistrfilda\Pid\Test\Data\TestDataGetter;
use Nette\Utils\FileSystem;
use Tester\Assert;

require __DIR__ . '/../Bootstrap.php';

$mockedHandler = new MockHandler([
	new Response(200, [], FileSystem::read(TestDataGetter::AVAILABLE_DATA['20190216']['stop'])),

	//Request Exception
	new GuzzleClientException('Error test', new Request('GET', 'test'), new Response(404)),
	new GuzzleRequestException('Error test due to invalid request', new Request('GET', 'test')),
	new GuzzleNetworkException('Error due to network connection', new Request('GET', 'test')),
]);

$mockedGuzzleClient = new GuzzlePsr18Client(['handler' => HandlerStack::create($mockedHandler)]);

$clientFactoryMock = Mockery::mock(IClientFactory::class);
$clientFactoryMock->shouldReceive('createClient')->andReturn($mockedGuzzleClient);

$pidService = new GolemioService('aaaa', 'http://ofce.cz', $clientFactoryMock);

Assert::noError(function () use ($pidService): void {
	$pidService->sendGetStopsRequest();
});

Assert::exception(function () use ($pidService): void {
	$pidService->sendGetStopsRequest();
}, ClientException::class, 'Error test');

Assert::exception(function () use ($pidService): void {
	$pidService->sendGetStopsRequest();
}, RequestException::class, 'Error test due to invalid request');

Assert::exception(function () use ($pidService): void {
	$pidService->sendGetStopsRequest();
}, NetworkException::class, 'Error due to network connection');
