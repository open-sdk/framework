<?php

namespace OpenSdk\Resource\Decoder;

use OpenSdk\Exception\DecoderException;
use OpenSdk\Resource\Decoder;
use Psr\Http\Message\ResponseInterface as Response;

class Json implements Decoder
{
	/**
	 * {@inheritdoc}
	 */
	public function decode(Response $response): array
	{
		$data = @json_decode($response->getBody()->getContents(), true);

		if (json_last_error() === JSON_ERROR_NONE) {
			return $data;
		}

		throw new DecoderException(json_last_error_msg());
	}
}
