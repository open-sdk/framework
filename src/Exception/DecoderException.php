<?php

namespace OpenSdk\Exception;

use OpenSdk\Resource\Decoder;
use Throwable;

class DecoderException extends \RuntimeException implements SdkException
{
	/**
	 * The decoder which caused this error.
	 *
	 * @var Decoder
	 */
	private $decoder;

	/**
	 * Create an error for issues during response body decoding.
	 *
	 * @param Decoder   $decoder
	 * @param string    $message
	 * @param integer   $code
	 * @param Throwable $previous
	 */
	public function __construct(Decoder $decoder, string $message = '', int $code = 0, Throwable $previous = null)
	{
		parent::__construct($message, $code, $previous);

		$this->decoder = $decoder;
	}

	/**
	 * Get the decoder which caused this error.
	 *
	 * @return Decoder
	 */
	public function getDecoder(): Decoder
	{
		return $this->decoder;
	}
}
