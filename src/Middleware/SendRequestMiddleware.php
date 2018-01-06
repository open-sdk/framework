<?php

namespace OpenSdk\Middleware;

use OpenSdk\Client\ClientAware;
use OpenSdk\Client\ClientAwareTrait;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class SendRequestMiddleware implements Middleware, ClientAware
{
	use ClientAwareTrait;

	/**
	 * Fetch the HTTP client from the SDK and use it to send the request.
	 *
	 * @param Request  $request
	 * @param Response $response
	 * @param callable $next
	 *
	 * @return Response
	 */
	public function __invoke(Request $request, Response $response, callable $next): Response
	{
		$http = $this->getClient()->getHttpClient();

		return $next($request, $http->sendRequest($request));
	}
}
