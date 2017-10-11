<?php

namespace OpenSdk\Framework\Middleware;

use OpenSdk\Framework\Client\ClientAwareInterface;
use OpenSdk\Framework\Client\ClientAwareTrait;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Relay\Runner as RelayRunner;

class RelayStack implements StackInterface
{
	use ClientAwareTrait {
		setClient as setClientTrait;
	}

	/**
	 * All registered middlewares of this stack.
	 *
	 * @var array
	 */
	private $stack = [];

	/**
	 * Create a new Relay PHP middleware instance, for usage in Open SDK.
	 */
	public function __construct()
	{
		$this->push(new SendRequestMiddleware);
	}

	/**
	 * @inheritdoc
	 */
	public function setClient($client)
	{
		$this->setClientTrait($client);

		$this->stack = array_map(
			function ($middleware) use ($client) {
				if ($middleware instanceof ClientAwareInterface) {
					return $middleware->setClient($client);
				}

				return $middleware;
			},
			$this->stack
		);

		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function push($middleware): void
	{
		$client = $this->getClient();

		if ($client && $middleware instanceof ClientAwareInterface) {
			$middleware = $middleware->setClient($client);
		}

		array_unshift($this->stack, $middleware);
	}

	/**
	 * @inheritdoc
	 */
	public function __invoke(Request $request, Response $response): Response
	{
		$runner = new RelayRunner($this->stack);

		return $runner($request, $response);
	}
}
