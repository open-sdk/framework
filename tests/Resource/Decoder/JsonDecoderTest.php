<?php

namespace OpenSdk\Framework\Tests\Resource\Decoder;

use OpenSdk\Framework\Exception\DecoderException;
use OpenSdk\Framework\Resource\Decoder\JsonDecoder;
use OpenSdk\Framework\Tests\TestCase;
use Psr\Http\Message\StreamInterface;

class JsonDecoderTest extends TestCase
{
	public function testDecoderReturnsDecodedJson()
	{
		$request = $this->mockRequest();
		$response = $this->mockResponse();
		$factory = $this->mockResourceFactory($request, $response);
		$stream = $this->createMock(StreamInterface::class);
		$json = json_encode(['testing' => true]);

		$response->method('getBody')
			->willReturn($stream);

		$stream->method('getContents')
			->willReturn($json);

		$data = (new JsonDecoder)->toArray($factory);

		$this->assertTrue($data['testing']);
	}

	public function testDecoderThrowsExceptionForInvalidJson()
	{
		$request = $this->mockRequest();
		$response = $this->mockResponse();
		$factory = $this->mockResourceFactory($request, $response);
		$stream = $this->createMock(StreamInterface::class);

		$response->method('getBody')
			->willReturn($stream);

		$stream->method('getContents')
			->willReturn('{invalid: "json}');

		$this->expectException(DecoderException::class);

		(new JsonDecoder)->toArray($factory);
	}
}
