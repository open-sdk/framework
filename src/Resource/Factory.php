<?php

namespace OpenSdk\Framework\Resource;

use OpenSdk\Framework\Client\ClientAwareInterface;
use OpenSdk\Framework\Client\ClientAwareTrait;
use OpenSdk\Framework\Exception\ResourceException;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class Factory implements ClientAwareInterface
{
	use ClientAwareTrait;

	/**
	 * Executed request for the received response.
	 *
	 * @var Request
	 */
	private $request;

	/**
	 * Received response for the executed request.
	 *
	 * @var Response
	 */
	private $response;

	/**
	 * Create a new resource factory for the executed request and the received response.
	 */
	public function __construct(Request $request, Response $response)
	{
		$this->request = $request;
		$this->response = $response;
	}

	/**
	 * Get the request which resulted in the received response.
	 */
	public function getRequest(): Request
	{
		return $this->request;
	}

	/**
	 * Get the received response for the executed request.
	 */
	public function getResponse(): Response
	{
		return $this->response;
	}

	/**
	 * Get the received response's body as simple PHP array.
	 */
	public function asArray(): array
	{
		$decoder = $this->getClient()->getResourceDecoder();

		return $decoder->toArray($this);
	}

	/**
	 * Get the received response's body as resource model, with an optional custom resource type.
	 */
	public function asResource(string $resourceType = Resource::class): Resource
	{
		if (is_a($resourceType, Resource::class, true)) {
			return new $resourceType($this->asArray());
		}

		throw new ResourceException("Class type '{$resourceType}' is not a resource class.", $this);
	}

	/**
	 * Get the received response's body as resource collection, with an optional custom resource type.
	 */
	public function asCollection(string $resourceType = Resource::class): Collection
	{
		if (is_a($resourceType, Resource::class, true)) {
			$collection = new Collection($this->asArray());

			return $collection->map(function ($item) use ($resourceType) {
				return new $resourceType($item);
			});
		}

		throw new ResourceException("Class type '{$resourceType}' is not a resource class.", $this);
	}
}
