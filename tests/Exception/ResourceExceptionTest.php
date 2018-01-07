<?php

namespace OpenSdk\Tests\Exception;

use OpenSdk\Exception\ResourceException;
use OpenSdk\Exception\SdkException;
use OpenSdk\Tests\ExceptionTestCase;

class ResourceExceptionTest extends ExceptionTestCase
{
	public function testIsSdkException()
	{
		$this->assertSubclassOf(SdkException::class, ResourceException::class);
	}

	public function testExceptionStoresFactory()
	{
		$factory = $this->mockResourceFactory();
		$error = new ResourceException($factory);

		$this->assertSame($factory, $error->getFactory());
	}
}
