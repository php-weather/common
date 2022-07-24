<?php
declare(strict_types=1);

namespace PhpWeather\Common;

use DateTime;
use DateTimeInterface;
use DateTimeZone;

class WeatherQuery implements \PhpWeather\WeatherQuery
{
    private float $latitude;
    private float $longitude;
    private ?DateTimeInterface $dateTime = null;
    private string $units = \PhpWeather\WeatherQuery::METRIC;


    public static function create(float $latitude, float $longitude, ?DateTimeInterface $dateTime = null): self
    {
        $weatherQuery = new self();
        $weatherQuery->setLatitude($latitude);
        $weatherQuery->setLongitude($longitude);
        $weatherQuery->setDateTime($dateTime);

        return $weatherQuery;
    }

    public function setLatitude(float $latitude): \PhpWeather\WeatherQuery
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function setLongitude(float $longitude): \PhpWeather\WeatherQuery
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function setDateTime(?DateTimeInterface $dateTime): \PhpWeather\WeatherQuery
    {
        $this->dateTime = $dateTime;

        return $this;
    }

    public function setTimestamp(?int $timestamp): \PhpWeather\WeatherQuery
    {
        if ($timestamp === null) {
            $this->dateTime = null;
        } else {
            $this->dateTime = (new DateTime())
                ->setTimezone(new DateTimeZone('UTC'))
                ->setTimestamp($timestamp);
        }

        return $this;
    }

    public function setUnits(string $units): \PhpWeather\WeatherQuery
    {
        if (in_array($units, [\PhpWeather\WeatherQuery::METRIC, \PhpWeather\WeatherQuery::IMPERIAL], true)) {
            $this->units = $units;
        }

        return $this;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function getDateTime(): ?DateTimeInterface
    {
        return $this->dateTime;
    }

    public function getTimestamp(): ?int
    {
        if ($this->dateTime instanceof DateTimeInterface && $this->dateTime->getTimestamp() !== false) {
            return $this->dateTime->getTimestamp();
        }

        return null;
    }

    public function getUnits(): string
    {
        return $this->units;
    }
}