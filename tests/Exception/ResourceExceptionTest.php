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
}
