<?php

namespace Koded\Caching;

use Koded\Caching\Client\MemcachedClient;
use PHPUnit\Framework\TestCase;

class MemcachedClientTest extends TestCase
{

    use CacheItemPoolTestCaseTrait;

    public function test_MemcachedClient()
    {
        $this->assertAttributeInstanceOf(MemcachedClient::class, 'client', $this->pool);
    }

    protected function setUp()
    {
        if (false === extension_loaded('memcached')) {
            $this->markTestSkipped('Memcached extension is not loaded.');
        }

        if (getenv('CI')) {
            $servers = [['127.0.0.1', 11211]];
        } else {
            $servers = [["memcached", 11211]];
        }

        $this->pool = CachePoolFactory::new('memcached', [
            'servers' => $servers
        ]);
    }
}
