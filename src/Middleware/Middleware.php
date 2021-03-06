<?php

namespace OpenSdk\Middleware;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

interface Middleware
{
	/**
	 * Handle the outgoing request and return the response as the outcome.
	 *
	 * @param Request  $request
	 * @param Response $response
	 * @param callable $next
	 *
	 * @return Response
	 */
	public function __invoke(Request $request, Response $response, callable $next): Response;
}
