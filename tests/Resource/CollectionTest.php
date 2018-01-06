<?php

namespace OpenSdk\Tests\Resource;

use OpenSdk\Resource\Collection;
use OpenSdk\Tests\TestCase;

class CollectionTest extends TestCase
{
	public function testToArrayReturnsItems()
	{
		$items = [1, 2, 3];
		$collection = new Collection($items);

		$this->assertSame($items, $collection->toArray());
	}

	public function testToArrayTransformsNestedToArray()
	{
		$nestedItems = new Collection([1, 2]);
		$items = new Collection(['a', $nestedItems]);
		$expected = [
			'a',
			[1, 2],
		];

		$this->assertArraySubset($expected, $items->toArray());
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

		$this->assertCount(3, $collection);
	}

	public function testCollectionIsCountable()
	{
		$collection = new Collection([1, 2, 3]);

		$this->assertCount(3, $collection);
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

	public function testEarchReturnsSameCollectionAndIteratesItemsAndBreaksLoop()
	{
		$reachedTwo = false;
		$reachedThree = false;
		$first = new Collection([1, 2, 3]);
		$second = $first->each(function ($value) use (&$reachedTwo, &$reachedThree) {
			if ($value == 2) {
				$reachedTwo = true;

				return false;
			}

			if ($value == 3) {
				$reachedThree = true;
			}
		});

		$this->assertTrue($reachedTwo);
		$this->assertFalse($reachedThree);
		$this->assertSame($first, $second);
	}
}
