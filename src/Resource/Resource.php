<?php

namespace OpenSdk\Framework\Resource;

class Resource extends Collection
{
	/**
	 * Get an attribute or property from the resource when set.
	 *
	 * @param mixed $key
	 * @param mixed $default
	 *
	 * @return mixed
	 */
	public function get($key, $default = null)
	{
		if (isset($this[$key])) {
			return $this[$key];
		}

		return $default;
	}

	/**
	 * Get an attribute or property of the resource using a magic getter.
	 *
	 * @param string $key
	 *
	 * @return mixed
	 */
	public function __get($key)
	{
		return $this->get($key);
	}
}
