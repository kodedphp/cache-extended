<?php

namespace Koded\Caching;

use Exception;
use Psr\Cache\InvalidArgumentException;

class ExtendedCacheException extends \RuntimeException implements InvalidArgumentException
{

    public static function from(Exception $e)
    {
        return new self($e->getMessage(), $e->getCode(), $e);
    }
}
