<?php

namespace Tests\Koded\Caching\Integration;

use Koded\Caching\CacheException;
use Koded\Caching\CachePool;
use Koded\Stdlib\Serializer;
use Psr\Cache\CacheItemPoolInterface;

class RedisJsonClientTest extends CachePoolIntegrationTest
{
    /**
     * @return CacheItemPoolInterface that is used in the tests
     */
    public function createCachePool()
    {
        try {
            return CachePool::use('redis',
                                  [
                                      'host' => getenv('REDIS_SERVER_HOST'),

                                      'serializer' => Serializer::JSON,
                                      'binary' => Serializer::PHP,
                                  ]);
        } catch (CacheException $e) {
            $this->markTestSkipped($e->getMessage());
        }
    }

    protected function setUp(): void
    {
        if (false === extension_loaded('redis')) {
            $this->markTestSkipped('Redis extension is not loaded.');
        }

        parent::setUp();
    }
}
