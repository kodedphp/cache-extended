<?php

namespace Koded\Caching;

use Psr\Cache\CacheItemInterface;

abstract class CacheItem implements CacheItemInterface
{
    protected bool $isHit = false;
    private string $key;
    private mixed $value = null;
    private ?int $expiresAt;

    public function __construct($key, ?int $ttl)
    {
        $this->key = $key;
        $this->expiresAt = $ttl;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function get()
    {
        return $this->value;
    }

    public function isHit(): bool
    {
        return $this->isHit;
    }

    public function set($value)
    {
        $this->value = $value;
        return $this;
    }

    public function expiresAfter($time): static
    {
        // The TTL is calculated in the cache client instance
        return $this->expiresAt($time);
    }

    public function expiresAt($expiration): static
    {
        $this->expiresAt = normalize_ttl($expiration ?? $this->expiresAt);
        if ($this->expiresAt < 1) {
            $this->isHit = false;
        }
        return $this;
    }

    /**
     * Returns expiration seconds for the cache item.
     * NULL is reserved for clients who do not support expiry
     * to implement some custom logic around the TTL.
     *
     * This method is not part of the PSR-6.
     *
     * @return int|null
     */
    public function getExpiresAt(): ?int
    {
        return $this->expiresAt;
    }
}
