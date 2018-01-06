<?php

namespace OpenSdk\Tests\Exception;

use OpenSdk\Exception\RequestException;
use OpenSdk\Exception\SdkException;
use OpenSdk\Tests\ExceptionTestCase;

class RequestExceptionTest extends ExceptionTestCase
{
	public function testIsSdkException()
	{
		$error = new RequestException('testing', $this->mockRequest());

		$this->assertInstanceOf(SdkException::class, $error);
	}

	public function testExceptionStoresRequest()
	{
		$request = $this->mockRequest();
		$error = new RequestException('testing', $request);

		$this->assertSame($request, $error->getRequest());
	}
}
