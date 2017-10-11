<?php

namespace OpenSdk\Framework\Exception;

use Throwable;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ResponseException extends RequestException
{
    /**
     * The response which caused this error.
     *
     * @var Response
     */
    private $response;

    /**
     * Create an error for issues after receiving a response.
     */
    public function __construct(
		string $message,
		Request $request,
		Response $response,
		Throwable $previous = null
	) {
        parent::__construct($message, $request, $response->getStatusCode(), $previous);

        $this->response = $response;
    }

    /**
     * Get the response which caused this error.
     */
    public function getResponse(): Response
    {
        return $this->response;
    }
}
