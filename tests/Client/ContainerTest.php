<?php

namespace OpenSdk\Tests\Client;

use Http\Client\HttpClient;
use Http\Message\MessageFactory as HttpFactory;
use OpenSdk\Client\Container;
use OpenSdk\Middleware\Stack as MiddlewareStack;
use OpenSdk\Resource\ManagerFactory as ResourceManagerFactory;
use OpenSdk\Tests\TestCase;

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

	public function testResourceManagerFactoryIsStored()
	{
		$factory = $this->createMock(ResourceManagerFactory::class);
		$container = $this->getMockForAbstractClass(Container::class);

		$container->setResourceManagerFactory($factory);

		$this->assertSame($factory, $container->getResourceManagerFactory());
	}
}
