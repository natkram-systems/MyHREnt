<?php
declare(strict_types=1);
namespace MyHR\Support;

use MyHR\Core\Env;

final class DataFactory
{
    private static ?DataProvider $provider = null;

    public static function make(): DataProvider
    {
        if (self::$provider !== null) return self::$provider;
        return self::$provider = Env::bool('APP_DEMO')
            ? new DemoProvider()
            : new DbProvider();
    }
}