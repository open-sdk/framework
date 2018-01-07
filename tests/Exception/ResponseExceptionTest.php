<?php

namespace OpenSdk\Tests\Exception;

use OpenSdk\Exception\ResponseException;
use OpenSdk\Exception\SdkException;
use OpenSdk\Tests\ExceptionTestCase;

class ResponseExceptionTest extends ExceptionTestCase
{
	public function testIsSdkException()
	{
		$this->assertSubclassOf(SdkException::class, ResponseException::class);
	}

	public function testExceptionStoresResponse()
	{
		$response = $this->mockResponse();
		$error = new ResponseException($response);

		$this->assertSame($response, $error->getResponse());
	}
}
