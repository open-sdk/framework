<?php

namespace OpenSdk\Tests\Resource\Object;

use OpenSdk\Resource\Object\Collection;
use OpenSdk\Resource\Object\Element;
use OpenSdk\Tests\ResourceObjectTestCase;

class CollectionTest extends ResourceObjectTestCase
{
	public function testIsElementObject()
	{
		$this->assertSubclassOf(Element::class, Collection::class);
	}

	public function testIsCountable()
	{
		$this->assertSubclassOf(\Countable::class, Collection::class);
	}

	public function testIsIteratorAggregate()
	{
		$this->assertSubclassOf(\IteratorAggregate::class, Collection::class);
	}

	public function testCountReturnsTotalItemsAmount()
	{
		$this->assertCount(3, new Collection(['a', 'b', 'c']));
	}

	public function testCanBeIteratedWithForEach()
	{
		foreach (new Collection(['a']) as $key => $value) {
			$this->assertSame(0, $key);
			$this->assertSame('a', $value);
		}
	}

	public function testAddAppendsValue()
	{
		$this->assertSame('a', (new Collection)->add('a')->get(0));
	}

	public function testAllReturnsExactData()
	{
		$data = ['a', 'b', 'c'];

		$this->assertSame($data, (new Collection($data))->all());
	}

	public function testMapReturnsNewInstance()
	{
		$pre = new Collection(['a', 'b', 'c']);
		$post = $pre->map(function ($value) {
			return $value;
		});

		$this->assertNotSame($pre, $post);
		$this->assertInstanceOf(Collection::class, $post);
	}

	public function testMapReturnsNewInstanceWithMappedData()
	{
		$pre = new Collection([1, 2, 3]);
		$post = $pre->map(function ($value) {
			return $value + 1;
		});

		$this->assertArraySubset([1, 2, 3], $pre->all());
		$this->assertArraySubset([2, 3, 4], $post->all());
	}

	public function testEachReturnsSameInstance()
	{
		$pre = new Collection(['a', 'b', 'c']);
		$post = $pre->each(function ($value) {
			return $value;
		});

		$this->assertSame($pre, $post);
	}

	public function testEachReturnsSameInstanceWithSameData()
	{
		$pre = new Collection([1, 2, 3]);
		$post = $pre->each(function ($value) {
			return $value + 1;
		});

		$this->assertArraySubset([1, 2, 3], $post->all());
	}

	public function testEachBreaksIterationWhenFalseIsReturned()
	{
		$collection = new Collection(['a', 'b', 'c']);
		$touched = ['a' => false, 'b' => false, 'c' => false];

		$collection->each(function ($value) use (&$touched) {
			$touched[$value] = true;

			switch ($value) {
				case 'a':
					return 0;

				case 'b':
					return false;

				case 'c':
					throw new \RuntimeException("Letter 'c' was reached.");
			}
		});

		$this->assertArraySubset(['a' => true, 'b' => true, 'c' => false], $touched);
	}

	public function testCastReturnsNewInstance()
	{
		$pre = new Collection(['1993-03-07T23:00:00+01:00']);
		$post = $pre->cast(\DateTime::class);

		$this->assertNotSame($pre, $post);
		$this->assertInstanceOf(Collection::class, $post);
	}

	public function testCastReturnsNewInstanceWithWrappedData()
	{
		$pre = new Collection(['1993-03-07T23:00:00+01:00']);
		$post = $pre->cast(\DateTime::class);

		$this->assertInstanceOf(\DateTime::class, $post->get(0));
		$this->assertSame(731541600, $post->get(0)->getTimestamp());
	}
}
