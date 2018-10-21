<?php

namespace Koded\Caching;

use Koded\Caching\Client\MemoryClient;
use PHPUnit\Framework\TestCase;

class MemoryClientTest extends TestCase
{

    use CacheItemPoolTestCaseTrait;

    public function test_MemoryClient()
    {
        $this->assertAttributeInstanceOf(MemoryClient::class, 'client', $this->pool);
    }

    protected function setUp()
    {
        $this->pool = CachePoolFactory::new('memory');
    }
}
