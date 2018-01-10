<?php

namespace OpenSdk\Resource;

use OpenSdk\Resource\Decoder\Json;
use OpenSdk\Resource\Object\Collection;
use OpenSdk\Resource\Object\Model;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class Manager
{
	/**
	 * The request used for the response.
	 *
	 * @var Request
	 */
	private $request;

	/**
	 * The response received for the request.
	 *
	 * @var Response
	 */
	private $response;

	/**
	 * The response decoder.
	 *
	 * @var Decoder
	 */
	private $decoder;

	/**
	 * The default resource model type.
	 *
	 * @var string
	 */
	private $modelType;

	/**
	 * An optional data path for unwrapping.
	 *
	 * @var string|null
	 */
	private $unwrap;

	/**
	 * Create a new resource manager.
	 *
	 * @param Request      $request
	 * @param Response     $response
	 * @param Decoder|null $decoder
	 * @param string|null  $modelType
	 * @param string|null  $unwrap
	 */
	public function __construct(
		Request $request,
		Response $response,
		Decoder $decoder = null,
		string $modelType = null,
		$unwrap = null
	) {
		$this->request = $request;
		$this->response = $response;
		$this->unwrap = $unwrap;
		$this->decoder = $decoder ?: new Json;

		$this->setModelType($modelType ?: Model::class);
	}

	/**
	 * Get the request which resulted in the response.
	 *
	 * @return Request
	 */
	public function getRequest(): Request
	{
		return $this->request;
	}

	/**
	 * Get the response received for the request.
	 *
	 * @return Response
	 */
	public function getResponse(): Response
	{
		return $this->response;
	}

	/**
	 * Set the response decoder for content parsing.
	 *
	 * @param Decoder $decoder
	 *
	 * @return $this
	 */
	public function setDecoder(Decoder $decoder): self
	{
		$this->decoder = $decoder;

		return $this;
	}

	/**
	 * Get the response decoder for content parsing.
	 *
	 * @return Decoder
	 */
	public function getDecoder(): Decoder
	{
		return $this->decoder;
	}

	/**
	 * Set the default model type for resource casting.
	 *
	 * @param string $type
	 *
	 * @return $this
	 */
	public function setModelType(string $type): self
	{
		$this->modelType = Model::validate($type);

		return $this;
	}

	/**
	 * Get the default model type for resource casting.
	 *
	 * @return string
	 */
	public function getModelType(): string
	{
		return $this->modelType;
	}

	/**
	 * Set the data path used for unwrapping response data.
	 * Can also be set to null to remove unwrapping.
	 *
	 * @param string|null $unwrap
	 *
	 * @return $this
	 */
	public function setUnwrap($unwrap): self
	{
		$this->unwrap = $unwrap;

		return $this;
	}

	/**
	 * Get the data path used for unwrapping response data.
	 *
	 * @return string|null
	 */
	public function getUnwrap()
	{
		return $this->unwrap;
	}

	/**
	 * Get the response body as an array and unwrap it if possible.
	 *
	 * @return array|null
	 */
	public function asArray()
	{
		$data = $this->decoder->decode($this->response);

		if ($this->unwrap) {
			return $data[$this->unwrap] ?? $data;
		}

		return $data;
	}

	/**
	 * Get the response body as a model with the default or provided class type.
	 *
	 * @param string|null $type
	 *
	 * @return Model
	 */
	public function asModel(string $type = null): Model
	{
		$type = $type ? Model::validate($type) : $this->modelType;

		return new $type($this->asArray());
	}

	/**
	 * Get the response body as a model collection with the default or provided class type.
	 *
	 * @param string|null $type
	 *
	 * @return Collection
	 */
	public function asCollection(string $type = null): Collection
	{
		$type = $type ? Model::validate($type) : $this->modelType;

		return (new Collection($this->asArray()))->cast($type);
	}
}
