<?php

namespace Koded\Caching;

use Koded\Caching\Client\RedisClient;
use PHPUnit\Framework\TestCase;

class RedisClientTest extends TestCase
{

    use CacheItemPoolTestCaseTrait;

    public function test_RedisClient()
    {
        $this->assertAttributeInstanceOf(RedisClient::class, 'client', $this->pool);
    }

    protected function setUp()
    {
        if (false === extension_loaded('redis')) {
            $this->markTestSkipped('Redis extension is not loaded.');
        }

        $this->pool = CachePoolFactory::new('redis', [
            'host' => getenv('REDIS_SERVER_HOST')
        ]);
    }
}
