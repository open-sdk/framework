<?php

namespace OpenSdk\Tests\Exception;

use OpenSdk\Exception\DecoderException;
use OpenSdk\Exception\SdkException;
use OpenSdk\Tests\ExceptionTestCase;

class DecoderExceptionTest extends ExceptionTestCase
{
	public function testIsSdkException()
	{
		$this->assertSubclassOf(SdkException::class, DecoderException::class);
	}
}
