<?php

namespace OpenSdk\Framework\Tests\Resource;

use OpenSdk\Framework\Resource\Collection;
use OpenSdk\Framework\Resource\Resource;
use OpenSdk\Framework\Tests\TestCase;

class ResourceTest extends TestCase
{
    public function testIsCollection()
    {
        $this->assertInstanceOf(Collection::class, new Resource);
    }

    public function testGetReturnsKeyOrDefault()
    {
        $resource = new Resource(['this' => 'isset']);

        $this->assertSame('isset', $resource->get('this'));
        $this->assertSame('default', $resource->get('that', 'default'));
    }

    public function testMagicGetterReturnsKeyOrNull()
    {
        $resource = new Resource(['this' => 'isset']);

        $this->assertSame('isset', $resource->this);
        $this->assertNull($resource->that);
    }
}
