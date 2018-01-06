<?php

namespace OpenSdk\Middleware\Stack;

use OpenSdk\Client\ClientAware;
use OpenSdk\Client\ClientAwareTrait;
use OpenSdk\Middleware\SendRequestMiddleware;
use OpenSdk\Middleware\Stack;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Relay\Runner as RelayRunner;

class Relay implements Stack
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
	 * {@inheritdoc}
	 */
	public function setClient($client)
	{
		$this->setClientTrait($client);

		$this->stack = array_map(
			function ($middleware) use ($client) {
				if ($middleware instanceof ClientAware) {
					return $middleware->setClient($client);
				}

				return $middleware;
			},
			$this->stack
		);

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function push($middleware)
	{
		$client = $this->getClient();

		if ($client && $middleware instanceof ClientAware) {
			$middleware = $middleware->setClient($client);
		}

		array_unshift($this->stack, $middleware);
	}

	/**
	 * {@inheritdoc}
	 */
	public function __invoke(Request $request, Response $response): Response
	{
		$runner = new RelayRunner($this->stack);

		return $runner($request, $response);
	}
}
