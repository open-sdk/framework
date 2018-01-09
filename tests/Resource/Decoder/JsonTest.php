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
		$response = $this->mockResponse();
		$stream = $this->createMock(Stream::class);
		$data = ['testing' => true];

		$response->method('getBody')
			->willReturn($stream);

		$stream->method('getContents')
			->willReturn(json_encode($data));

		$this->assertSame($data, (new JsonDecoder)->decode($response));
	}

	public function testDecoderThrowsExceptionForInvalidJson()
	{
		$response = $this->mockResponse();
		$stream = $this->createMock(Stream::class);
		$data = '{"something:weird"';

		$response->method('getBody')
			->willReturn($stream);

		$stream->method('getContents')
			->willReturn($data);

		$this->expectException(DecoderException::class);

		(new JsonDecoder)->decode($response);
	}
}
