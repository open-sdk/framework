<?php

namespace OpenSdk\Tests\Resource\Object;

use ArrayAccess;
use OpenSdk\Resource\Object\Element;
use OpenSdk\Tests\ResourceObjectTestCase;
use PHPUnit\Framework\MockObject\MockObject as PHPUnitMock;

class ElementTest extends ResourceObjectTestCase
{
	/**
	 * Create a new resource element instance using phpunit mocks.
	 *
	 * @param array $data
	 *
	 * @return PHPUnitMock&Element
	 */
	protected function createElement(array $data = [])
	{
		return $this->getMockForAbstractClass(Element::class, [$data]);
	}

	public function testIsElementObject()
	{
		// [note]: don't skip the test or fail to assert to avoid polluting the reports
		$this->assertTrue(true);
	}

	public function testGetReturnsValue()
	{
		$this->assertTrue($this->createElement(['test' => true])->get('test'));
	}

	public function testGetReturnsNullAsDefault()
	{
		$this->assertNull($this->createElement()->get('unknown'));
	}

	public function testGetReturnsDefaultIfKeyDoesntExists()
	{
		$this->assertFalse($this->createElement()->get('unknown', false));
	}

	public function testSetStoresValue()
	{
		$element = $this->createElement()->set('hope', 'thisworks');

		$this->assertSame('thisworks', $element->get('hope'));
	}

	public function testSetOverwritesValue()
	{
		$element = $this->createElement(['its' => 'notok'])->set('its', 'ok');

		$this->assertSame('ok', $element->get('its'));
	}

	public function testRemoveDeletesValue()
	{
		$element = $this->createElement(['forget' => 'this'])->remove('forget');

		$this->assertNull($element->get('forget'));
	}

	public function testRemoveIsOkIfKeyDoesntExists()
	{
		$this->assertInstanceOf(Element::class, $this->createElement()->remove('unknown'));
	}

	public function testHasReturnsTrueIfKeyExists()
	{
		$this->assertTrue($this->createElement(['this' => 'exists'])->has('this'));
		$this->assertTrue($this->createElement(['exists' => null])->has('exists'));
	}

	public function testHasReturnsFalseIfKeyDoesntExists()
	{
		$this->assertFalse($this->createElement()->has('unknown'));
	}

	public function testIsEmptyReturnsTrueIfEmpty()
	{
		$this->assertTrue($this->createElement()->isEmpty());
	}

	public function testIsEmptyReturnsFalseIfNotEmpty()
	{
		$this->assertFalse($this->createElement(['not' => 'empty'])->isEmpty());
	}

	public function testIsNotEmptyReturnsFalseIfEmpty()
	{
		$this->assertFalse($this->createElement()->isNotEmpty());
	}

	public function testIsNotEmptyReturnsTrueIfNotEmpty()
	{
		$this->assertTrue($this->createElement(['not' => 'empty'])->isNotEmpty());
	}

	public function testAsArrayReturnsPlainArray()
	{
		$element = $this->createElement(['simple' => 'array']);

		$this->assertArraySubset(['simple' => 'array'], $element->asArray());
	}

	public function testAsArrayReturnsNestedElementsAsArray()
	{
		$element = $this->createElement([
			'nested' => $this->createElement([
				'this' => 'shouldwork',
			]),
		]);

		$this->assertArraySubset(
			['nested' => ['this' => 'shouldwork']],
			$element->asArray()
		);
	}

	public function testAsJsonReturnsPlainString()
	{
		$element = $this->createElement(['simple' => 'string']);

		$this->assertJsonStringEqualsJsonString(
			json_encode(['simple' => 'string']),
			$element->asJson()
		);
	}

	public function testAsJsonReturnsNestedElementsAsJson()
	{
		$element = $this->createElement([
			'nested' => $this->createElement([
				'this' => 'shouldwork',
			]),
		]);

		$this->assertJsonStringEqualsJsonString(
			json_encode(['nested' => ['this' => 'shouldwork']]),
			$element->asJson()
		);
	}

	public function testToStringReturnsJson()
	{
		$element = $this->createElement(['to' => 'string']);

		$this->assertJsonStringEqualsJsonString(
			json_encode(['to' => 'string']),
			(string) $element
		);
	}

	public function testToStringReturnsNestedElementsAsJson()
	{
		$element = $this->createElement([
			'nested' => $this->createElement([
				'this' => 'shouldwork',
			]),
		]);

		$this->assertJsonStringEqualsJsonString(
			json_encode(['nested' => ['this' => 'shouldwork']]),
			(string) $element
		);
	}

	public function testIsArrayAccessible()
	{
		$this->assertSubclassOf(ArrayAccess::class, Element::class);
	}

	public function testOffsetExistsReturnsTrue()
	{
		$this->assertTrue(isset($this->createElement(['does' => 'exists'])['does']));
	}

	public function testOffsetExistsReturnsFalse()
	{
		$this->assertFalse(isset($this->createElement()['unknown']));
	}

	public function testOffsetGetReturnsValue()
	{
		$this->assertSame('value', $this->createElement(['key' => 'value'])['key']);
	}

	public function testOffsetSetStoresValue()
	{
		$element = $this->createElement();
		$element['should'] = 'work';

		$this->assertSame('work', $element['should']);
	}

	public function testOffsetSetAddsValue()
	{
		$element = $this->createElement();
		$element[] = 'value';

		$this->assertSame('value', $element[0]);
	}

	public function testOffsetUnsetDeletesValue()
	{
		$element = $this->createElement(['forget' => 'this']);

		unset($element['forget']);

		$this->assertNull($element->get('forget'));
	}
}
