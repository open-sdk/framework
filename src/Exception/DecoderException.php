<?php

namespace OpenSdk\Framework\Exception;

use Throwable;
use OpenSdk\Framework\Resource\DecoderInterface as ResourceDecoder;
use OpenSdk\Framework\Resource\Factory as ResourceFactory;

class DecoderException extends ResourceException
{
	/**
	 * The decoder which caused this error.
	 *
	 * @var Decoder
	 */
	private $decoder;

	/**
	 * Create an error for issues during response body decoding.
	 */
	public function __construct(
		string $message,
		ResourceDecoder $decoder,
		ResourceFactory $factory,
		Throwable $previous = null
	) {
		parent::__construct($message, $factory, $previous);

		$this->decoder = $decoder;
	}

	/**
	 * Get the decoder which caused this error.
	 */
	public function getDecoder(): ResourceDecoder
	{
		return $this->decoder;
	}
}
