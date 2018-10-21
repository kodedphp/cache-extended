Koded - Extended Caching Library
================================

[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.1-8892BF.svg)](https://php.net/)
[![Build Status](https://scrutinizer-ci.com/g/kodedphp/cache-extended/badges/build.png?b=master)](https://scrutinizer-ci.com/g/kodedphp/cache-extended/build-status/master)
[![Code Coverage](https://scrutinizer-ci.com/g/kodedphp/cache-extended/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/kodedphp/cache-extended/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/kodedphp/cache-extended/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/kodedphp/cache-extended/?branch=master)
[![Latest Stable Version](https://img.shields.io/packagist/v/koded/cache-extended.svg)](https://packagist.org/packages/koded/cache-extended)
[![Software license](https://img.shields.io/badge/License-BSD%203--Clause-blue.svg)](LICENSE)

A PSR-6 caching library for PHP 7 using several caching technologies.


Requirements
------------

> The library is not tested on any Windows OS and may not work as expected there.

- PHP 7.1 or higher


Usage
-----

- create an instance of `CacheItemPoolInterface` with desired caching technology
- manipulate the cache items with the `pool` instance


```php
$pool = CachePoolFactory::new('redis');

$item = $pool->getItem('fubar');
$item->set('some value');
$item->expiresAfter(new \DateTime('+3 days'));

$pool->save();
```

NOTE: The `CachePoolFactory` accepts specific parameters for the underlying caching technology.

This library uses the [Koded Simple Cache][koded-cache-simple]. Please see the README in that repository.



[koded-cache-simple]: https://github.com/kodedphp/cache-simple#configuration-directives