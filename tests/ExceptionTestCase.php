<?php

namespace OpenSdk\Tests;

use OpenSdk\Exception\SdkException;

abstract class ExceptionTestCase extends TestCase
{
	abstract public function testIsSdkException();
}
