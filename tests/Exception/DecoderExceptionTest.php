<?php

namespace OpenSdk\Tests\Exception;

use OpenSdk\Exception\DecoderException;
use OpenSdk\Exception\SdkException;
use OpenSdk\Resource\DecoderInterface;
use OpenSdk\Resource\Factory as ResourceFactory;
use OpenSdk\Tests\ExceptionTestCase;

class DecoderExceptionTest extends ExceptionTestCase
{
	public function testIsSdkException()
	{
		$factory = $this->mockResourceFactory();
		$decoder = $this->createMock(DecoderInterface::class);

		$error = new DecoderException('testing', $decoder, $factory);

		$this->assertInstanceOf(SdkException::class, $error);
	}

	public function testExceptionStoresDecoderFactoryAndDefersRequestAndResponse()
	{
		$request = $this->mockRequest();
		$response = $this->mockResponse();
		$factory = $this->mockResourceFactory($request, $response);
		$decoder = $this->createMock(DecoderInterface::class);

		$error = new DecoderException('testing', $decoder, $factory);

		$this->assertSame($decoder, $error->getDecoder());
		$this->assertSame($factory, $error->getFactory());
		$this->assertSame($request, $error->getRequest());
		$this->assertSame($response, $error->getResponse());
	}

	public function testExceptionCodeIsResponseStatusCode()
	{
		$request = $this->mockRequest();
		$response = $this->mockResponse(404);
		$factory = $this->mockResourceFactory($request, $response);
		$decoder = $this->createMock(DecoderInterface::class);

		$error = new DecoderException('testing', $decoder, $factory);

		$this->assertSame(404, $error->getCode());
	}
}
