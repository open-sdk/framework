<?php

namespace OpenSdk\Tests\Resource;

use OpenSdk\Exception\ResourceException;
use OpenSdk\Resource\Decoder;
use OpenSdk\Resource\Manager;
use OpenSdk\Resource\ManagerFactory;
use OpenSdk\Resource\Object\Model;
use OpenSdk\Tests\Resource\Stubs\UserModel;
use OpenSdk\Tests\TestCase;

class ManagerFactoryTest extends TestCase
{
	public function testConstructorStoresDecoder()
	{
		$decoder = $this->createMock(Decoder::class);
		$factory = new ManagerFactory($decoder);

		$this->assertSame($decoder, $factory->getDecoder());
	}

	public function testConstructorStoresModelType()
	{
		$decoder = $this->createMock(Decoder::class);
		$factory = new ManagerFactory($decoder, UserModel::class);

		$this->assertSame(UserModel::class, $factory->getModelType());
	}

	public function testConstructorStoresUnwrapPath()
	{
		$decoder = $this->createMock(Decoder::class);
		$factory = new ManagerFactory($decoder, UserModel::class, 'data');

		$this->assertSame('data', $factory->getUnwrap());
	}

	public function testConstructorThrowsExceptionForInvalidModelTypes()
	{
		$this->expectException(ResourceException::class);

		new ManagerFactory($this->createMock(Decoder::class), \DateTime::class);
	}

	public function testGetDecoderReturnsDefaultDecoder()
	{
		$this->assertInstanceOf(Decoder::class, (new ManagerFactory)->getDecoder());
	}

	public function testSetDecoderStoresDecoder()
	{
		$decoder = $this->createMock(Decoder::class);
		$factory = (new ManagerFactory)->setDecoder($decoder);

		$this->assertSame($decoder, $factory->getDecoder());
	}

	public function testGetModelTypeReturnsDefaultModelType()
	{
		$this->assertSame(Model::class, (new ManagerFactory)->getModelType());
	}

	public function testSetModelTypeStoresModelType()
	{
		$factory = (new ManagerFactory)->setModelType(UserModel::class);

		$this->assertSame(UserModel::class, $factory->getModelType());
	}

	public function testSetModelTypeThrowsExceptionForInvalidModelTypes()
	{
		$this->expectException(ResourceException::class);

		(new ManagerFactory)->setModelType(\DateTime::class);
	}

	public function testGetUnwrapReturnsSetUnwrap()
	{
		$factory = (new ManagerFactory)->setUnwrap('data');

		$this->assertSame('data', $factory->getUnwrap());
	}

	public function testSetUnwrapCanRemoveUnwrap()
	{
		$factory = (new ManagerFactory)->setUnwrap('data');

		$this->assertNull($factory->setUnwrap(null)->getUnwrap());
	}

	public function testCreateManagerReturnsManager()
	{
		$request = $this->mockRequest();
		$response = $this->mockResponse();
		$manager = (new ManagerFactory)->createManager($request, $response);

		$this->assertInstanceOf(Manager::class, $manager);
		$this->assertSame($request, $manager->getRequest());
		$this->assertSame($response, $manager->getResponse());
	}

	public function testCreateManagerReturnsManagerWithDecoderModelTypeAndUnwrap()
	{
		$request = $this->mockRequest();
		$response = $this->mockResponse();
		$decoder = $this->createMock(Decoder::class);
		$manager = (new ManagerFactory($decoder, UserModel::class, 'data'))->createManager($request, $response);

		$this->assertSame($decoder, $manager->getDecoder());
		$this->assertSame(UserModel::class, $manager->getModelType());
		$this->assertSame('data', $manager->getUnwrap());
	}
}
