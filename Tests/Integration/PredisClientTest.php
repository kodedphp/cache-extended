<?php

namespace Tests\Koded\Caching\Integration;

use Koded\Caching\CacheException;
use Koded\Caching\CachePool;
use Psr\Cache\CacheItemPoolInterface;

class PredisClientTest extends CachePoolIntegrationTest
{
    /**
     * @return CacheItemPoolInterface that is used in the tests
     */
    public function createCachePool()
    {
        try {
            $client = CachePool::use('predis',
                                     [
                                         'host' => getenv('REDIS_SERVER_HOST'),
                                     ]);
            $client->client()->connect();
            return $client;
        } catch (CacheException $e) {
            $this->markTestSkipped($e->getMessage());
        }
    }
}
