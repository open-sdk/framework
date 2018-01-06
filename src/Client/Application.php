<?php

namespace OpenSdk\Client;

class Application
{
	private $id;
	private $secret;

	public function __construct(string $id, string $secret = null)
	{
		$this->id = $id;
		$this->secret = $secret;
	}

	public function getId(): string
	{
		return $this->id;
	}

	public function getSecret()
	{
		return $this->secret;
	}
}
