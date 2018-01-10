<?php

namespace OpenSdk\Exception;

use Psr\Http\Message\ResponseInterface as Response;

class ResponseException extends \RuntimeException implements SdkException
{
	/**
	 * The response which caused this error.
	 *
	 * @var Response
	 */
	private $response;

	/**
	 * Create an error for issues after receiving a response.
	 *
	 * @param Response   $response
	 * @param string     $message
	 * @param integer    $code
	 * @param \Throwable $previous
	 */
	public function __construct(Response $response, string $message = '', int $code = 0, \Throwable $previous = null)
	{
		parent::__construct($message, $code, $previous);

		$this->response = $response;
	}

	/**
	 * Get the response which caused this error.
	 *
	 * @return Response
	 */
	public function getResponse(): Response
	{
		return $this->response;
	}
}
