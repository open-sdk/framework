<?php

namespace OpenSdk\Framework\Tests\Middleware;

use Http\Client\HttpClient;
use OpenSdk\Framework\Middleware\MiddlewareInterface;
use OpenSdk\Framework\Middleware\SendRequestMiddleware;
use OpenSdk\Framework\Tests\TestCase;

class SendRequestMiddlewareTest extends TestCase
{
	public function testStoresClient()
	{
		$client = $this->createClient();
		$middleware = new SendRequestMiddleware;

		$this->assertSame($middleware, $middleware->setClient($client));
		$this->assertSame($client, $middleware->getClient());
	}

	public function testSendsRequestAndProvideResponse()
	{
		$request = $this->mockRequest();
		$response = $this->mockResponse();
		$client = $this->createClient();
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
