<?php

namespace Koded\Caching;

use Psr\Cache\CacheItemInterface;


abstract class CacheItem implements CacheItemInterface
{
    /** @var mixed */
    protected $value;

    /** @var Cache */
    protected $client;

    /** @var string */
    private $key;

    /** @var int Unix timestamp for expiration time */
    private $expiresAt;

    public function __construct(Cache $client, string $key)
    {
        $this->key = $key;
        $this->client = $client;
    }

    public function __destruct()
    {
        unset($this->client);
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function get()
    {
        return $this->isHit() ? $this->value : null;
    }

    public function isHit(): bool
    {
        return $this->client->has($this->key);
    }

    public function set($value)
    {
        $this->value = $value;

        return $this;
    }

    public function expiresAt($expiration)
    {
        $this->expiresAt = $expiration;

        return $this;
    }

    public function expiresAfter($time)
    {
        if (null === $time && null !== $global = $this->client->getTtl()) {
            $this->expiresAt = time() + cache_ttl($global);

            return $this;
        }

        $seconds = cache_ttl($time);
        $this->expiresAt = $seconds ? time() + $seconds : null;

        return $this;
    }

    /**
     * Returns expiration time for the cache item.
     * This method is not part of the PSR-6.
     *
     * @return int|null|\DateInterval|\DateTimeInterface
     */
    public function ttl()
    {
        return $this->expiresAt;
    }
}
