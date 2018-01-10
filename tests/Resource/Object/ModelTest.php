<?php

namespace OpenSdk\Tests\Resource\Object;

use OpenSdk\Exception\ResourceException;
use OpenSdk\Resource\Object\Element;
use OpenSdk\Resource\Object\Model;
use OpenSdk\Tests\ResourceObjectTestCase;
use OpenSdk\Tests\Resource\Stubs\UserModel;

class ModelTest extends ResourceObjectTestCase
{
	public function testIsElementObject()
	{
		$this->assertSubclassOf(Element::class, Model::class);
	}

	public function testGetAsStringCastsValueToString()
	{
		$model = new Model([
			'this' => 'text',
			'also' => 1337,
		]);

		$this->assertSame('text', $model->getAsString('this'));
		$this->assertSame('1337', $model->getAsString('also'));
	}

	public function testGetAsBooleanParsesValueToBoolean()
	{
		$model = new Model([
			'some' => true,
			'canbe' => 'false',
			'right' => 'yes',
			'switch' => 'off',
		]);

		$this->assertTrue($model->getAsBoolean('some'));
		$this->assertFalse($model->getAsBoolean('canbe'));
		$this->assertTrue($model->getAsBoolean('right'));
		$this->assertFalse($model->getAsBoolean('switch'));
	}

	public function testGetAsIntegerCastsValueToInteger()
	{
		$model = new Model([
			'this' => 1337,
			'also' => 13.37,
		]);

		$this->assertSame(1337, $model->getAsInteger('this'));
		$this->assertSame(13, $model->getAsInteger('also'));
	}

	public function testGetAsFloatCastsValueToFloat()
	{
		$model = new Model([
			'this' => 13.37,
			'also' => '13.37',
		]);

		$this->assertSame(13.37, $model->getAsFloat('this'));
		$this->assertSame(13.37, $model->getAsFloat('also'));
	}

	public function testGetAsInstanceWrapsValueInClassType()
	{
		$model = new Model([
			'birthdate' => '1993-03-07T23:00:00+01:00',
			'nested' => [
				'name' => 'Cedric',
			],
		]);

		$birthdate = $model->getAsInstance(\DateTime::class, 'birthdate');
		$nested = $model->getAsInstance(Model::class, 'nested');

		$this->assertInstanceOf(\DateTime::class, $birthdate);
		$this->assertSame(731541600, $birthdate->getTimestamp());

		$this->assertInstanceOf(Model::class, $nested);
		$this->assertSame('Cedric', $nested->getAsString('name'));
	}

	public function testGetAsStringReturnsDefaultWhenKeyDoesntExist()
	{
		$this->assertNull((new Model)->getAsString('unknown'));
		$this->assertSame('13.37', (new Model)->getAsString('unknown', 13.37));
	}

	public function testGetAsBooleanReturnsDefaultWhenKeyDoesntExist()
	{
		$this->assertNull((new Model)->getAsBoolean('unknown'));
		$this->assertTrue((new Model)->getAsBoolean('unknown', true));
	}

	public function testGetAsIntegerReturnsDefaultWhenKeyDoesntExist()
	{
		$this->assertNull((new Model)->getAsInteger('unknown'));
		$this->assertSame(13, (new Model)->getAsInteger('unknown', 13.37));
	}

	public function testGetAsFloatReturnsDefaultWhenKeyDoesntExists()
	{
		$this->assertNull((new Model)->getAsFloat('unknown'));
		$this->assertSame(13.37, (new Model)->getAsFloat('unknown', '13.37'));
	}

	public function testGetAsInstanceReturnsDefaultWhenKeyDoesntExists()
	{
		$default = new Model;

		$this->assertNull((new Model)->getAsInstance(\DateTime::class, 'unknown'));
		$this->assertSame($default, (new Model)->getAsInstance(\DateTime::class, 'unknown', $default));
	}

	public function testValidateReturnsStringIfSameClass()
	{
		$this->assertSame(Model::class, Model::validate(Model::class));
	}

	public function testValidateReturnsStringIfSubclass()
	{
		$this->assertSame(UserModel::class, Model::validate(UserModel::class));
	}

	public function testValidateThrowsExceptionIfNotSameOrSubclass()
	{
		$this->expectException(ResourceException::class);

		Model::validate(\DateTime::class);
	}

	public function testValidateReturnsStringOnSubclassIfSameClass()
	{
		$this->assertSame(UserModel::class, UserModel::validate(UserModel::class));
	}

	public function testValidateThrowsExceptionOnSubclassIfNotSameOrSubclass()
	{
		$this->expectException(ResourceException::class);

		UserModel::validate(Model::class);
	}
}
