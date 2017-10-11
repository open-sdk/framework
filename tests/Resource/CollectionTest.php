<?php

namespace OpenSdk\Framework\Tests\Resource;

use OpenSdk\Framework\Resource\Collection;
use OpenSdk\Framework\Tests\TestCase;

class CollectionTest extends TestCase
{
	public function testToArrayReturnsItems()
	{
		$items = [1, 2, 3];
		$collection = new Collection($items);

		$this->assertSame($items, $collection->toArray());
	}

	public function testToJsonAndToStringReturnsItemsAsJson()
	{
		$items = ['a', 'b', 'c'];
		$collection = new Collection($items);
		$json = json_encode($items);

		$this->assertSame($json, $collection->toJson());
		$this->assertSame($json, (string) $collection);
	}

	public function testCollectionIsArrayAccessible()
	{
		$collection = new Collection(['a', 'b']);
		$collection[2] = 'c';
		$collection[] = 'd';

		$this->assertArrayHasKey(0, $collection);
		$this->assertNotEmpty($collection[1]);

		unset($collection[3]);

		$this->assertSame(3, count($collection));
	}

	public function testCollectionIsCountable()
	{
		$collection = new Collection([1, 2, 3]);

		$this->assertSame(3, count($collection));
	}

	public function testCollectionIsIteratable()
	{
		$collection = new Collection([1, 2, 3]);

		foreach ($collection as $item) {
			$this->assertInternalType('integer', $item);
		}
	}

	public function testMapReturnsNewCollectionWithMappedItems()
	{
		$first = new Collection([1, 2]);
		$second = $first->map(function ($value) {
			return $value + 1;
		});

		$this->assertNotSame($first, $second);
		$this->assertInstanceOf(Collection::class, $second);
		$this->assertArraySubset([2, 3], $second->toArray());
	}

	public function testEarchReturnsSameCollectionAndIteratesItems()
	{
		$called = false;
		$first = new Collection([1, 2]);
		$second = $first->each(function ($value) use (&$called) {
			$called = true;

			return false;
		});

		$this->assertTrue($called);
		$this->assertSame($first, $second);
	}
}
