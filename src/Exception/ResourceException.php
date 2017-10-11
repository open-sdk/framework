<?php

namespace OpenSdk\Framework\Exception;

use Throwable;
use OpenSdk\Framework\Resource\Factory as ResourceFactory;

class ResourceException extends ResponseException
{
	/**
	 * The resource factory which caused this error.
	 *
	 * @var ResourceFactory
	 */
	private $factory;

	/**
	 * Create an error for issues during resource usage.
	 */
	public function __construct(
		string $message,
		ResourceFactory $factory,
		Throwable $previous = null
	) {
		$request = $factory->getRequest();
		$response = $factory->getResponse();

		parent::__construct($message, $request, $response, $previous);

		$this->factory = $factory;
	}

	/**
	 * Get the resource factory which caused the error.
	 */
	public function getFactory(): ResourceFactory
	{
		return $this->factory;
	}
}
