<?php

namespace OpenSdk\Framework\Tests;

use OpenSdk\Framework\Exception\SdkException;

abstract class ExceptionTestCase extends TestCase
{
    abstract public function testIsSdkException();
}
