<?php

namespace Koded\Caching\Tests\Integration;

use Koded\Caching\CachePool;
use Psr\Cache\CacheItemPoolInterface;

class MemcachedClientTest extends CachePoolIntegrationTest
{

    /**
     * @return CacheItemPoolInterface that is used in the tests
     */
    public function createCachePool()
    {
        return CachePool::use('redis', [
            'host'    => getenv('REDIS_SERVER_HOST'),
            'servers' => [["memcached", 11211]],
        ]);
    }

    protected function setUp(): void
    {
        if (false === extension_loaded('memcached')) {
            $this->markTestSkipped('Memcached extension is not loaded.');
        }

        $this->skippedTests = [
            'testKeyLength' => 'Memcached max key length is 250 chars',
        ];

        parent::setUp();
    }
}
