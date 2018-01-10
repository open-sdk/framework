<?php

namespace OpenSdk\Tests;

use PHPUnit\Framework\MockObject\MockObject as PHPUnitMock;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
	/**
	 * Assert if the value has the expected class as one of its parents or implements it.
	 *
	 * @param string $expected
	 * @param mixed  $value
	 */
	public function assertSubclassOf(string $expected, $value)
	{
		$this->assertTrue(is_subclass_of($value, $expected));
	}

	/**
	 * Create a fully-mocked request instance, based on the interface.
	 *
	 * @return PHPUnitMock&Request
	 */
	public function mockRequest(): Request
	{
		return $this->createMock(Request::class);
	}

	/**
	 * Create a fully-mocked response instance, based on the interface.
	 *
	 * @param integer $statusCode
	 *
	 * @return PHPUnitMock&Response
	 */
	public function mockResponse(int $statusCode = 200): Response
	{
		$response = $this->createMock(Response::class);

		$response->method('getStatusCode')
			->willReturn($statusCode);

		return $response;
	}
}
