<?php

namespace OpenSdk\Tests\Resource;

use OpenSdk\Exception\ResourceException;
use OpenSdk\Resource\Decoder;
use OpenSdk\Resource\Manager;
use OpenSdk\Resource\Object\Collection;
use OpenSdk\Resource\Object\Model;
use OpenSdk\Tests\Resource\Stubs\UserModel;
use OpenSdk\Tests\TestCase;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ManagerTest extends TestCase
{
	/**
	 * Create a new resource manager instance with a decoder and return value predefined.
	 *
	 * @param array         $data
	 * @param Response|null $response
	 * @param Request|null  $request
	 *
	 * @return Manager
	 */
	protected function createManager(
		array $data = [],
		Response $response = null,
		Request $request = null
	) {
		$request = $request ?: $this->mockRequest();
		$response = $response ?: $this->mockResponse();
		$decoder = $this->createMock(Decoder::class);

		$decoder->method('decode')
			->with($this->identicalTo($response))
			->willReturn($data);

		return new Manager($request, $response, $decoder);
	}

	public function testConstructorStoresRequest()
	{
		$manager = new Manager(
			$request = $this->mockRequest(),
			$this->mockResponse()
		);

		$this->assertSame($request, $manager->getRequest());
	}

	public function testConstructorStoresResponse()
	{
		$manager = new Manager(
			$this->mockRequest(),
			$response = $this->mockResponse()
		);

		$this->assertSame($response, $manager->getResponse());
	}

	public function testConstructorStoresDecoder()
	{
		$manager = new Manager(
			$this->mockRequest(),
			$this->mockResponse(),
			$decoder = $this->createMock(Decoder::class)
		);

		$this->assertSame($decoder, $manager->getDecoder());
	}

	public function testConstructorStoresModelType()
	{
		$manager = new Manager(
			$this->mockRequest(),
			$this->mockResponse(),
			$this->createMock(Decoder::class),
			$modelType = UserModel::class
		);

		$this->assertSame($modelType, $manager->getModelType());
	}

	public function testConstructorStoresUnwrapPath()
	{
		$manager = new Manager(
			$this->mockRequest(),
			$this->mockResponse(),
			$this->createMock(Decoder::class),
			UserModel::class,
			$unwrap = 'data'
		);

		$this->assertSame($unwrap, $manager->getUnwrap());
	}

	public function testConstructorThrowsResourceExceptionForInvalidModelTypes()
	{
		$this->expectException(ResourceException::class);

		new Manager(
			$this->mockRequest(),
			$this->mockResponse(),
			$this->createMock(Decoder::class),
			\DateTime::class
		);
	}

	public function testGetDecoderReturnsDefaultDecoder()
	{
		// [note]: don't use `createManager` as it creates an external decoder
		$manager = new Manager($this->mockRequest(), $this->mockResponse());

		$this->assertInstanceOf(Decoder::class, $manager->getDecoder());
	}

	public function testSetDecoderStoresDecoder()
	{
		$decoder = $this->createMock(Decoder::class);
		$manager = $this->createManager()->setDecoder($decoder);

		$this->assertSame($decoder, $manager->getDecoder());
	}

	public function testGetModelTypeReturnsDefaultType()
	{
		$this->assertSame(Model::class, $this->createManager()->getModelType());
	}

	public function testSetModelTypeStoresType()
	{
		$manager = $this->createManager()->setModelType(UserModel::class);

		$this->assertSame(UserModel::class, $manager->getModelType());
	}

	public function testSetModelTypeThrowsExceptionForInvalidTypes()
	{
		$this->expectException(ResourceException::class);
		$this->createManager()->setModelType(\DateTime::class);
	}

	public function testAsArrayReturnsDecodedValue()
	{
		$manager = $this->createManager(['decoded' => true]);

		$this->assertArraySubset(['decoded' => true], $manager->asArray());
	}

	public function testAsArrayUnwrapsDecodedValue()
	{
		$manager = $this->createManager(['data' => ['decoded' => true]])->setUnwrap('data');

		$this->assertArraySubset(['decoded' => true], $manager->asArray());
	}

	public function testAsArrayReturnsDecodedValueForUnkownUnwrap()
	{
		$manager = $this->createManager(['data' => ['decoded' => true]])->setUnwrap('unknown');

		$this->assertArraySubset(['data' => ['decoded' => true]], $manager->asArray());
	}

	public function testAsModelReturnsModel()
	{
		$manager = $this->createManager(['name' => 'Cedric']);

		$this->assertInstanceOf(Model::class, $manager->asModel());
	}

	public function testAsModelReturnsModelWithDefaultType()
	{
		$manager = $this->createManager(['name' => 'Cedric'])
			->setModelType(UserModel::class);

		$this->assertInstanceOf(UserModel::class, $manager->asModel());
	}

	public function testAsModelReturnsModelWithProvidedType()
	{
		$manager = $this->createManager(['name' => 'Cedric']);

		$this->assertInstanceOf(UserModel::class, $manager->asModel(UserModel::class));
	}

	public function testAsModelThrowsExceptionForInvalidModelType()
	{
		$this->expectException(ResourceException::class);
		$this->createManager()->asModel(\DateTime::class);
	}

	public function testAsModelReturnsModelWithUnwrappedData()
	{
		$manager = $this->createManager(['data' => ['name' => 'Cedric']])->setUnwrap('data');

		$this->assertSame('Cedric', $manager->asModel(UserModel::class)->getName());
	}

	public function testAsCollectionReturnsCollectionWithModels()
	{
		$manager = $this->createManager([['name' => 'Cedric']]);

		$this->assertInstanceOf(Collection::class, $manager->asCollection());
		$this->assertInstanceOf(Model::class, $manager->asCollection()->get(0));
	}

	public function testAsCollectionReturnsCollectionWithDefaultType()
	{
		$manager = $this->createManager([['name' => 'Cedric']]);

		$manager->setModelType(UserModel::class);

		$this->assertInstanceOf(Collection::class, $manager->asCollection());
		$this->assertInstanceOf(UserModel::class, $manager->asCollection()->get(0));
	}

	public function testAsCollectionReturnsCollectionWithProvidedType()
	{
		$manager = $this->createManager([['name' => 'Cedric']]);

		$this->assertInstanceOf(Collection::class, $manager->asCollection(UserModel::class));
		$this->assertInstanceOf(UserModel::class, $manager->asCollection(UserModel::class)->get(0));
	}

	public function testAsCollectionThrowsExceptionIfClassTypeIsNotAModel()
	{
		$this->expectException(ResourceException::class);
		$this->createManager()->asCollection(\DateTime::class);
	}

	public function testAsCollectionReturnsCollectionWithUnwrappedData()
	{
		$manager = $this->createManager(['data' => [['name' => 'Cedric']]])->setUnwrap('data');

		$this->assertSame('Cedric', $manager->asCollection(UserModel::class)->get(0)->getName());
	}

	public function testAsCollectionReturnsCollectionWithDataForUnknownUnwrap()
	{
		$manager = $this->createManager([['name' => 'Cedric']])->setUnwrap('unknown');

		$this->assertSame('Cedric', $manager->asCollection(UserModel::class)->get(0)->getName());
	}
}
