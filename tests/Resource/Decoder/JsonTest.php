<?php

namespace OpenSdk\Tests\Resource\Decoder;

use OpenSdk\Exception\DecoderException;
use OpenSdk\Resource\Decoder\Json as JsonDecoder;
use OpenSdk\Tests\TestCase;
use Psr\Http\Message\StreamInterface as Stream;

class JsonTest extends TestCase
{
	public function testDecoderReturnsDecodedJson()
	{
		$request = $this->mockRequest();
		$response = $this->mockResponse();
		$factory = $this->mockResourceFactory($request, $response);
		$stream = $this->createMock(Stream::class);
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
		$stream = $this->createMock(Stream::class);

		$response->method('getBody')
			->willReturn($stream);

		$stream->method('getContents')
			->willReturn('{invalid: "json}');

		$this->expectException(DecoderException::class);

		(new JsonDecoder)->toArray($factory);
	}
}
