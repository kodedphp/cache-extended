<?php

namespace Tests\Koded\Caching;

use Koded\Caching\CachePool;
use PHPUnit\Framework\TestCase;

class CacheItemTest extends TestCase
{
    public function test_expiresAfter_with_global_ttl()
    {
        $pool = CachePool::use('memory', ['ttl' => 60]);

        $item = $pool->getItem('fubar');
        $item->expiresAfter(null);

        $this->assertAttributeEquals(60, 'expiresAt', $item,
            'For expiresAt=NULL the global TTL is used (if provided)');
    }
}
