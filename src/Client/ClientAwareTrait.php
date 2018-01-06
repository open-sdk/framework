<?php

namespace OpenSdk\Client;

trait ClientAwareTrait
{
	/**
	 * The SDK instance this object is made aware of.
	 *
	 * @var mixed
	 */
	private $client;

	/**
	 * {@inheritdoc}
	 */
	public function setClient($client)
	{
		$this->client = $client;

		return $this;
	}

	/**
	 * Get the SDK instance this object is aware of.
	 *
	 * @return mixed
	 */
	public function getClient()
	{
		return $this->client;
	}
}
