<?php

namespace ahmetbarut\View;

class Container
{
    public static array $resolved = [];

    /**
     * @param  mixed  $resolved
     */
    public static function setResolved(mixed $resolved): void
    {
        self::$resolved['view']= $resolved;
    }
}