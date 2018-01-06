<?php

namespace OpenSdk\Tests\Client;

use OpenSdk\Client\Client;
use OpenSdk\Client\ClientAwareTrait;
use OpenSdk\Tests\TestCase;
use PHPUnit\Framework\MockObject\MockObject as PHPUnitMock;

class ClientAwareTraitTest extends TestCase
{
	public function testClientIsStored()
	{
		/** @var PHPUnitMock&ClientAwareTrait */
		$aware = $this->getMockForTrait(ClientAwareTrait::class);
		$client = $this->createMock(Client::class);

		$this->assertSame($aware, $aware->setClient($client));
		$this->assertSame($client, $aware->getClient());
	}
}
