<?php

namespace Koded\Caching;

use Koded\Caching\Client\CacheClientFactory;
use Koded\Caching\Configuration\ConfigFactory;
use Psr\Cache\CacheItemPoolInterface;

/**
 * CachePoolFactory creates a new instance of CacheItemPoolInterface classes.
 *
 * Production ready:
 *
 *  - Redis with redis extension
 *  - Redis with Predis library
 *  - Memcached
 *
 * Additional for development:
 *  - File
 *  - Memory (for testing)
 *  - Null
 */
class CachePoolFactory
{

    public static function new(string $client, array $parameters = []): CacheItemPoolInterface
    {
        $factory = new CacheClientFactory(new ConfigFactory($parameters));

        return new class($factory, strtolower($client)) extends CacheItemPool
        {
            public function __construct(CacheClientFactory $factory, string $client)
            {
                $this->client = $factory->build($client);
            }
        };
    }
}