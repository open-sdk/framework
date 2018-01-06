<?php

namespace OpenSdk\Exception;

use Psr\Http\Message\RequestInterface as Request;
use RuntimeException;
use Throwable;

class RequestException extends RuntimeException implements SdkException
{
	/**
	 * The request which caused this error.
	 *
	 * @var Request
	 */
	private $request;

	/**
	 * Create an error for issues after request creation, and before request creation.
	 *
	 * @param string    $message
	 * @param Request   $request
	 * @param integer   $code
	 * @param Throwable $previous
	 */
	public function __construct(
		string $message,
		Request $request,
		int $code = 0,
		Throwable $previous = null
	) {
		parent::__construct($message, $code, $previous);

		$this->request = $request;
	}

	/**
	 * Get the request which caused this error.
	 *
	 * @return Request
	 */
	public function getRequest(): Request
	{
		return $this->request;
	}
}
