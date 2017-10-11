<?php

namespace OpenSdk\Framework\Tests\Client;

use Http\Client\HttpClient;
use Http\Message\MessageFactory as HttpFactory;
use OpenSdk\Framework\Client\Container;
use OpenSdk\Framework\Middleware\StackInterface as MiddlewareStack;
use OpenSdk\Framework\Resource\DecoderInterface as ResourceDecoder;
use OpenSdk\Framework\Tests\TestCase;

class ContainerTest extends TestCase
{
	public function testHttpClientIsStored()
	{
		$client = $this->createMock(HttpClient::class);
		$container = $this->getMockForAbstractClass(Container::class);

		$container->setHttpClient($client);

		$this->assertSame($client, $container->getHttpClient());
	}

	public function testHttpFactoryIsStored()
	{
		$factory = $this->createMock(HttpFactory::class);
		$container = $this->getMockForAbstractClass(Container::class);

		$container->setHttpFactory($factory);

		$this->assertSame($factory, $container->getHttpFactory());
	}

	public function testMiddlewareStackIsStored()
	{
		$stack = $this->createMock(MiddlewareStack::class);
		$container = $this->getMockForAbstractClass(Container::class);

		$stack->expects($this->once())
			->method('setClient')
			->with($this->identicalTo($container))
			->will($this->returnSelf());

		$container->setMiddlewareStack($stack);

		$this->assertSame($stack, $container->getMiddlewareStack());
	}

	public function testResourceDecoderIsStored()
	{
		$decoder = $this->createMock(ResourceDecoder::class);
		$container = $this->getMockForAbstractClass(Container::class);

		$container->setResourceDecoder($decoder);

		$this->assertSame($decoder, $container->getResourceDecoder());
	}
}
