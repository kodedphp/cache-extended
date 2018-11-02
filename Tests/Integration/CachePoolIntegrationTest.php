<?php

namespace Koded\Caching\Tests\Integration;

use Cache\IntegrationTests\CachePoolTest;

abstract class CachePoolIntegrationTest extends CachePoolTest
{

    public static function invalidKeys()
    {
        $keys = parent::invalidKeys();

        // allow ":" in cache key
        unset($keys[14]);

        return $keys;
    }
}
