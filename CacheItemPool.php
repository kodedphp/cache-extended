<?php

namespace Koded\Caching;

use Exception;
use Koded\Caching\Client\CacheClientFactory;
use Psr\Cache\{CacheItemInterface, CacheItemPoolInterface};
use function Koded\Stdlib\now;


abstract class CacheItemPool implements CacheItemPoolInterface
{
    /** @var Cache */
    protected $client;

    /** @var CacheItemInterface[] */
    private $deferred = [];


    abstract public function __construct(CacheClientFactory $factory, string $client);

    // @codeCoverageIgnoreStart
    public function __destruct()
    {
        $this->commit();
    }
    // @codeCoverageIgnoreEnd

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
        return $this->client->set($item->getKey(), $item->get(), $item->getExpiresAt());
    }


    public function getItems(array $keys = []): array
    {
        $items = [];
        foreach ($keys as $key) {
            $items[$key] = $this->getItem($key);
        }

        return $items;
    }


    public function getItem($key): CacheItemInterface
    {
        try {
            $item = new class($key, $this->client->getTtl()) extends CacheItem {};

            if (false === $this->client->has($key)) {
                if (isset($this->deferred[$key])) {
                    return clone $this->deferred[$key];
                }
                return $item;
            }

            (function() {
                $this->isHit = true;

                return $this;
            })->call($item);

            return $item->set($this->client->get($key));

        } catch (Exception $e) {
            throw CachePoolException::from($e);
        }
    }


    public function hasItem($key): bool
    {
        try {
            return isset($this->deferred[$key]) || $this->client->has($key);
        } catch (Exception $e) {
            throw CachePoolException::from($e);
        }
    }


    public function clear(): bool
    {
        if ($cleared = $this->client->clear()) {
            $this->deferred = [];
        }

        return $cleared;
    }


    public function deleteItems(array $keys): bool
    {
        try {
            return $this->client->deleteMultiple($keys);
        } catch (Exception $e) {
            throw CachePoolException::from($e);
        }
    }


    public function deleteItem($key): bool
    {
        try {
            if ($deleted = $this->client->delete($key)) {
                unset($this->deferred[$key]);
            }

            return $deleted;

        } catch (Exception $e) {
            throw CachePoolException::from($e);
        }
    }


    public function saveDeferred(CacheItemInterface $item): bool
    {
        /** @var CacheItem $item */
        if (null !== $item->getExpiresAt() && $item->getExpiresAt() <= now()->getTimestamp()) {
            return false;
        }

        $this->deferred[$item->getKey()] = (function() {
            $this->isHit = true;
            return $this;
        })->call($item);

        return true;
    }
}