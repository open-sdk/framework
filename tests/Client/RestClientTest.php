<?php

namespace OpenSdk\Framework\Tests\Client;

use OpenSdk\Framework\Client\RestClient;
use OpenSdk\Framework\Tests\TestCase;
use Psr\Http\Message\RequestInterface;

class RestClientTest extends TestCase
{
	public function testCreateRequestUsesOptions()
	{
		$client = $this->getMockForAbstractClass(RestClient::class);
		$options = [
			'headers' => ['X-Test' => 'true'],
			'body' => 'testing',
			'protocol' => '1.1',
		];

		$request = $client->createRequest('POST', '/my-path', $options);

		$this->assertInstanceOf(RequestInterface::class, $request);
		$this->assertSame('POST', $request->getMethod());
		$this->assertSame('/my-path', $request->getRequestTarget());
		$this->assertSame($options['headers']['X-Test'], $request->getHeaderLine('X-Test'));
		$this->assertSame($options['body'], (string) $request->getBody());
		$this->assertSame($options['protocol'], $request->getProtocolVersion());
	}

	public function testGetCreatesRequestAndSendsIt()
	{
		$request = $this->mockRequest();
		$response = $this->mockResponse();
		$client = $this->createPartialMock(RestClient::class, ['createRequest', 'send']);
		$options = [
			'headers' => ['X-Test' => 'something'],
		];

		$client->expects($this->once())
			->method('createRequest')
			->with(
				$this->identicalTo('GET'),
				$this->identicalTo('https://test.open-sdk.com/get'),
				$this->identicalTo($options)
			)
			->willReturn($request);

		$client->expects($this->once())
			->method('send')
			->with($this->identicalTo($request))
			->willReturn($response);

		$this->assertSame($response, $client->get('https://test.open-sdk.com/get', $options));
	}

	public function testPostCreatesRequestAndSendsIt()
	{
		$request = $this->mockRequest();
		$response = $this->mockResponse();
		$client = $this->createPartialMock(RestClient::class, ['createRequest', 'send']);
		$options = [
			'body' => 'something',
		];

		$client->expects($this->once())
			->method('createRequest')
			->with(
				$this->identicalTo('POST'),
				$this->identicalTo('https://test.open-sdk.com/post'),
				$this->identicalTo($options)
			)
			->willReturn($request);

		$client->expects($this->once())
			->method('send')
			->with($this->identicalTo($request))
			->willReturn($response);

		$this->assertSame($response, $client->post('https://test.open-sdk.com/post', $options));
	}

	public function testPutCreatesRequestAndSendsIt()
	{
		$request = $this->mockRequest();
		$response = $this->mockResponse();
		$client = $this->createPartialMock(RestClient::class, ['createRequest', 'send']);
		$options = [
			'protocol' => '1.1',
		];

		$client->expects($this->once())
			->method('createRequest')
			->with(
				$this->identicalTo('PUT'),
				$this->identicalTo('https://test.open-sdk.com/put'),
				$this->identicalTo($options)
			)
			->willReturn($request);

		$client->expects($this->once())
			->method('send')
			->with($this->identicalTo($request))
			->willReturn($response);

		$this->assertSame($response, $client->put('https://test.open-sdk.com/put', $options));
	}

	public function testPatchCreatesRequestAndSendsIt()
	{
		$request = $this->mockRequest();
		$response = $this->mockResponse();
		$client = $this->createPartialMock(RestClient::class, ['createRequest', 'send']);

		$client->expects($this->once())
			->method('createRequest')
			->with(
				$this->identicalTo('PATCH'),
				$this->identicalTo('https://test.open-sdk.com/patch'),
				$this->isType('array')
			)
			->willReturn($request);

		$client->expects($this->once())
			->method('send')
			->with($this->identicalTo($request))
			->willReturn($response);

		$this->assertSame($response, $client->patch('https://test.open-sdk.com/patch'));
	}

	public function testDeleteCreatesRequestAndSendsIt()
	{
		$request = $this->mockRequest();
		$response = $this->mockResponse();
		$client = $this->createPartialMock(RestClient::class, ['createRequest', 'send']);

		$client->expects($this->once())
			->method('createRequest')
			->with(
				$this->identicalTo('DELETE'),
				$this->identicalTo('https://test.open-sdk.com/delete'),
				$this->isType('array')
			)
			->willReturn($request);

		$client->expects($this->once())
			->method('send')
			->with($this->identicalTo($request))
			->willReturn($response);

		$this->assertSame($response, $client->delete('https://test.open-sdk.com/delete'));
	}
}
