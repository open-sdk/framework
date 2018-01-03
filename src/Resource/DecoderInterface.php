<?php

namespace OpenSdk\Framework\Resource;

use OpenSdk\Framework\Exception\DecoderException;

interface DecoderInterface
{
	/**
	 * Decode the response of the resource factory to a PHP array.
	 *
	 * @param Factory $factory
	 *
	 * @throws DecoderException
	 *
	 * @return array
	 */
	public function toArray(Factory $factory): array;
}
