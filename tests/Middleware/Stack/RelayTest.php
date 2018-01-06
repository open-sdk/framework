<?php

namespace OpenSdk\Tests\Middleware\Stack;

use Http\Client\HttpClient;
use OpenSdk\Client\ClientAware;
use OpenSdk\Middleware\Middleware;
use OpenSdk\Middleware\Stack\Relay as RelayStack;
use OpenSdk\Tests\TestCase;

class RelayTest extends TestCase
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
		$aware = $this->createMock(ClientAware::class);

		$aware->expects($this->once())
			->method('setClient')
			->will($this->returnSelf());

		$stack = new RelayStack;
		$stack->push($aware);
		$stack->setClient($client);
	}

	public function testStackPushesMiddleware()
	{
		$middleware = $this->createMock(Middleware::class);

		$this->assertEmpty((new RelayStack)->push($middleware));
	}

	public function testStackPushesClientAware()
	{
		$aware = $this->createMock(ClientAware::class);
		$aware->expects($this->never())
			->method('setClient');

		(new RelayStack)->push($aware);
	}

	public function testStackPushesClientAwareAndPassesClient()
	{
		$client = $this->createClient();
		$aware = $this->createMock(ClientAware::class);

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
