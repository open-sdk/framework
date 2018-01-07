<?php

namespace OpenSdk\Tests\Exception;

use OpenSdk\Exception\DecoderException;
use OpenSdk\Exception\SdkException;
use OpenSdk\Resource\Decoder;
use OpenSdk\Tests\ExceptionTestCase;

class DecoderExceptionTest extends ExceptionTestCase
{
	public function testIsSdkException()
	{
		$this->assertSubclassOf(SdkException::class, DecoderException::class);
	}

	public function testExceptionStoresDecoder()
	{
		$decoder = $this->createMock(Decoder::class);
		$error = new DecoderException($decoder);

		$this->assertSame($decoder, $error->getDecoder());
	}
}
