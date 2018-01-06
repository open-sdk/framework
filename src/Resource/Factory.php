<?php

namespace OpenSdk\Resource;

use OpenSdk\Client\ClientAware;
use OpenSdk\Client\ClientAwareTrait;
use OpenSdk\Exception\ResourceException;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class Factory implements ClientAware
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
	 *
	 * @param Request  $request
	 * @param Response $response
	 */
	public function __construct(Request $request, Response $response)
	{
		$this->request = $request;
		$this->response = $response;
	}

	/**
	 * Get the request which resulted in the received response.
	 *
	 * @return Request
	 */
	public function getRequest(): Request
	{
		return $this->request;
	}

	/**
	 * Get the received response for the executed request.
	 *
	 * @return Response
	 */
	public function getResponse(): Response
	{
		return $this->response;
	}

	/**
	 * Get the received response's body as simple PHP array.
	 *
	 * @return array
	 */
	public function asArray(): array
	{
		$decoder = $this->getClient()->getResourceDecoder();

		return $decoder->toArray($this);
	}

	/**
	 * Get the received response's body as resource model, with an optional custom model type.
	 *
	 * @param string $type
	 *
	 * @throws ResourceException
	 *
	 * @return Model
	 */
	public function asModel(string $type = Model::class): Model
	{
		if (is_a($type, Model::class, true)) {
			return new $type($this->asArray());
		}

		throw new ResourceException("Class type '{$type}' is not a resource model.", $this);
	}

	/**
	 * Get the received response's body as resource collection, with an optional custom model type.
	 *
	 * @param string $type
	 *
	 * @throws ResourceException
	 *
	 * @return Collection
	 */
	public function asCollection(string $type = Model::class): Collection
	{
		if (is_a($type, Model::class, true)) {
			$collection = new Collection($this->asArray());

			return $collection->map(function ($item) use ($type) {
				return new $type($item);
			});
		}

		throw new ResourceException("Class type '{$type}' is not a resource model.", $this);
	}
}
