<?php

namespace Koded\Caching;

use Psr\Cache\CacheItemInterface;


abstract class CacheItem implements CacheItemInterface
{
    /** @var bool */
    protected $isHit = false;

    /** @var string */
    private $key;

    /** @var mixed */
    private $value;
    
    /** @var int Number of seconds for the expiration time */
    private $expiresAt;


    public function __construct($key, ?int $ttl)
    {
        verify_key($key);
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


    public function expiresAfter($time)
    {
        // The TTL is calculated in the cache client instance
        return $this->expiresAt($time);
    }


    public function expiresAt($expiration)
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
