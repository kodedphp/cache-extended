<?php

namespace Koded\Caching;

use Koded\Caching\Client\{MemcachedClient, MemoryClient, NullClient, PredisClient, RedisClient};
use PHPUnit\Framework\TestCase;

class CachePoolFactoryTest extends TestCase
{

    public function test_NullClient()
    {
        $pool = CachePoolFactory::new('');
        $this->assertAttributeInstanceOf(NullClient::class, 'client', $pool);
    }

    public function test_MemcachedClient()
    {
        $pool = CachePoolFactory::new('memcached');
        $this->assertAttributeInstanceOf(MemcachedClient::class, 'client', $pool);
    }

    public function test_RedisClient()
    {
        $pool = CachePoolFactory::new('redis', [
            'host' => getenv('REDIS_SERVER_HOST'),
        ]);
        $this->assertAttributeInstanceOf(RedisClient::class, 'client', $pool);
    }

    public function test_PredisClient()
    {
        $pool = CachePoolFactory::new('predis', [
            'host' => getenv('REDIS_SERVER_HOST'),
        ]);
        $this->assertAttributeInstanceOf(PredisClient::class, 'client', $pool);
    }

    public function test_MemoryClient()
    {
        $pool = CachePoolFactory::new('memory');
        $this->assertAttributeInstanceOf(MemoryClient::class, 'client', $pool);
    }
}
