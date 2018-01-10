<?php

namespace OpenSdk\Client;

use OpenSdk\Middleware\Middleware;
use OpenSdk\Resource\Manager as ResourceManager;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\RequestInterface as Response;

abstract class Client extends Container
{
	/**
	 * Create a new client with the default implementations.
	 */
	public function __construct()
	{
		$this->setHttpClient(new \Http\Adapter\Guzzle6\Client);
		$this->setHttpFactory(new \Http\Message\MessageFactory\GuzzleMessageFactory);
		$this->setMiddlewareStack(new \OpenSdk\Middleware\Stack\Relay);
		$this->setResourceManagerFactory(new \OpenSdk\Resource\ManagerFactory);
	}

	/**
	 * Add a new middleware to the stack.
	 *
	 * @param Middleware|callable $middleware
	 */
	public function use($middleware)
	{
		$this->getMiddlewareStack()->push($middleware);
	}

	/**
	 * Fetch the response using a prepared request and the middleware stack.
	 *
	 * @param Request $request
	 *
	 * @return ResourceManager
	 */
	public function send(Request $request)
	{
		$stack = $this->getMiddlewareStack();
		$resource = $this->getResourceManagerFactory();
		$response = $this->getHttpFactory()->createResponse();

		return $resource->createManager($request, $stack($request, $response));
	}
}
