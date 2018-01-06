<?php

namespace OpenSdk\Tests\Client;

use OpenSdk\Client\Application;
use OpenSdk\Client\Client;
use OpenSdk\Middleware\Middleware;
use OpenSdk\Middleware\Stack;
use OpenSdk\Resource\Factory as ResourceFactory;
use OpenSdk\Tests\TestCase;
use Psr\Http\Message\ResponseInterface as Response;

class ClientTest extends TestCase
{
	public function testApplicationIsStored()
	{
		$app = $this->createMock(Application::class);
		$client = $this->getMockForAbstractClass(Client::class);

		$client->setApplication($app);

		$this->assertSame($app, $client->getApplication());
	}

	public function testApplicationIsNullByDefault()
	{
		$this->assertNull(
			$this->getMockForAbstractClass(Client::class)
				->getApplication()
		);
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
