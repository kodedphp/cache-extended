<?php

namespace Tests\Koded\Caching\Integration;

use Koded\Caching\CachePool;
use Psr\Cache\CacheItemPoolInterface;

class ShmopClientTest extends CachePoolIntegrationTest
{
    /**
     * @return CacheItemPoolInterface that is used in the tests
     */
    public function createCachePool()
    {
        return CachePool::use('shmop');
    }

    protected function setUp(): void
    {
        if (false === extension_loaded('shmop')) {
            $this->markTestSkipped('shmop extension is not loaded.');
        }

        parent::setUp();
    }
}
