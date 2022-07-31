<?php
declare(strict_types=1);

namespace PhpWeather\Constants;
/*
 * This will be replaced by proper enums in 2.* versions
 * once we drop PHP 8.0 support
 */
class Unit
{
    public const STANDARD = 'standard';
    public const METRIC = 'metric';
    public const IMPERIAL = 'imperial';

    public const TEMPERATURE_CELSIUS = 'celsius';
    public const TEMPERATURE_FAHRENHEIT = 'fahrenheit';
    public const TEMPERATURE_KELVIN = 'kelvin';

    public const PRESSURE_HPA = 'hpa';
    public const PRESSURE_PA = 'pa';

    public const SPEED_KMH = 'kmh';
    public const SPEED_MS = 'ms';
    public const SPEED_MPH = 'mph';

    public const PRECIPITATION_MM = 'mm';
    public const PRECIPIATION_kgm = 'kgm';
    public const PRECIPITAION_INCHES = 'inches';
}