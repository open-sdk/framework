<?php

namespace OpenSdk\Middleware;

use OpenSdk\Client\ClientAware;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

interface Stack extends ClientAware
{
	/**
	 * Add a new middleware or callable instance to the stack of middleware.
	 *
	 * Note, a newly added middleware **MUST** be prepended instead of appended
	 * to keep the executing middleware in the correct order.
	 *
	 * @param Middleware|(ClientAware&Middleware) $middleware
	 */
	public function push($middleware);

	/**
	 * Dispatch the request through all middlewares and return the response.
	 *
	 * The stack itself is responsible for sending the request, using the
	 * client. Also, an empty response is provided to allow early exiting.
	 *
	 * @param Request  $request
	 * @param Response $response
	 *
	 * @return Response
	 */
	public function __invoke(Request $request, Response $response): Response;
}
