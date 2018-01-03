<?php

namespace OpenSdk\Framework\Tests\Resource;

use DateTime;
use OpenSdk\Framework\Resource\Model;

/**
 * @property mixed $testAny
 * @property mixed $testNone
 * @property mixed $testEmpty
 * @property mixed $testUnknown
 * @property mixed $testClassNotExists
 * @property boolean $testBoolean
 * @property boolean $testBooleanFalse
 * @property boolean $testBooleanStringTrue
 * @property boolean $testBooleanStringFalse
 * @property boolean $testBooleanStringOne
 * @property boolean $testBooleanStringZero
 * @property integer $testInteger
 * @property integer $testIntegerStringInteger
 * @property integer $testIntegerStringFloat
 * @property float $testFloat
 * @property float $testFloatString
 * @property float $testFloatInteger
 * @property string $testString
 * @property string $testStringInteger
 * @property string $testStringBoolean
 * @property NestedModelStub $testClass
 * @property DateTime $testClassDateTime
 * @property string $testCallable
 * @property integer $testCallableIntegerValue
 */
class ModelCastStub extends Model
{
	/**
	 * {@inheritdoc}
	 */
	protected static $casts = [
		'testEmpty' => '',
		'testUnknown' => 'biepboep',
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

		'testClass' => NestedModelStub::class,
		'testClassDateTime' => DateTime::class,

		'testCallable' => 'strtoupper',
		'testCallableIntegerValue' => 'intval',
	];
}
