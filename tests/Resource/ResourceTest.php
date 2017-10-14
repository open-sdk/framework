<?php

namespace OpenSdk\Framework\Tests\Resource;

use DateTime;
use OpenSdk\Framework\Resource\Collection;
use OpenSdk\Framework\Resource\Resource;
use OpenSdk\Framework\Tests\TestCase;

class ResourceTest extends TestCase
{
	public function testIsCollection()
	{
		$this->assertInstanceOf(Collection::class, new Resource);
	}

	public function testGetReturnsKeyOrDefault()
	{
		$resource = new Resource(['this' => 'isset']);

		$this->assertSame('isset', $resource->get('this'));
		$this->assertSame('default', $resource->get('that', 'default'));
	}

	public function testMagicGetterReturnsKeyOrNull()
	{
		$resource = new Resource(['this' => 'isset']);

		$this->assertSame('isset', $resource->this);
		$this->assertNull($resource->that);
	}

	public function testSetStoresValue()
	{
		$resource = new Resource;

		$this->assertSame($resource, $resource->set('this', 'isset'));
		$this->assertSame('isset', $resource->get('this'));
	}

	public function testMagicSetterStoresValue()
	{
		$resource = new Resource;
		$resource->this = 'isset';

		$this->assertSame('isset', $resource->this);
	}

	public function testEmptyUnkownOrNonExistingClassAttributesAreNotCasted()
	{
		$resource = new ResourceCastStub([
			'testEmpty' => 'empty',
			'testUnkown' => 'biepboep',
			'testClassNotExists' => 'not-exists',
		]);

		$this->assertSame('empty', $resource->testEmpty);
		$this->assertSame('biepboep', $resource->testUnkown);
		$this->assertSame('not-exists', $resource->testClassNotExists);
	}

	public function testBooleanAttributesAreCasted()
	{
		$resource = new ResourceCastStub([
			'testBoolean' => true,
			'testBooleanFalse' => false,
			'testBooleanStringTrue' => 'true',
			'testBooleanStringFalse' => 'false',
			'testBooleanStringOne' => '1',
			'testBooleanStringZero' => '0',
		]);

		$this->assertSame(true, $resource->testBoolean);
		$this->assertSame(false, $resource->testBooleanFalse);
		$this->assertSame(true, $resource->testBooleanStringTrue);
		$this->assertSame(false, $resource->testBooleanStringFalse);
		$this->assertSame(true, $resource->testBooleanStringOne);
		$this->assertSame(false, $resource->testBooleanStringZero);
	}

	public function testIntegerAttributesAreCasted()
	{
		$resource = new ResourceCastStub([
			'testInteger' => 1337,
			'testIntegerStringInteger' => '123',
			'testIntegerStringFloat' => '13.37',
		]);

		$this->assertSame(1337, $resource->testInteger);
		$this->assertSame(123, $resource->testIntegerStringInteger);
		$this->assertSame(13, $resource->testIntegerStringFloat);
	}

	public function testFloatAttributesAreCasted()
	{
		$resource = new ResourceCastStub([
			'testFloat' => 13.37,
			'testFloatString' => '13.37',
			'testFloatInteger' => '1337',
		]);

		$this->assertSame(13.37, $resource->testFloat);
		$this->assertSame(13.37, $resource->testFloatString);
		$this->assertSame(1337.0, $resource->testFloatInteger);
	}

	public function testStringAttributesAreCasted()
	{
		$resource = new ResourceCastStub([
			'testString' => 'hi!',
			'testStringInteger' => 1337,
			'testStringBoolean' => true,
		]);

		$this->assertSame('hi!', $resource->testString);
		$this->assertSame('1337', $resource->testStringInteger);
		$this->assertSame('1', $resource->testStringBoolean);
	}

	public function testClassAttributesAreCasted()
	{
		$resource = new ResourceCastStub([
			'testClass' => ['nested' => 'resource'],
			'testClassDateTime' => '2017-07-03T20:00:00+02:00',
		]);

		$this->assertInstanceOf(Resource::class, $resource->testClass);
		$this->assertSame('resource', $resource->testClass->nested);

		$this->assertInstanceOf(DateTime::class, $resource->testClassDateTime);
		$this->assertEquals(
			(new DateTime('2017-07-03T20:00:00+02:00'))->getTimestamp(),
			$resource->testClassDateTime->getTimestamp()
		);
	}

	public function testCallableAttributesAreCasted()
	{
		$resource = new ResourceCastStub([
			'testCallable' => 'strtoupper',
			'testCallableIntegerValue' => '1337unit',
		]);

		$this->assertSame('STRTOUPPER', $resource->testCallable);
		$this->assertSame(1337, $resource->testCallableIntegerValue);
	}
}
