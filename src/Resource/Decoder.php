<?php

namespace OpenSdk\Resource;

use OpenSdk\Exception\DecoderException;
use Psr\Http\Message\ResponseInterface as Response;

interface Decoder
{
	/**
	 * Decode the body of the response to a PHP array.
	 *
	 * @param Response $response
	 *
	 * @return array
	 *
	 * @throws DecoderException
	 */
	public function decode(Response $response): array;
}
