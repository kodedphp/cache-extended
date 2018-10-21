<?php

namespace Koded\Caching;

use Psr\Cache\{CacheItemInterface, CacheItemPoolInterface};


trait CacheItemPoolTestCaseTrait
{

    /** @var CacheItemPoolInterface */
    protected $pool;

    public function test_get_empty_item_if_not_in_the_cache()
    {
        $item = $this->pool->getItem('fubar');

        $this->assertInstanceOf(CacheItemInterface::class, $item);
        $this->assertFalse($item->isHit());
        $this->assertSame(null, $item->get());
    }

    public function test_getItems()
    {
        $items = $this->pool->getItems(['foo', 'bar', 'baz']);
        $this->assertCount(3, $items);
    }

    public function test_should_save_the_item()
    {
        $item = $this->pool->getItem('fubar');
        $item->set('hello');
        $this->pool->save($item);

        $this->assertTrue($this->pool->hasItem('fubar'));
    }

    public function test_with_expiresAt()
    {
        $item = $this->pool->getItem('fubar');
        $item->set('hello');
        $item->expiresAt(new \DateTime('31 December 2019'));
        $this->pool->save($item);

        $this->assertTrue($this->pool->hasItem('fubar'));
        $this->assertSame('hello', $this->pool->getItem('fubar')->get());
    }

    public function test_with_expiresAfter()
    {
        $item = $this->pool->getItem('fubar');
        $item->set('hello');
        $item->expiresAfter(10);
        $this->pool->save($item);

        $this->assertTrue($this->pool->hasItem('fubar'));
        $this->assertSame('hello', $this->pool->getItem('fubar')->get());
    }

    public function test_deferred_but_not_yet_persisted_item()
    {
        $item = $this->pool->getItem('fubar');
        $this->assertAttributeCount(0, 'deferred', $this->pool);

        $item->set('deferred');
        $this->pool->saveDeferred($item);
        $this->assertAttributeCount(1, 'deferred', $this->pool);

        $this->assertEquals($item, $this->pool->getItem('fubar'), 'The item is deferred, but not in the cache yet');
        $this->assertAttributeContains($item, 'deferred', $this->pool);
    }

    public function test_persist_deferred_and_delete_after()
    {
        $items = $this->pool->getItems(['foo', 'bar', 'baz']);
        $this->assertAttributeCount(0, 'deferred', $this->pool);

        $this->pool->saveDeferred($items['foo']);
        $this->pool->saveDeferred($items['bar']);
        $this->pool->saveDeferred($items['baz']);
        $this->assertAttributeCount(3, 'deferred', $this->pool);

        $saved = $this->pool->commit();
        $this->assertTrue($saved);
        $this->assertAttributeCount(0, 'deferred', $this->pool);

        // Delete now
        $deleted = $this->pool->deleteItems(['foo', 'bar', 'baz']);
        $this->assertTrue($deleted);
    }

    protected function tearDown()
    {
        $this->pool->clear();
    }
}
