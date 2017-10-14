<?php

namespace OpenSdk\Framework\Resource;

class Model extends Collection
{
	/**
	 * A map of all resource attributes and their casting type.
	 *
	 * @var array
	 */
	protected static $casts = [];

	/**
	 * Create a new resource instance with the dataset.
	 *
	 * @param array $items
	 */
	public function __construct(array $items = [])
	{
		parent::__construct();

		foreach ($items as $key => $value) {
			$this->set($key, $value);
		}
	}

	/**
	 * Get the desired typecasting for the attribute name.
	 *
	 * @param string $key
	 *
	 * @return mixed
	 */
	protected function getCastType($key)
	{
		return static::$casts[$key] ?? null;
	}

	/**
	 * Typecast the attribute and return its final value.
	 *
	 * @param string $key
	 * @param mixed  $value
	 *
	 * @return mixed
	 */
	protected function cast($key, $value)
	{
		$type = $this->getCastType($key);

		if (empty($type)) {
			return $value;
		}

		switch ($type) {
			case 'boolean':
				return filter_var($value, FILTER_VALIDATE_BOOLEAN);

			case 'integer':
				return (int) $value;

			case 'float':
				return (float) $value;

			case 'string':
				return (string) $value;

			default:
				if (class_exists($type)) {
					return new $type($value);
				}

				if (is_callable($type)) {
					return $type($value);
				}

				return $value;
		}
	}

	/**
	 * Get an attribute from the resource.
	 *
	 * @param string $key
	 * @param mixed $default
	 *
	 * @return mixed
	 */
	public function get($key, $default = null)
	{
		if (isset($this->items[$key])) {
			return $this->items[$key];
		}

		return $default;
	}

	/**
	 * Set an attribute to the resource.
	 *
	 * @param string $key
	 * @param mixed $value
	 *
	 * @return $this
	 */
	public function set($key, $value): self
	{
		$this->items[$key] = $this->cast($key, $value);

		return $this;
	}

	/**
	 * Get an attribute from the resource using a magic getter.
	 *
	 * @param string $key
	 *
	 * @return mixed
	 */
	public function __get($key)
	{
		return $this->get($key);
	}

	/**
	 * Set an attribute to the resource, using a magic setter.
	 *
	 * @param string $key
	 * @param mixed  $value
	 */
	public function __set($key, $value)
	{
		$this->set($key, $value);
	}
}
