<?php

namespace OpenSdk\Resource;

use OpenSdk\Exception\DecoderException;

interface Decoder
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
