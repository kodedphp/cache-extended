<?php

namespace Tests\Koded\Caching\Integration;

use Koded\Caching\CachePool;
use org\bovigo\vfs\{vfsStream, vfsStreamDirectory};
use Psr\Cache\CacheItemPoolInterface;

class FileClientTest extends CachePoolIntegrationTest
{
    private vfsStreamDirectory $dir;

    /**
     * @return CacheItemPoolInterface that is used in the tests
     */
    public function createCachePool()
    {
        return CachePool::use('file');
    }

    protected function setUp(): void
    {
        $this->dir = vfsStream::setup();
        parent::setUp();
    }
}
