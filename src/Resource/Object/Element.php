<?php

namespace OpenSdk\Resource\Object;

abstract class Element implements \ArrayAccess
{
	/**
	 * The actual data within this resource element.
	 *
	 * @var array
	 */
	protected $data;

	/**
	 * Create a new resource element instance with the provided data.
	 *
	 * @param array $data
	 */
	public function __construct(array $data = [])
	{
		$this->data = $data;
	}

	/**
	 * Get a value from this resource element, by key.
	 *
	 * @param string|integer $key
	 * @param mixed          $default
	 *
	 * @return mixed
	 */
	public function get($key, $default = null)
	{
		return $this->data[$key] ?? $default;
	}

	/**
	 * Set a value to this resource element, by key.
	 *
	 * @param string|integer $key
	 * @param mixed          $value
	 *
	 * @return $this
	 */
	public function set($key, $value): self
	{
		$this->data[$key] = $value;

		return $this;
	}

	/**
	 * Remove a key from this resource element.
	 *
	 * @param string|integer $key
	 *
	 * @return $this
	 */
	public function remove($key): self
	{
		unset($this->data[$key]);

		return $this;
	}

	/**
	 * Determine if a key is set in this resource element.
	 * Keep in mind that this only checks if a key exists, not if it's null or empty.
	 *
	 * @param string|integer $key
	 *
	 * @return boolean
	 */
	public function has($key): bool
	{
		return array_key_exists($key, $this->data);
	}

	/**
	 * Determine if this resource element is empty.
	 *
	 * @return boolean
	 */
	public function isEmpty(): bool
	{
		return empty($this->data);
	}

	/**
	 * Determine if this resource element is not empty.
	 *
	 * @return boolean
	 */
	public function isNotEmpty(): bool
	{
		return !$this->isEmpty();
	}

	/**
	 * Get this resource element as a plain PHP array.
	 *
	 * @return array
	 */
	public function asArray(): array
	{
		return array_map(
			function ($value) {
				return $value instanceof self
					? $value->asArray()
					: $value;
			},
			$this->data
		);
	}

	/**
	 * Get this resource element as a plain JSON string.
	 *
	 * @param integer $options
	 *
	 * @return string
	 */
	public function asJson(int $options = 0): string
	{
		return json_encode($this->asArray(), $options);
	}

	/**
	 * @see self::asJson()
	 *
	 * @return string
	 */
	public function __toString(): string
	{
		return $this->asJson();
	}

	/**
	 * Determine if a key exists in this resource element.
	 *
	 * @param mixed $key
	 *
	 * @return boolean
	 */
	public function offsetExists($key)
	{
		return array_key_exists($key, $this->data);
	}

	/**
	 * Get a value from this resource element, by key.
	 *
	 * @param mixed $key
	 *
	 * @return mixed
	 */
	public function offsetGet($key)
	{
		return $this->data[$key];
	}

	/**
	 * Set a value to this resource element, by key.
	 * The value is appended instead if the key is null.
	 *
	 * @param mixed $key
	 * @param mixed $value
	 */
	public function offsetSet($key, $value)
	{
		if (is_null($key)) {
			$this->data[] = $value;
		} else {
			$this->data[$key] = $value;
		}
	}

	/**
	 * Remove a key from this resource element.
	 *
	 * @param mixed $key
	 */
	public function offsetUnset($key)
	{
		unset($this->data[$key]);
	}
}
