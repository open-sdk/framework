<?php

namespace OpenSdk\Tests\Middleware;

use Http\Client\HttpClient;
use OpenSdk\Client\ClientAwareInterface;
use OpenSdk\Middleware\MiddlewareInterface;
use OpenSdk\Middleware\RelayStack;
use OpenSdk\Tests\TestCase;

class RelayStackTest extends TestCase
{
	public function testStackStoresClient()
	{
		$client = $this->createClient();
		$stack = new RelayStack;

		$this->assertSame($stack, $stack->setClient($client));
		$this->assertSame($client, $stack->getClient());
	}

	public function testStackPassesClientInRetrospect()
	{
		$client = $this->createClient();
		$aware = $this->createMock(ClientAwareInterface::class);

		$aware->expects($this->once())
			->method('setClient')
			->will($this->returnSelf());

		$stack = new RelayStack;
		$stack->push($aware);
		$stack->setClient($client);
	}

	public function testStackPushesMiddleware()
	{
		$middleware = $this->createMock(MiddlewareInterface::class);

		$this->assertEmpty((new RelayStack)->push($middleware));
	}

	public function testStackPushesClientAware()
	{
		$aware = $this->createMock(ClientAwareInterface::class);
		$aware->expects($this->never())
			->method('setClient');

		(new RelayStack)->push($aware);
	}

	public function testStackPushesClientAwareAndPassesClient()
	{
		$client = $this->createClient();
		$aware = $this->createMock(ClientAwareInterface::class);

		$aware->expects($this->once())
			->method('setClient')
			->with($this->identicalTo($client))
			->will($this->returnSelf());

		(new RelayStack)->setClient($client)->push($aware);
	}

	public function testStackSendsRequest()
	{
		$client = $this->createClient();
		$http = $this->createMock(HttpClient::class);
		$request = $this->mockRequest();
		$response = $this->mockResponse();

		$client->setHttpClient($http);

		$http->method('sendRequest')
			->with($this->identicalTo($request))
			->willReturn($response);

		$stack = (new RelayStack)->setClient($client);

		$this->assertSame($response, $stack($request, $this->mockResponse()));
	}
}
