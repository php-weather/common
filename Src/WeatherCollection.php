<?php
declare(strict_types=1);

namespace PhpWeather;

use Countable;
use DateTimeInterface;
use Iterator;
use JsonSerializable;

/**
 * @extends Iterator<array, Weather>
 */
interface WeatherCollection extends Countable, Iterator, JsonSerializable
{
    public function add(Weather $weather): self;
    public function getFirstDate(): ?DateTimeInterface;
    public function getLatestDate(): ?DateTimeInterface;
    public function getClosest(DateTimeInterface $dateTime): ?Weather;
    public function hasCurrent(): bool;
    public function getCurrentWeather(): ?Weather;

    public function hasHistorical(): bool;
    /**
     * @return Weather[]
     */
    public function getHistorical(): array;

    public function hasForecast(): bool;
    /**
     * @return Weather[];
     */
    public function getForecast(): array;
}