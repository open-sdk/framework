<?php

namespace OpenSdk\Framework\Resource;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;

class Collection implements ArrayAccess, Countable, IteratorAggregate
{
    /**
     * All items within the collection.
     *
     * @var array
     */
    private $items;

    /**
     * Create a new collection using a dataset.
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * Map over each collection item and return a new collection instance.
     */
    public function map(callable $callback): self
    {
        return new static(array_map($callback, $this->items));
    }

    /**
     * Iterate over each collection item and return the same collection instance.
     * Note, when the callback returns false the loop will stop.
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
     * Get a PHP array representation of the resource.
     */
    public function toArray(): array
    {
        return $this->items;
    }

    /**
     * Get a JSON string representation of the resource.
     *
     * @param integer $options
     */
    public function toJson($options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }

    /**
     * @see self::toJson()
     */
    public function __toString(): string
    {
        return $this->toJson();
    }

    /**
     * @inheritdoc
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->items);
    }

    /**
     * @inheritdoc
     */
    public function offsetGet($offset)
    {
        return $this->items[$offset];
    }

    /**
     * @inheritdoc
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    /**
     * @inheritdoc
     */
    public function offsetUnset($offset)
    {
        unset($this->items[$offset]);
    }

    /**
     * @inheritdoc
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * @inheritdoc
     */
    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }
}
