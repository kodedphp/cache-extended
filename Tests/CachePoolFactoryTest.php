<?php

namespace Koded\Caching;

use Koded\Caching\Client\{FileClient, MemcachedClient, MemoryClient, PredisClient, RedisClient};
use PHPUnit\Framework\TestCase;

class CachePoolFactoryTest extends TestCase
{

    public function test_MemcachedClient()
    {
        $pool = CachePool::use('memcached');
        $this->assertAttributeInstanceOf(MemcachedClient::class, 'client', $pool);
    }

    public function test_RedisClient()
    {
        $pool = CachePool::use('redis', [
            'host' => getenv('REDIS_SERVER_HOST'),
        ]);
        $this->assertAttributeInstanceOf(RedisClient::class, 'client', $pool);
    }

    public function test_PredisClient()
    {
        $pool = CachePool::use('predis', [
            'host' => getenv('REDIS_SERVER_HOST'),
        ]);
        $this->assertAttributeInstanceOf(PredisClient::class, 'client', $pool);
    }

    public function test_MemoryClient()
    {
        $pool1 = CachePool::use('memory');
        $pool2 = CachePool::use('');
        $this->assertAttributeInstanceOf(MemoryClient::class, 'client', $pool1);
        $this->assertAttributeInstanceOf(MemoryClient::class, 'client', $pool2);
        $this->assertNotSame($pool1, $pool2, 'The singletons are stored by name and their parameters');
    }

    public function test_FileClient()
    {
        $pool = CachePool::use('file');
        $this->assertAttributeInstanceOf(FileClient::class, 'client', $pool);
    }
}
