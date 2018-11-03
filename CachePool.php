<?php

namespace Koded\Caching;

use Exception;
use Psr\Cache\{CacheItemPoolInterface, InvalidArgumentException};

/**
 * CachePool creates instances of CacheItemPoolInterface classes.
 * The instances are created only once.
 *
 * Production ready:
 *
 *  - Redis, with redis extension
 *  - Redis, with Predis library
 *  - Memcached
 *
 * Additional for development:
 *  - File
 *  - Memory
 *
 */
final class CachePool
{
    /**
     * @var CacheItemPoolInterface[] The registry
     */
    private static $instances = [];

    /**
     * @param string $client     The name of the cache client
     * @param array  $parameters [optional] Configuration parameters for the cache client
     *
     * @return CacheItemPoolInterface
     */
    public static function use(string $client, array $parameters = []): CacheItemPoolInterface
    {
        $ident = md5($client . serialize($parameters));

        if (isset(self::$instances[$ident])) {
            return self::$instances[$ident];
        }

        return self::$instances[$ident] = new class($client, $parameters) extends CacheItemPool
        {
            public function __construct(string $client, array $parameters)
            {
                $this->client = simple_cache_factory($client, $parameters);
            }
        };
    }
}

/**
 * Implementation for \Psr\Cache\InvalidArgumentException
 *
 */
class CachePoolException extends Exception implements InvalidArgumentException
{
    public static function from(Exception $e)
    {
        return new self($e->getMessage(), $e->getCode());
    }
}