<?php

namespace OpenSdk\Framework\Tests\Resource;

use DateTime;
use OpenSdk\Framework\Resource\Model;

class ModelCastStub extends Model
{
	/**
	 * {@inheritdoc}
	 */
	protected static $casts = [
		'testEmpty' => '',
		'testUnkown' => 'biepboep',
		'testClassNotExists' => 'This\Class\Doesnt\Exists',

		'testBoolean' => 'boolean',
		'testBooleanFalse' => 'boolean',
		'testBooleanStringTrue' => 'boolean',
		'testBooleanStringFalse' => 'boolean',
		'testBooleanStringOne' => 'boolean',
		'testBooleanStringZero' => 'boolean',

		'testInteger' => 'integer',
		'testIntegerStringInteger' => 'integer',
		'testIntegerStringFloat' => 'integer',

		'testFloat' => 'float',
		'testFloatString' => 'float',
		'testFloatInteger' => 'float',

		'testString' => 'string',
		'testStringInteger' => 'string',
		'testStringBoolean' => 'string',

		'testClass' => self::class,
		'testClassDateTime' => DateTime::class,

		'testCallable' => 'strtoupper',
		'testCallableIntegerValue' => 'intval',
	];
}
