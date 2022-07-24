<?php
declare(strict_types=1);

namespace PhpWeather;

use DateTimeInterface;

interface WeatherQuery
{
    public const METRIC = 'metric';
    public const IMPERIAL = 'imperial';

    public static function create(float $latitude, float $longitude, ?DateTimeInterface $dateTime): self;

    public function setLatitude(float $latitude): self;
    public function setLongitude(float $longitude): self;
    public function setDateTime(?DateTimeInterface $dateTime): self;
    public function setTimestamp(?int $timestamp): self;
    public function setUnits(string $units): self;

    public function getLatitude(): float;
    public function getLongitude(): float;
    public function getDateTime(): ?DateTimeInterface;
    public function getTimestamp(): ?int;
    public function getUnits(): string;
}