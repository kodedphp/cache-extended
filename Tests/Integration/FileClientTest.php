<?php

namespace Koded\Caching\Tests\Integration;

use Koded\Caching\CachePool;
use org\bovigo\vfs\{vfsStream, vfsStreamDirectory};
use Psr\Cache\CacheItemPoolInterface;

class FileClientTest extends CachePoolIntegrationTest
{

    /**
     * @var vfsStreamDirectory
     */
    private $dir;

    /**
     * @return CacheItemPoolInterface that is used in the tests
     */
    public function createCachePool()
    {
        return CachePool::use('file');
    }

    protected function setUp()
    {
        $this->dir = vfsStream::setup();
        parent::setUp();
    }
}
