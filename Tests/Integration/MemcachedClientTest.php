<?php

namespace Tests\Koded\Caching\Integration;

use Koded\Caching\CachePool;
use Psr\Cache\CacheItemPoolInterface;

class MemcachedClientTest extends CachePoolIntegrationTest
{
    /**
     * @return CacheItemPoolInterface that is used in the tests
     */
    public function createCachePool()
    {
        if (false === \extension_loaded('memcached')) {
            $this->markTestSkipped('Memcached extension is not loaded.');
        }

        return CachePool::use('memcached', [
            'servers' => [["memcached", 11211], ['127.0.0.1', 11211]],
        ]);
    }

    protected function setUp(): void
    {
        if (false === \extension_loaded('memcached')) {
            $this->markTestSkipped('Memcached extension is not loaded.');
        }

        $this->skippedTests['testKeyLength'] = 'Memcached max key length is 250 chars';

        parent::setUp();
    }
}
