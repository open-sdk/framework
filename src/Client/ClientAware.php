<?php

namespace OpenSdk\Client;

interface ClientAware
{
	/**
	 * Provide a reference to the SDK client instance.
	 *
	 * Implementing this allows the class to access all customizable components
	 * from the container. The implementing class must also return itself, or a
	 * new instance of itself, to use as the finalized instance.
	 *
	 * @param mixed $client
	 *
	 * @return static
	 */
	public function setClient($client);
}
