<?php
declare(strict_types=1);

namespace PhpWeather\Tests;

use DateTime;
use DateInterval;
use DateTimeZone;
use PHPUnit\Framework\TestCase;
use PhpWeather\Common\Weather;
use PhpWeather\Common\WeatherCollection;
use PhpWeather\Constants\Type;

class WeatherCollectionTest extends TestCase
{
    public function testCollection(): void
    {
        $historicalDateTime1 = (new DateTime())
            ->setTimezone(new DateTimeZone('UTC'))
            ->sub(new DateInterval('P2D'));

        $historicalWeather1 = (new Weather())
            ->setType(Type::HISTORICAL)
            ->setUtcDateTime($historicalDateTime1)
            ->setTemperature(1);

        $historicalDateTime2 = (new DateTime())
            ->setTimezone(new DateTimeZone('UTC'))
            ->sub(new DateInterval('P1D'));

        $historicalWeather2 = (new Weather())
            ->setType(Type::HISTORICAL)
            ->setUtcDateTime($historicalDateTime2)
            ->setTemperature(2);

        $weatherCollection = new WeatherCollection();
        $weatherCollection->add($historicalWeather1);
        $weatherCollection->add($historicalWeather2);

        self::assertCount(2, $weatherCollection->getHistorical());
        self::assertCount(2, $weatherCollection);
        self::assertTrue($weatherCollection->hasHistorical());
        self::assertFalse($weatherCollection->hasCurrent());
        self::assertFalse($weatherCollection->hasForecast());

        $currentWeather = (new DateTime())
            ->setTimezone(new DateTimeZone('UTC'));

        $currentWeather = (new Weather())
            ->setType(Type::CURRENT)
            ->setUtcDateTime($currentWeather)
            ->setTemperature(3);
        $weatherCollection->add($currentWeather);

        self::assertCount(3, $weatherCollection);
        self::assertTrue($weatherCollection->hasHistorical());
        self::assertTrue($weatherCollection->hasCurrent());
        self::assertFalse($weatherCollection->hasForecast());

        $forecastDateTime1 = (new DateTime())
            ->setTimezone(new DateTimeZone('UTC'))
            ->add(new DateInterval('P1D'));

        $forecastWeather1 = (new Weather())
            ->setType(Type::FORECAST)
            ->setUtcDateTime($forecastDateTime1)
            ->setTemperature(4);

        $forecastDateTime2 = (new DateTime())
            ->setTimezone(new DateTimeZone('UTC'))
            ->add(new DateInterval('P2D'));

        $forecastWeather2 = (new Weather())
            ->setType(Type::FORECAST)
            ->setUtcDateTime($forecastDateTime2)
            ->setTemperature(5);

        $weatherCollection->add($forecastWeather1);
        $weatherCollection->add($forecastWeather2);

        self::assertCount(2, $weatherCollection->getForecast());
        self::assertCount(5, $weatherCollection);
        self::assertTrue($weatherCollection->hasHistorical());
        self::assertTrue($weatherCollection->hasCurrent());
        self::assertTrue($weatherCollection->hasForecast());

        $i = 1.0;
        foreach ($weatherCollection as $weather) {
            self::assertSame($i, $weather->getTemperature());
            $i++;
        }
    }
}