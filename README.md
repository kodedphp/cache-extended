Koded - Extended Caching Library
================================

[![Latest Stable Version](https://img.shields.io/packagist/v/koded/cache-extended.svg)](https://packagist.org/packages/koded/cache-extended)
[![Build Status](https://travis-ci.org/kodedphp/cache-extended.svg?branch=master)](https://travis-ci.org/kodedphp/cache-extended)
[![Codacy Badge](https://api.codacy.com/project/badge/Coverage/f1aefebb27b1485dbeb2b00ffe7c77fc)](https://www.codacy.com/app/kodeart/cache-extended)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/f1aefebb27b1485dbeb2b00ffe7c77fc)](https://www.codacy.com/app/kodeart/cache-extended)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.2-8892BF.svg)](https://php.net/)
[![Software license](https://img.shields.io/badge/License-BSD%203--Clause-blue.svg)](LICENSE)

A [PSR-6][psr-6] caching library for PHP 7 using several caching technologies.


Requirements
------------

- Linux machine
- PHP 7.1 or higher

Recommended cache technologies are

- Redis server
- Memcached

Recommended PHP modules

- [Redis extension]
- [Memcached extension]

For developing purposes you can use

- Memory client (default)
- File client


Usage
-----

- create an instance of `CacheItemPoolInterface` with desired caching technology
- manipulate the cache items with the pool instance


```php
$cache = CachePool::use('redis');

$item = $cache->getItem('fubar');
$item->set('some value');
$item->expiresAfter(new DateTime('3 days'));

$cache->save();
```

**The pool instance is created only once.**

> `CachePool::use()` accepts specific parameters for the underlying caching technology.  
This method uses the [Koded Simple Cache][koded-cache-simple] package.
Please see the README in that repository for the specific arguments.

You can grab the cache client if you want to use it directly

```php
/** $var Psr\SimpleCache\CacheInterface $client */
$client = $cache->client();
```

Deferring the items
-------------------

To postpone the saving of the cache items (store all items "at once"),
you can use the `saveDeferred()` method. These cache items are saved when you

- execute `commit()`
- when `CacheItemPoolInterface` instance is destroyed

**Keep in mind that `commit()` is not an atomic operation.**
There is no guarantee that all items will be saved, because anything can
happen while `save()` runs (network, client crash, etc).

```php
$cache->saveDeferred($event);
$cache->saveDeferred($counter);

// ... do some stuff

// store this now
$cache->save($dependency);

// ... do more stuff

$cache->saveDeferred($updates);
$cache->saveDeferred($extras);

// Store all deferred items
$cache->commit();
```

License
-------

The code is distributed under the terms of [The 3-Clause BSD license](LICENSE).


[psr-6]: http://www.php-fig.org/psr/psr-6/
[koded-cache-simple]: https://github.com/kodedphp/cache-simple#configuration-directives
[Redis extension]: https://github.com/phpredis/phpredis/blob/develop/INSTALL.markdown
[Memcached extension]: https://github.com/php-memcached-dev/php-memcached
