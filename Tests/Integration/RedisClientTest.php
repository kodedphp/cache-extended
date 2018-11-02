<?php

namespace Koded\Caching\Tests\Integration;

use Koded\Caching\CachePool;
use Psr\Cache\CacheItemPoolInterface;

class RedisClientTest extends CachePoolIntegrationTest
{

    /**
     * @return CacheItemPoolInterface that is used in the tests
     */
    public function createCachePool()
    {
        return CachePool::use('redis', [
            'host' => getenv('REDIS_SERVER_HOST'),
        ]);
    }

    protected function setUp()
    {
        if (false === extension_loaded('redis')) {
            $this->markTestSkipped('Redis extension is not loaded.');
        }

        parent::setUp();
    }
}
