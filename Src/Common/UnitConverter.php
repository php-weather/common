<?php
declare(strict_types=1);

namespace PhpWeather\Common;

use PhpWeather\Constants\Unit;

class UnitConverter
{
    public static function celsiusToKelvin(float $celsius): float
    {
        return round($celsius + 273.12, 2);
    }

    public static function kelvinToCelsius(float $kelvin): float
    {
        return round($kelvin - 273.12, 2);
    }

    public static function celsiusToFahrenheit(float $celsius): float
    {
        return round($celsius * 9 / 5 + 32, 2);
    }

    public static function fahrenheitToCelsius(float $fahrenheit): float
    {
        return round(($fahrenheit - 32) * 5 / 9, 2);
    }

    public static function msToKmh(float $ms): float
    {
        return round($ms * 3.6, 2);
    }

    public static function kmhToMs(float $kmh): float
    {
        return round($kmh / 3.6, 2);
    }

    public static function kmhToMph(float $kmh): float
    {
        return round($kmh / 1.60934, 2);
    }

    public static function mphToKmh(float $mph): float
    {
        return round($mph * 1.60934, 2);
    }

    public static function mapTemperature(float $temperature, string $from, string $units): float
    {
        return match ($from) {
            Unit::TEMPERATURE_KELVIN => self::mapTemperatureFromKelvin($temperature, $units),
            Unit::TEMPERATURE_FAHRENHEIT => self::mapTemperatureFromFahrenheit($temperature, $units),
            default => self::mapTemperatureFromCelsius($temperature, $units),
        };
    }

    private static function mapTemperatureFromCelsius(float $temperature, string $units): float
    {
        return match ($units) {
            Unit::IMPERIAL => self::celsiusToFahrenheit($temperature),
            Unit::STANDARD => self::celsiusToKelvin($temperature),
            default => $temperature,
        };
    }

    private static function mapTemperatureFromKelvin(float $temperature, string $units): float
    {
        return match ($units) {
            Unit::METRIC => self::kelvinToCelsius($temperature),
            Unit::IMPERIAL => self::celsiusToFahrenheit(self::kelvinToCelsius($temperature)),
            default => $temperature,
        };
    }

    private static function mapTemperatureFromFahrenheit(float $temperature, string $units): float
    {
        return match ($units) {
            Unit::METRIC => self::fahrenheitToCelsius($temperature),
            Unit::IMPERIAL => self::celsiusToKelvin(self::fahrenheitToCelsius($temperature)),
            default => $temperature,
        };
    }

    public static function mapPressure(float $pressure, string $from, string $units): float
    {
        return match ($from) {
            Unit::PRESSURE_PA => match ($units) {
                Unit::IMPERIAL, Unit::METRIC => $pressure / 100,
                default => $pressure,
            },
            default => match ($units) {
                Unit::STANDARD => $pressure * 100,
                default => $pressure,
            },
        };
    }

    public static function mapSpeed(float $speed, string $from, string $units): float
    {
        return match ($from) {
            Unit::SPEED_MS => self::mapSpeedFromMs($speed, $units),
            Unit::SPEED_MPH => self::mapSpeedFromMph($speed, $units),
            default => self::mapSpeedFromKmh($speed, $units),
        };
    }

    private static function mapSpeedFromKmh(float $speed, string $units): float
    {
        return match ($units) {
            Unit::STANDARD => self::kmhToMs($speed),
            Unit::IMPERIAL => self::kmhToMph($speed),
            default => $speed,
        };
    }

    private static function mapSpeedFromMs(float $speed, string $units): float
    {
        return match ($units) {
            Unit::METRIC => self::msToKmh($speed),
            Unit::IMPERIAL => self::kmhToMph(self::msToKmh($speed)),
            default => $speed,
        };
    }

    private static function mapSpeedFromMph(float $speed, string $units): float
    {
        return match ($units) {
            Unit::METRIC => self::mphToKmh($speed),
            Unit::STANDARD => self::kmhToMs(self::mphToKmh($speed)),
            default => $speed,
        };
    }

    public static function mapPrecipitation(float $precipitation, string $from, string $units): float
    {
        return match ($from) {
            Unit::PRECIPITAION_INCHES => match ($units) {
                Unit::IMPERIAL => $precipitation,
                default => $precipitation * 25.4,
            },
            default => match ($units) {
                Unit::IMPERIAL => round($precipitation / 25.4, 2),
                default => $precipitation,
            },
        };
    }
}
