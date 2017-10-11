<?php

namespace OpenSdk\Framework\Tests\Client;

use OpenSdk\Framework\Client\Client;
use OpenSdk\Framework\Client\ClientAwareTrait;
use OpenSdk\Framework\Tests\TestCase;

class ClientAwareTraitTest extends TestCase
{
	public function testClientIsStored()
	{
		$client = $this->createMock(Client::class);
		$aware = $this->getMockForTrait(ClientAwareTrait::class);

		$this->assertSame($aware, $aware->setClient($client));
		$this->assertSame($client, $aware->getClient());
	}
}
