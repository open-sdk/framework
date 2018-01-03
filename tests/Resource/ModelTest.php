<?php

namespace OpenSdk\Framework\Tests\Resource;

use DateTime;
use OpenSdk\Framework\Resource\Collection;
use OpenSdk\Framework\Resource\Model;
use OpenSdk\Framework\Tests\TestCase;

class ModelTest extends TestCase
{
	public function testIsCollection()
	{
		$this->assertInstanceOf(Collection::class, new Model);
	}

	public function testGetReturnsKeyOrDefault()
	{
		$model = new ModelCastStub(['testAny' => 'isset']);

		$this->assertSame('isset', $model->get('testAny'));
		$this->assertSame('default', $model->get('testNone', 'default'));
	}

	public function testMagicGetterReturnsKeyOrNull()
	{
		$model = new ModelCastStub(['testAny' => 'isset']);

		$this->assertSame('isset', $model->testAny);
		$this->assertNull($model->testNone);
	}

	public function testSetStoresValue()
	{
		$model = new ModelCastStub;

		$this->assertSame($model, $model->set('testAny', 'isset'));
		$this->assertSame('isset', $model->get('testAny'));
	}

	public function testMagicSetterStoresValue()
	{
		$model = new ModelCastStub;
		$model->testAny = 'isset';

		$this->assertSame('isset', $model->testAny);
	}

	public function testEmptyUnknownOrNonExistingClassAttributesAreNotCasted()
	{
		$model = new ModelCastStub([
			'testEmpty' => 'empty',
			'testUnknown' => 'biepboep',
			'testClassNotExists' => 'not-exists',
		]);

		$this->assertSame('empty', $model->testEmpty);
		$this->assertSame('biepboep', $model->testUnknown);
		$this->assertSame('not-exists', $model->testClassNotExists);
	}

	public function testBooleanAttributesAreCasted()
	{
		$model = new ModelCastStub([
			'testBoolean' => true,
			'testBooleanFalse' => false,
			'testBooleanStringTrue' => 'true',
			'testBooleanStringFalse' => 'false',
			'testBooleanStringOne' => '1',
			'testBooleanStringZero' => '0',
		]);

		$this->assertTrue($model->testBoolean);
		$this->assertFalse($model->testBooleanFalse);
		$this->assertTrue($model->testBooleanStringTrue);
		$this->assertFalse($model->testBooleanStringFalse);
		$this->assertTrue($model->testBooleanStringOne);
		$this->assertFalse($model->testBooleanStringZero);
	}

	public function testIntegerAttributesAreCasted()
	{
		$model = new ModelCastStub([
			'testInteger' => 1337,
			'testIntegerStringInteger' => '123',
			'testIntegerStringFloat' => '13.37',
		]);

		$this->assertSame(1337, $model->testInteger);
		$this->assertSame(123, $model->testIntegerStringInteger);
		$this->assertSame(13, $model->testIntegerStringFloat);
	}

	public function testFloatAttributesAreCasted()
	{
		$model = new ModelCastStub([
			'testFloat' => 13.37,
			'testFloatString' => '13.37',
			'testFloatInteger' => '1337',
		]);

		$this->assertSame(13.37, $model->testFloat);
		$this->assertSame(13.37, $model->testFloatString);
		$this->assertSame(1337.0, $model->testFloatInteger);
	}

	public function testStringAttributesAreCasted()
	{
		$model = new ModelCastStub([
			'testString' => 'hi!',
			'testStringInteger' => 1337,
			'testStringBoolean' => true,
		]);

		$this->assertSame('hi!', $model->testString);
		$this->assertSame('1337', $model->testStringInteger);
		$this->assertSame('1', $model->testStringBoolean);
	}

	public function testClassAttributesAreCasted()
	{
		$model = new ModelCastStub([
			'testClass' => ['nested' => 'resource'],
			'testClassDateTime' => '2017-07-03T20:00:00+02:00',
		]);

		$this->assertInstanceOf(Model::class, $model->testClass);
		$this->assertSame('resource', $model->testClass->nested);

		$this->assertInstanceOf(DateTime::class, $model->testClassDateTime);
		$this->assertEquals(
			(new DateTime('2017-07-03T20:00:00+02:00'))->getTimestamp(),
			$model->testClassDateTime->getTimestamp()
		);
	}

	public function testCallableAttributesAreCasted()
	{
		$model = new ModelCastStub([
			'testCallable' => 'strtoupper',
			'testCallableIntegerValue' => '1337unit',
		]);

		$this->assertSame('STRTOUPPER', $model->testCallable);
		$this->assertSame(1337, $model->testCallableIntegerValue);
	}
}
