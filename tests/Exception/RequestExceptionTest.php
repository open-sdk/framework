<?php

namespace OpenSdk\Framework\Tests\Exception;

use OpenSdk\Framework\Exception\RequestException;
use OpenSdk\Framework\Exception\SdkException;
use OpenSdk\Framework\Tests\ExceptionTestCase;

class RequestExceptionTest extends ExceptionTestCase
{
    public function testIsSdkException()
    {
        $error = new RequestException('testing', $this->mockRequest());

        $this->assertInstanceOf(SdkException::class, $error);
    }

    public function testExceptionStoresRequest()
    {
        $request = $this->mockRequest();
        $error = new RequestException('testing', $request);

        $this->assertSame($request, $error->getRequest());
    }
}
