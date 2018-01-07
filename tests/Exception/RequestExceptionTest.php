<?php

namespace OpenSdk\Tests\Exception;

use OpenSdk\Exception\RequestException;
use OpenSdk\Exception\SdkException;
use OpenSdk\Tests\ExceptionTestCase;

class RequestExceptionTest extends ExceptionTestCase
{
	public function testIsSdkException()
	{
		$this->assertSubclassOf(SdkException::class, RequestException::class);
	}

	public function testExceptionStoresRequest()
	{
		$request = $this->mockRequest();
		$error = new RequestException($request);

		$this->assertSame($request, $error->getRequest());
	}
}
