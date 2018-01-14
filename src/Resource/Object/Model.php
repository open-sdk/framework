<?php

namespace OpenSdk\Resource\Object;

use OpenSdk\Exception\ResourceException;

class Model extends Element
{
	/**
	 * Get a string value from this resource model, by key.
	 *
	 * @param string|integer $key
	 * @param string         $default
	 *
	 * @return string|null
	 */
	public function getAsString($key, string $default = null)
	{
		if (is_null($value = $this->get($key))) {
			return $default;
		}

		return (string) $value;
	}

	/**
	 * Get a boolean value from this resource model, by key.
	 *
	 * @param string|integer $key
	 * @param boolean        $default
	 *
	 * @return boolean|null
	 */
	public function getAsBoolean($key, bool $default = null)
	{
		if (is_null($value = $this->get($key))) {
			return $default;
		}

		return (bool) filter_var($value, FILTER_VALIDATE_BOOLEAN);
	}

	/**
	 * Get an integer value from this resource model, by key.
	 *
	 * @param string|integer $key
	 * @param integer        $default
	 *
	 * @return integer|null
	 */
	public function getAsInteger($key, int $default = null)
	{
		if (is_null($value = $this->get($key))) {
			return $default;
		}

		return (int) $value;
	}

	/**
	 * Get a float value from this resource model, by key.
	 *
	 * @param string|integer $key
	 * @param float          $default
	 *
	 * @return float|null
	 */
	public function getAsFloat($key, float $default = null)
	{
		if (is_null($value = $this->get($key))) {
			return $default;
		}

		return (float) $value;
	}

	/**
	 * Get a value from this resource model which is wrapped in an instance, by key,
	 *
	 * @param string         $type
	 * @param string|integer $key
	 * @param mixed          $default
	 *
	 * @return mixed
	 */
	public function getAsInstance(string $type, $key, $default = null)
	{
		if (is_null($value = $this->get($key))) {
			return $default;
		}

		return new $type($value);
	}

	/**
	 * Validate the class type on being a subclass, or the exact type, of this model.
	 *
	 * @param string $type
	 *
	 * @return string
	 *
	 * @throws ResourceException
	 */
	public static function validate(string $type): string
	{
		$class = static::class;

		if (is_a($type, $class, true)) {
			return $type;
		}

		throw new ResourceException("Class '{$type}' is not a '{$class}'.");
	}
}
