<?php

namespace OpenSdk\Tests\Exception;

use OpenSdk\Exception\ResourceException;
use OpenSdk\Exception\SdkException;
use OpenSdk\Tests\ExceptionTestCase;

class ResourceExceptionTest extends ExceptionTestCase
{
	public function testIsSdkException()
	{
		$error = new ResourceException('testing', $this->mockResourceFactory());

		$this->assertInstanceOf(SdkException::class, $error);
	}

	public function testExceptionStoresFactoryAndDefersRequestAndResponse()
	{
		$request = $this->mockRequest();
		$response = $this->mockResponse();
		$factory = $this->mockResourceFactory($request, $response);

		$error = new ResourceException('testing', $factory);

		$this->assertSame($factory, $error->getFactory());
		$this->assertSame($request, $error->getRequest());
		$this->assertSame($response, $error->getResponse());
	}

	public function testExceptionCodeIsResponseStatusCode()
	{
		$request = $this->mockRequest();
		$response = $this->mockResponse(404);
		$factory = $this->mockResourceFactory($request, $response);

		$error = new ResourceException('testing', $factory);

		$this->assertSame(404, $error->getCode());
	}
}
