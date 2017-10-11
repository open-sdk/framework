<?php

namespace OpenSdk\Framework\Resource;

use OpenSdk\Framework\Exception\DecoderException;

interface DecoderInterface
{
	/**
	 * Decode the response of the resource factory to a PHP array.
	 *
	 * @throws DecoderException
	 *
	 * @param Factory $factory
	 *
	 * @return array
	 */
	public function toArray(Factory $factory): array;
}
