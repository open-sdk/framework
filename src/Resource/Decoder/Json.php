<?php

namespace OpenSdk\Resource\Decoder;

use OpenSdk\Exception\DecoderException;
use OpenSdk\Resource\Decoder;
use OpenSdk\Resource\Factory;

class Json implements Decoder
{
	/**
	 * {@inheritdoc}
	 */
	public function toArray(Factory $factory): array
	{
		$data = json_decode($factory->getResponse()->getBody()->getContents(), true);

		if (json_last_error() !== JSON_ERROR_NONE) {
			throw new DecoderException($this, json_last_error_msg());
		}

		return $data;
	}
}
