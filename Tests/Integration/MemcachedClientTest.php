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
        if (getenv('CI')) {
            $servers = [['127.0.0.1', 11211]];
        } else {
            $servers = [["memcached", 11211]];
        }

        return CachePool::use('redis', [
            'host'    => getenv('REDIS_SERVER_HOST'),
            'servers' => $servers,
        ]);
    }

    protected function setUp()
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
