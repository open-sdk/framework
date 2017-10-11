<?php

namespace OpenSdk\Framework\Client;

use OpenSdk\Framework\Middleware\MiddlewareInterface;
use OpenSdk\Framework\Resource\Factory as ResourceFactory;
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
		$this->setMiddlewareStack(new \OpenSdk\Framework\Middleware\RelayStack);
		$this->setResourceDecoder(new \OpenSdk\Framework\Resource\Decoder\JsonDecoder);
	}

	/**
	 * Add a new middleware to the stack.
	 *
	 * @param MiddlewareInterface|callable $middleware
	 */
	public function use($middleware): void
	{
		$this->getMiddlewareStack()->push($middleware);
	}

	/**
	 * Fetch the response using a prepared request and the middleware stack.
	 *
	 * @param  Request $request
	 * @return Response
	 */
	public function send(Request $request)
	{
		$factory = $this->getHttpFactory();
		$stack = $this->getMiddlewareStack();
		$response = $stack($request, $factory->createResponse());

		return (new ResourceFactory($request, $response))->setClient($this);
	}
}
