<?php

namespace OpenSdk\Resource;

use OpenSdk\Resource\Decoder\Json as JsonDecoder;
use OpenSdk\Resource\Object\Model;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ManagerFactory
{
	/**
	 * The shared response decoder.
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
	 * Create a new resource manager factory.
	 *
	 * @param Decoder|null $decoder
	 * @param string|null  $modelType
	 * @param string|null  $unwrap
	 */
	public function __construct(
		Decoder $decoder = null,
		string $modelType = null,
		$unwrap = null
	) {
		$this->unwrap = $unwrap;
		$this->decoder = $decoder ?: new JsonDecoder;

		$this->setModelType($modelType ?: Model::class);
	}

	/**
	 * Set the shared response decoder for all resource managers.
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
	 * Get the shared response decoder for all resource managers.
	 *
	 * @return Decoder
	 */
	public function getDecoder(): Decoder
	{
		return $this->decoder;
	}

	/**
	 * Set the default model type for all resource managers.
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
	 * Get the default model type for all resource managers.
	 *
	 * @return string
	 */
	public function getModelType(): string
	{
		return $this->modelType;
	}

	/**
	 * Set the default data unwrap path for all resource managers.
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
	 * Get the default response data unwrap path for all resource managers.
	 *
	 * @return string|null
	 */
	public function getUnwrap()
	{
		return $this->unwrap;
	}

	/**
	 * Create a new resource manager for the request and response pair.
	 * This also sets the decoder, model type and unwrap path to the new manager.
	 *
	 * @param Request  $request
	 * @param Response $response
	 *
	 * @return Manager
	 */
	public function createManager(Request $request, Response $response): Manager
	{
		return new Manager(
			$request,
			$response,
			$this->getDecoder(),
			$this->getModelType(),
			$this->getUnwrap()
		);
	}
}
