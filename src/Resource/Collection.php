<?php

namespace OpenSdk\Framework\Resource;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;

class Collection implements ArrayAccess, Countable, IteratorAggregate
{
	/**
	 * All items within the resource.
	 *
	 * @var array
	 */
	protected $items;

	/**
	 * Create a new resource using a dataset.
	 *
	 * @param array $items
	 */
	public function __construct(array $items = [])
	{
		$this->items = $items;
	}

	/**
	 * Map over each resource items and return the result in a new instance.
	 *
	 * @param callable $callback
	 *
	 * @return static
	 */
	public function map(callable $callback): self
	{
		return new static(array_map($callback, $this->items, array_keys($this->items)));
	}

	/**
	 * Iterate over each resource item and return this instance.
	 * Note, when the callback returns false the loop will stop.
	 *
	 * @param callable $callback
	 *
	 * @return $this
	 */
	public function each(callable $callback): self
	{
		foreach ($this->items as $key => $value) {
			if ($callback($value, $key) === false) {
				break;
			}
		}

		return $this;
	}

	/**
	 * Get a plain PHP array representation of the resource.
	 *
	 * @return array
	 */
	public function toArray(): array
	{
		return array_map(
			function ($value) {
				return $value instanceof self
					? $value->toArray()
					: $value;
			},
			$this->items
		);
	}

	/**
	 * Get a JSON string representation of the resource.
	 *
	 * @param integer $options
	 *
	 * @return string
	 */
	public function toJson($options = 0): string
	{
		return json_encode($this->toArray(), $options);
	}

	/**
	 * @see self::toJson()
	 *
	 * @return string
	 */
	public function __toString(): string
	{
		return $this->toJson();
	}

	/**
	 * Determine if a key or property exists in this resource.
	 *
	 * @param mixed $key
	 *
	 * @return boolean
	 */
	public function offsetExists($key)
	{
		return array_key_exists($key, $this->items);
	}

	/**
	 * Get a key or property from the resource.
	 *
	 * @param mixed $key
	 *
	 * @return mixed
	 */
	public function offsetGet($key)
	{
		return $this->items[$key];
	}

	/**
	 * Set a value to this resource using a key, or append it.
	 *
	 * @param mixed $key
	 * @param mixed $value
	 */
	public function offsetSet($key, $value)
	{
		if (is_null($key)) {
			$this->items[] = $value;
		} else {
			$this->items[$key] = $value;
		}
	}

	/**
	 * Remove a key or property from this resource.
	 *
	 * @param mixed $offset
	 */
	public function offsetUnset($offset)
	{
		unset($this->items[$offset]);
	}

	/**
	 * Count all items within the resource.
	 *
	 * @return integer
	 */
	public function count()
	{
		return count($this->items);
	}

	/**
	 * Get an iterator for this resource, allowing usage with `foreach`.
	 *
	 * @return ArrayIterator
	 */
	public function getIterator()
	{
		return new ArrayIterator($this->items);
	}
}
