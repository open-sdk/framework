<?php

namespace OpenSdk\Framework\Tests;

use OpenSdk\Framework\Client\Client;
use OpenSdk\Framework\Resource\Factory as ResourceFactory;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
	/**
	 * Create a fully-mocked request instance, based on the interface.
	 *
	 * @return Request
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
	 * @return Response
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
	 * @return ResourceFactory
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
	 * @return Client
	 */
	public function createClient(): Client
	{
		return $this->getMockForAbstractClass(Client::class);
	}
}
