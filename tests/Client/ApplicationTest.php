<?php

namespace OpenSdk\Tests\Client;

use OpenSdk\Client\Application;
use OpenSdk\Tests\TestCase;

class ApplicationTest extends TestCase
{
	public function testIdIsStored()
	{
		$this->assertSame('awesomeid', (new Application('awesomeid'))->getId());
	}

	public function testIdAndSecretAreStored()
	{
		$app = new Application('awesomeid', 'awesomesecret');

		$this->assertSame('awesomeid', $app->getId());
		$this->assertSame('awesomesecret', $app->getSecret());
	}

	public function testSecretIsNullByDefault()
	{
		$this->assertNull((new Application('awesomeid'))->getSecret());
	}
}
