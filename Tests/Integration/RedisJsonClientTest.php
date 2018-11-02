<?php

namespace Koded\Caching\Tests\Integration;

require_once __DIR__ . '/../../vendor/koded/stdlib/functions-dev.php';

use Koded\Caching\CachePool;
use Koded\Stdlib\Interfaces\Serializer;
use Psr\Cache\CacheItemPoolInterface;

class RedisJsonClientTest extends CachePoolIntegrationTest
{
    /**
     * @return CacheItemPoolInterface that is used in the tests
     */
    public function createCachePool()
    {
        return CachePool::use('redis', [
            'host' => getenv('REDIS_SERVER_HOST'),

            'serializer' => Serializer::JSON,
            'binary'     => Serializer::PHP,
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
