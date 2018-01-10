<?php

namespace OpenSdk\Client;

use Http\Client\HttpClient;
use Http\Message\MessageFactory as HttpFactory;
use OpenSdk\Middleware\Stack as MiddlewareStack;
use OpenSdk\Resource\ManagerFactory as ResourceManagerFactory;

abstract class Container
{
	/**
	 * A client who is responsible for transporting requests and responses.
	 *
	 * @var HttpClient
	 */
	private $httpClient;

	/**
	 * Factory to make requests and responses, without an implementation.
	 *
	 * @var HttpFactory
	 */
	private $httpFactory;

	/**
	 * Stack that handles all customizations to requests and responses.
	 *
	 * @var MiddlewareStack
	 */
	private $middlewareStack;

	/**
	 * Resource manager factory to help with response data usage.
	 *
	 * @var ResourceManagerFactory
	 */
	private $resourceManagerFactory;

	/**
	 * Register a new instance for transporting requests and responses.
	 *
	 * @param HttpClient $client
	 */
	public function setHttpClient(HttpClient $client)
	{
		$this->httpClient = $client;
	}

	/**
	 * Get an instance to transport requests and responses.
	 *
	 * @return HttpClient
	 */
	public function getHttpClient(): HttpClient
	{
		return $this->httpClient;
	}

	/**
	 * Register a new instance for making requests and responses.
	 *
	 * @param HttpFactory $factory
	 */
	public function setHttpFactory(HttpFactory $factory)
	{
		$this->httpFactory = $factory;
	}

	/**
	 * Get an instance to make requests and responses.
	 *
	 * @return HttpFactory
	 */
	public function getHttpFactory(): HttpFactory
	{
		return $this->httpFactory;
	}

	/**
	 * Register a stack to handle all requests and responses customizations.
	 *
	 * @param MiddlewareStack $stack
	 */
	public function setMiddlewareStack(MiddlewareStack $stack)
	{
		$this->middlewareStack = $stack->setClient($this);
	}

	/**
	 * Get the stack to handle all requests and responses customizations.
	 *
	 * @return MiddlewareStack
	 */
	public function getMiddlewareStack(): MiddlewareStack
	{
		return $this->middlewareStack;
	}

	/**
	 * Get the resource manager factory to help with response data usage.
	 *
	 * @param ResourceManagerFactory $factory
	 */
	public function setResourceManagerFactory(ResourceManagerFactory $factory)
	{
		$this->resourceManagerFactory = $factory;
	}

	/**
	 * Set the resource manager factory to help with response data usage.
	 *
	 * @return ResourceManagerFactory
	 */
	public function getResourceManagerFactory(): ResourceManagerFactory
	{
		return $this->resourceManagerFactory;
	}
}
