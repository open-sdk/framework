<?php

namespace OpenSdk\Tests;

use OpenSdk\Client\Client;
use OpenSdk\Resource\Factory as ResourceFactory;
use PHPUnit\Framework\MockObject\MockObject as PHPUnitMock;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
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

	/**
	 * Create a fully-mocked resource factory instance, based on the class.
	 *
	 * @param Request  $request
	 * @param Response $response
	 *
	 * @return PHPUnitMock&ResourceFactory
	 */
	public function mockResourceFactory(
		Request $request = null,
		Response $response = null
	): ResourceFactory {
		$factory = $this->createMock(ResourceFactory::class);

		$factory->method('getRequest')
			->willReturn($request ?: $this->mockRequest());

		$factory->method('getResponse')
			->willReturn($response ?: $this->mockResponse());

		return $factory;
	}

	/**
	 * Create a partially mocked client instance, based on the abstract one.
	 *
	 * @return PHPUnitMock&Client
	 */
	public function createClient(): Client
	{
		return $this->getMockForAbstractClass(Client::class);
	}
}
