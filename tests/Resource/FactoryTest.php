<?php

namespace OpenSdk\Framework\Tests\Resource;

use OpenSdk\Framework\Exception\ResourceException;
use OpenSdk\Framework\Resource\Collection;
use OpenSdk\Framework\Resource\DecoderInterface;
use OpenSdk\Framework\Resource\Factory as ResourceFactory;
use OpenSdk\Framework\Resource\Resource;
use OpenSdk\Framework\Tests\TestCase;

class FactoryTest extends TestCase
{
	public function testFactoryStoresClient()
	{
		$request = $this->mockRequest();
		$response = $this->mockResponse();
		$client = $this->createClient();

		$factory = new ResourceFactory($request, $response);

		$this->assertSame($factory, $factory->setClient($client));
		$this->assertSame($client, $factory->getClient());
	}

	public function testFactoryStoresRequestAndResponse()
	{
		$request = $this->mockRequest();
		$response = $this->mockResponse();

		$factory = new ResourceFactory($request, $response);

		$this->assertSame($request, $factory->getRequest());
		$this->assertSame($response, $factory->getResponse());
	}

	public function testAsArrayInvokesDecoder()
	{
		$request = $this->mockRequest();
		$response = $this->mockResponse();
		$client = $this->createClient();
		$decoder = $this->createMock(DecoderInterface::class);

		$factory = (new ResourceFactory($request, $response))->setClient($client);

		$client->setResourceDecoder($decoder);

		$decoder->method('toArray')
			->with($this->identicalTo($factory))
			->willReturn(['decoded' => true]);

		$data = $factory->asArray();

		$this->assertTrue($data['decoded']);
	}

	public function testAsResourceInvokesDecoderAndReturnResource()
	{
		$request = $this->mockRequest();
		$response = $this->mockResponse();
		$client = $this->createClient();
		$decoder = $this->createMock(DecoderInterface::class);

		$factory = (new ResourceFactory($request, $response))->setClient($client);

		$client->setResourceDecoder($decoder);

		$decoder->method('toArray')
			->with($this->identicalTo($factory))
			->willReturn(['decoded' => true]);

		$resource = $factory->asResource();

		$this->assertInstanceOf(Resource::class, $resource);
	}

	public function testAsResourceThrowsResourceException()
	{
		$request = $this->mockRequest();
		$response = $this->mockResponse();

		$factory = new ResourceFactory($request, $response);

		$this->expectException(ResourceException::class);

		$factory->asResource(Object::class);
	}

	public function testAsCollectionInvokesDecoderAndReturnsCollection()
	{
		$request = $this->mockRequest();
		$response = $this->mockResponse();
		$client = $this->createClient();
		$decoder = $this->createMock(DecoderInterface::class);

		$factory = (new ResourceFactory($request, $response))->setClient($client);

		$client->setResourceDecoder($decoder);

		$decoder->method('toArray')
			->with($this->identicalTo($factory))
			->willReturn([['decoded' => true]]);

		$collection = $factory->asCollection();

		$this->assertInstanceOf(Collection::class, $collection);
		$this->assertInstanceOf(Resource::class, $collection[0]);
	}

	public function testAsCollectionThrowsResourceException()
	{
		$request = $this->mockRequest();
		$response = $this->mockResponse();

		$factory = new ResourceFactory($request, $response);

		$this->expectException(ResourceException::class);

		$factory->asCollection(Object::class);
	}
}
