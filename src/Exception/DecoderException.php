<?php

namespace OpenSdk\Framework\Exception;

use OpenSdk\Framework\Resource\DecoderInterface as ResourceDecoder;
use OpenSdk\Framework\Resource\Factory as ResourceFactory;
use Throwable;

class DecoderException extends ResourceException
{
	/**
	 * The decoder which caused this error.
	 *
	 * @var ResourceDecoder
	 */
	private $decoder;

	/**
	 * Create an error for issues during response body decoding.
	 *
	 * @param string          $message
	 * @param ResourceDecoder $decoder
	 * @param ResourceFactory $factory
	 * @param Throwable       $previous
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
	 *
	 * @return ResourceDecoder
	 */
	public function getDecoder(): ResourceDecoder
	{
		return $this->decoder;
	}
}
