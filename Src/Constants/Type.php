<?php
declare(strict_types=1);

namespace PhpWeather\Constants;

/*
 * This will be replaced by proper enums in 2.* versions
 * once we drop PHP 8.0 support
 */
class Type
{
    public const CURRENT = 'current';
    public const HISTORICAL = 'historical';
    public const FORECAST = 'forecast';
}
