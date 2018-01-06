<?php

namespace OpenSdk\Client;

use OpenSdk\Middleware\Middleware;
use OpenSdk\Resource\Factory as ResourceFactory;
use Psr\Http\Message\RequestInterface as Request;

abstract class Client extends Container
{
	/**
	 * The application information.
	 *
	 * @var Application
	 */
	private $application;

	/**
	 * Set the application's information.
	 *
	 * @param Application $application
	 */
	public function setApplication(Application $application)
	{
		$this->application = $application;
	}

	/**
	 * Get the application information, if set.
	 *
	 * @return Application|null
	 */
	public function getApplication()
	{
		return $this->application;
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
	 * @return ResourceFactory
	 */
	public function send(Request $request)
	{
		$factory = $this->getHttpFactory();
		$stack = $this->getMiddlewareStack();
		$response = $stack($request, $factory->createResponse());

		return (new ResourceFactory($request, $response))->setClient($this);
	}
}
