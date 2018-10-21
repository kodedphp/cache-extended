<?php

namespace Koded\Caching;

use PHPUnit\Framework\TestCase;

class CacheItemTest extends TestCase
{

    public function test_expiresAfter_with_global_ttl()
    {
        $pool = CachePoolFactory::new('memory', [
            'ttl' => 60
        ]);

        $item = $pool->getItem('fubar');
        $item->expiresAfter(null);

        $this->assertAttributeGreaterThanOrEqual(time() + 60, 'expiresAt', $item);
    }
}
