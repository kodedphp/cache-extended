<?php

namespace Tests\Koded\Caching\Integration;

use Cache\IntegrationTests\CachePoolTest;

abstract class CachePoolIntegrationTest extends CachePoolTest
{
    protected $skippedTests = [
        'testGetItemInvalidKeys' => 'Does not make sense for typed arguments',
        'testGetItemsInvalidKeys' => 'Does not make sense for typed arguments',
        'testHasItemInvalidKeys' => 'Does not make sense for typed arguments',
    ];

    public static function invalidKeys()
    {
        $keys = parent::invalidKeys();

        // allow ":" in cache key
        unset($keys[14]);

        return $keys;
    }
}
