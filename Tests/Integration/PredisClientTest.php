<?php

namespace Koded\Caching\Tests\Integration;

use Koded\Caching\CachePool;
use Psr\Cache\CacheItemPoolInterface;

class PredisClientTest extends CachePoolIntegrationTest
{

    /**
     * @return CacheItemPoolInterface that is used in the tests
     */
    public function createCachePool()
    {
        return CachePool::use('predis', [
            'host' => getenv('REDIS_SERVER_HOST'),
        ]);
    }
}
