<?php

namespace OpenSdk\Framework\Tests\Exception;

use OpenSdk\Framework\Exception\ResponseException;
use OpenSdk\Framework\Exception\SdkException;
use OpenSdk\Framework\Tests\ExceptionTestCase;

class ResponseExceptionTest extends ExceptionTestCase
{
	public function testIsSdkException()
	{
		$request = $this->mockRequest();
		$response = $this->mockResponse();

		$error = new ResponseException('testing', $request, $response);

		$this->assertInstanceOf(SdkException::class, $error);
	}

	public function testExceptionStoresRequestAndResponse()
	{
		$request = $this->mockRequest();
		$response = $this->mockResponse();

		$error = new ResponseException('testing', $request, $response);

		$this->assertSame($request, $error->getRequest());
		$this->assertSame($response, $error->getResponse());
	}

	public function testExceptionCodeIsResponseStatusCode()
	{
		$request = $this->mockRequest();
		$response = $this->mockResponse(404);

		$error = new ResponseException('testing', $request, $response);

		$this->assertSame(404, $error->getCode());
	}
}
