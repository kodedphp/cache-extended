<?php

namespace Koded\Caching;

use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;


trait ExceptionsTestCaseTrait
{

    /** @var CacheItemPoolInterface */
    protected $pool;

    public function test_fails_on_invalid_key_in_getItem_method()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The cache key is invalid, "invalid\key" given');
        $this->expectExceptionCode(Cache::E_INVALID_KEY);

        $this->pool->getItem('invalid\key');
    }

    public function test_fails_on_invalid_key_in_getItems_method()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The cache key is invalid, "invalid\key" given');
        $this->expectExceptionCode(Cache::E_INVALID_KEY);

        $this->pool->getItems(['fine-key', 'invalid\key']);
    }

    public function test_fails_on_invalid_key_in_has_method()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The cache key is invalid, "invalid\key" given');
        $this->expectExceptionCode(Cache::E_INVALID_KEY);

        $this->pool->hasItem('invalid\key');
    }

    public function test_fails_on_invalid_key_in_deleteItem_method()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The cache key is invalid, "invalid\key" given');
        $this->expectExceptionCode(Cache::E_INVALID_KEY);

        $this->pool->deleteItem('invalid\key');
    }

    public function test_fails_on_invalid_key_in_deleteItems_method()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The cache key is invalid, "invalid\key" given');
        $this->expectExceptionCode(Cache::E_INVALID_KEY);

        $this->pool->deleteItems(['fine-key', 'invalid\key']);
    }
}
