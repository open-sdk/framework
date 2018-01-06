<?php

namespace OpenSdk\Tests\Client;

use OpenSdk\Client\Client;
use OpenSdk\Middleware\Middleware;
use OpenSdk\Middleware\Stack;
use OpenSdk\Resource\Factory as ResourceFactory;
use OpenSdk\Tests\TestCase;
use Psr\Http\Message\ResponseInterface as Response;

class ClientTest extends TestCase
{
	public function testClientConstructsDefaultImplementations()
	{
		$client = $this->getMockForAbstractClass(Client::class);

		$this->assertNotEmpty($client->getHttpClient());
		$this->assertNotEmpty($client->getHttpFactory());
		$this->assertNotEmpty($client->getMiddlewareStack());
		$this->assertNotEmpty($client->getResourceDecoder());
	}

	public function testUsePushesMiddlewareToStack()
	{
		$middleware = $this->createMock(Middleware::class);
		$stack = $this->createMock(Stack::class);
		$client = $this->getMockForAbstractClass(Client::class);

		$stack->method('setClient')
			->willReturn($stack);

		$stack->expects($this->once())
			->method('push')
			->with($this->identicalTo($middleware));

		$client->setMiddlewareStack($stack);
		$client->use($middleware);
	}

	public function testSendExecutesMiddlewareStackAndReturnsResourceFactory()
	{
		$request = $this->mockRequest();
		$response = $this->mockResponse();
		$stack = $this->createMock(Stack::class);
		$client = $this->getMockForAbstractClass(Client::class);

		$stack->method('setClient')
			->willReturn($stack);

		$stack->expects($this->once())
			->method('__invoke')
			->with(
				$this->identicalTo($request),
				$this->isInstanceOf(Response::class)
			)
			->willReturn($response);

		$client->setMiddlewareStack($stack);
		$resources = $client->send($request);

		$this->assertInstanceOf(ResourceFactory::class, $resources);
		$this->assertSame($client, $resources->getClient());
	}
}
