<?php

namespace OpenSdk\Framework\Tests;

use OpenSdk\Framework\Client\Client;
use OpenSdk\Framework\Resource\Factory as ResourceFactory;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
	/**
	 * Create a fully-mocked request instance, based on the interface.
	 */
	public function mockRequest(): RequestInterface
	{
		return $this->createMock(RequestInterface::class);
	}

	/**
	 * Create a fully-mocked response instance, based on the interface.
	 */
	public function mockResponse(int $statusCode = 200): ResponseInterface
	{
		$response = $this->createMock(ResponseInterface::class);

		$response->method('getStatusCode')
			->willReturn($statusCode);

		return $response;
	}

	/**
	 * Create a fully-mocked resource factory instance, based on the class.
	 */
	public function mockResourceFactory(
		RequestInterface $request = null,
		ResponseInterface $response = null
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
	 * @return Client
	 */
	public function createClient(): Client
	{
		return $this->getMockForAbstractClass(Client::class);
	}
}
