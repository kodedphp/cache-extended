<?php

namespace Koded\Caching\Tests\Integration;

use Koded\Caching\CachePool;
use Koded\Stdlib\Interfaces\Serializer;
use Psr\Cache\CacheItemPoolInterface;

class PredisJsonClientTest extends CachePoolIntegrationTest
{
    /**
     * @return CacheItemPoolInterface that is used in the tests
     */
    public function createCachePool()
    {
        return CachePool::use('predis', [
            'host'       => getenv('REDIS_SERVER_HOST'),
            'serializer' => Serializer::JSON,
            'binary'     => Serializer::PHP,
        ]);
    }
}
