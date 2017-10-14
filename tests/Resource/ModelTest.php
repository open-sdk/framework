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
		$model = new Model(['this' => 'isset']);

		$this->assertSame('isset', $model->get('this'));
		$this->assertSame('default', $model->get('that', 'default'));
	}

	public function testMagicGetterReturnsKeyOrNull()
	{
		$model = new Model(['this' => 'isset']);

		$this->assertSame('isset', $model->this);
		$this->assertNull($model->that);
	}

	public function testSetStoresValue()
	{
		$model = new Model;

		$this->assertSame($model, $model->set('this', 'isset'));
		$this->assertSame('isset', $model->get('this'));
	}

	public function testMagicSetterStoresValue()
	{
		$model = new Model;
		$model->this = 'isset';

		$this->assertSame('isset', $model->this);
	}

	public function testEmptyUnkownOrNonExistingClassAttributesAreNotCasted()
	{
		$model = new ModelCastStub([
			'testEmpty' => 'empty',
			'testUnkown' => 'biepboep',
			'testClassNotExists' => 'not-exists',
		]);

		$this->assertSame('empty', $model->testEmpty);
		$this->assertSame('biepboep', $model->testUnkown);
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

		$this->assertSame(true, $model->testBoolean);
		$this->assertSame(false, $model->testBooleanFalse);
		$this->assertSame(true, $model->testBooleanStringTrue);
		$this->assertSame(false, $model->testBooleanStringFalse);
		$this->assertSame(true, $model->testBooleanStringOne);
		$this->assertSame(false, $model->testBooleanStringZero);
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
