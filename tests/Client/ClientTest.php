<?php

namespace OpenSdk\Framework\Tests\Client;

use OpenSdk\Framework\Client\Client;
use OpenSdk\Framework\Middleware\MiddlewareInterface;
use OpenSdk\Framework\Middleware\StackInterface;
use OpenSdk\Framework\Resource\Factory as ResourceFactory;
use OpenSdk\Framework\Tests\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

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
		$middleware = $this->createMock(MiddlewareInterface::class);
		$stack = $this->createMock(StackInterface::class);
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
		$request = $this->createMock(RequestInterface::class);
		$response = $this->createMock(ResponseInterface::class);
		$stack = $this->createMock(StackInterface::class);
		$client = $this->getMockForAbstractClass(Client::class);

		$stack->method('setClient')
			->willReturn($stack);

		$stack->expects($this->once())
			->method('__invoke')
			->with(
				$this->identicalTo($request),
				$this->isInstanceOf(ResponseInterface::class)
			)
			->willReturn($response);

		$client->setMiddlewareStack($stack);
		$resources = $client->send($request);

		$this->assertInstanceOf(ResourceFactory::class, $resources);
		$this->assertSame($client, $resources->getClient());
	}
}
