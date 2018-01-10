<?php

namespace OpenSdk\Resource\Object;

class Collection extends Element implements \Countable, \IteratorAggregate
{
	/**
	 * Count all items within the resource collection.
	 *
	 * @return integer
	 */
	public function count(): int
	{
		return count($this->data);
	}

	/**
	 * Get an iterator for this resource collection, allowing usage in `foreach` statements.
	 *
	 * @return \Traversable
	 */
	public function getIterator(): \Traversable
	{
		return new \ArrayIterator($this->data);
	}

	/**
	 * Append a value to this resource collection.
	 *
	 * @param mixed $value
	 *
	 * @return $this
	 */
	public function add($value): self
	{
		$this->data[] = $value;

		return $this;
	}

	/**
	 * Get all items from this resource collection.
	 *
	 * @return array
	 */
	public function all(): array
	{
		return $this->data;
	}

	/**
	 * Map over each item in this resource collection and return the result in a new instance.
	 *
	 * @param callable $callback
	 *
	 * @return static
	 */
	public function map(callable $callback): self
	{
		return new static(array_map($callback, $this->data, array_keys($this->data)));
	}

	/**
	 * Iterate over each item in this resource collection.
	 * Note, when the callback returns false the iteration will stop.
	 *
	 * @param callable $callback
	 *
	 * @return $this
	 */
	public function each(callable $callback): self
	{
		foreach ($this->data as $key => $value) {
			if ($callback($value, $key) === false) {
				break;
			}
		}

		return $this;
	}

	/**
	 * Map over each item in this resource collection and cast it to the provided class type.
	 *
	 * @param string $type
	 *
	 * @return static
	 */
	public function cast(string $type): self
	{
		return $this->map(function ($item) use ($type) {
			return new $type($item);
		});
	}
}
