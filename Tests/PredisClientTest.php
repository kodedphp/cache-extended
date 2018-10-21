<?php

namespace Koded\Caching;

use Koded\Caching\Client\PredisClient;
use PHPUnit\Framework\TestCase;

class PredisClientTest extends TestCase
{

    use CacheItemPoolTestCaseTrait, ExceptionsTestCaseTrait;

    public function test_RedisClient()
    {
        $this->assertAttributeInstanceOf(PredisClient::class, 'client', $this->pool);
    }

    protected function setUp()
    {
        $this->pool = CachePoolFactory::new('predis', [
            'host' => getenv('REDIS_SERVER_HOST')
        ]);
    }
}
