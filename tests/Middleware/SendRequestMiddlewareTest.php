<?php

namespace OpenSdk\Tests\Middleware;

use Http\Client\HttpClient;
use OpenSdk\Client\Client;
use OpenSdk\Middleware\Middleware;
use OpenSdk\Middleware\SendRequestMiddleware;
use OpenSdk\Tests\TestCase;

class SendRequestMiddlewareTest extends TestCase
{
	public function testIsMiddleware()
	{
		$this->assertSubclassOf(Middleware::class, SendRequestMiddleware::class);
	}

	public function testStoresClient()
	{
		$client = $this->createMock(Client::class);
		$middleware = new SendRequestMiddleware;

		$this->assertSame($middleware, $middleware->setClient($client));
		$this->assertSame($client, $middleware->getClient());
	}

	public function testSendsRequestAndProvideResponse()
	{
		$request = $this->mockRequest();
		$response = $this->mockResponse();
		$client = $this->getMockForAbstractClass(Client::class);
		$http = $this->createMock(HttpClient::class);

		$next = function ($request, $response) {
			return $response;
		};

		$client->setHttpClient($http);

		$http->expects($this->once())
			->method('sendRequest')
			->with($this->identicalTo($request))
			->willReturn($response);

		$middleware = (new SendRequestMiddleware)->setClient($client);

		$this->assertSame($response, $middleware($request, $this->mockResponse(), $next));
	}
}
