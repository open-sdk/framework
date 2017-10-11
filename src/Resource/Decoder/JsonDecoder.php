<?php

namespace OpenSdk\Framework\Resource\Decoder;

use OpenSdk\Framework\Exception\DecoderException;
use OpenSdk\Framework\Resource\DecoderInterface;
use OpenSdk\Framework\Resource\Factory;

class JsonDecoder implements DecoderInterface
{
	/**
	 * @inheritdoc
	 */
	public function toArray(Factory $factory): array
	{
		$data = json_decode($factory->getResponse()->getBody()->getContents(), true);

		if (json_last_error() !== JSON_ERROR_NONE) {
			throw new DecoderException(json_last_error_msg(), $this, $factory);
		}

		return $data;
	}
}
