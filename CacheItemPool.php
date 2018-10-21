<?php

namespace Koded\Caching;

use Exception;
use Koded\Caching\Client\CacheClientFactory;
use Psr\Cache\{CacheItemInterface, CacheItemPoolInterface};
use Psr\SimpleCache\CacheInterface;


abstract class CacheItemPool implements CacheItemPoolInterface
{
    /** @var CacheInterface */
    protected $client;

    /** @var CacheItemInterface[] */
    private $deferred = [];

    abstract public function __construct(CacheClientFactory $factory, string $client);

    public function __destruct()
    {
        unset($this->client);
    }

    public function getItems(array $keys = []): array
    {
        $collection = [];
        foreach ($keys as $key) {
            $collection[$key] = $this->getItem($key);
        }

        return $collection;
    }

    public function getItem($key): CacheItemInterface
    {
        if (isset($this->deferred[$key])) {
            return $this->deferred[$key];
        }

        try {
            return (new class($this->client, $key) extends CacheItem
            {
            })->set($this->client->get($key));

        } catch (Exception $e) {
            throw ExtendedCacheException::from($e);
        }
    }

    public function hasItem($key): bool
    {
        try {
            return $this->client->has($key);
        } catch (Exception $e) {
            throw ExtendedCacheException::from($e);
        }
    }

    public function clear(): bool
    {
        if ($this->client->clear()) {
            $this->deferred = [];
            return true;
        }

        return false;
    }

    public function deleteItems(array $keys): bool
    {
        $deleted = 0;
        foreach ($keys as $key) {
            $this->deleteItem($key) && ++$deleted;
        }

        return count($keys) === $deleted;
    }

    public function deleteItem($key): bool
    {
        try {
            if ($this->client->delete($key)) {
                unset($this->deferred[$key]);
                return true;
            }

            return false;

        } catch (Exception $e) {
            throw ExtendedCacheException::from($e);
        }
    }

    public function saveDeferred(CacheItemInterface $item): bool
    {
        $this->deferred[$item->getKey()] = $item;

        return true;
    }

    public function commit(): bool
    {
        foreach ($this->deferred as $key => $item) {
            if (true === $this->save($item)) {
                unset($this->deferred[$key]);
            }
        }

        return empty($this->deferred);
    }

    public function save(CacheItemInterface $item): bool
    {
        /** @var CacheItem $item */
        $value = (function() {
            return $this->value;
        })->bindTo($item, $item);

        return $this->client->set($item->getKey(), $value(), cache_ttl($item->ttl()));
    }
}