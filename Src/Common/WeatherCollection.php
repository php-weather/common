<?php
declare(strict_types=1);

namespace PhpWeather\Common;

use DateTimeInterface;
use JetBrains\PhpStorm\ArrayShape;
use PhpWeather\Exception\InvalidValueException;
use PhpWeather\Weather;

class WeatherCollection implements \PhpWeather\WeatherCollection
{
    private const HISTORICAL = 'historical';
    private const CURRENT = 'current';
    private const FORECAST = 'forecast';

    /**
     * @var Weather[]
     */
    private array $historical = [];
    private ?Weather $current = null;
    /**
     * @var Weather[];
     */
    private array $forecast = [];

    private string $positionType;
    private int $position;

    private ?DateTimeInterface $firstDate = null;
    private ?DateTimeInterface $latestDate = null;

    public function __construct()
    {
        $this->position = 0;
        $this->positionType = self::HISTORICAL;
    }

    /** @noinspection PhpMixedReturnTypeCanBeReducedInspection */
    /**
     * @throws InvalidValueException
     */
    public function current(): mixed
    {
        if ($this->positionType === self::HISTORICAL) {
            $current = $this->historical[$this->position];
        } elseif ($this->positionType === self::CURRENT) {
            $current = $this->current;
        } else {
            $current = $this->forecast[$this->position];
        }

        if ($current === null) {
            throw new InvalidValueException();
        }

        return $current;
    }

    public function next(): void
    {
        if ($this->positionType === self::HISTORICAL) {
            ++$this->position;
            if ($this->position >= count($this->historical)) {
                $this->position = 0;
                if ($this->current !== null) {
                    $this->positionType = self::CURRENT;
                } else {
                    $this->positionType = self::FORECAST;
                }
            }
        } elseif ($this->positionType === self::CURRENT) {
            $this->position = 0;
            $this->positionType = self::FORECAST;
        } elseif ($this->positionType === self::FORECAST) {
            ++$this->position;
        }
    }

    /**
     * @return array<string, mixed>
     */
    #[ArrayShape(['positionType' => "string", 'position' => "int"])]
    public function key(): array
    {
        return [
            'positionType' => $this->positionType,
            'position' => $this->position,
        ];
    }

    public function valid(): bool
    {
        if ($this->positionType === self::HISTORICAL) {
            return array_key_exists($this->position, $this->historical);
        }
        if ($this->positionType === self::CURRENT) {
            return $this->current !== null;
        }

        return array_key_exists($this->position, $this->forecast);
    }

    public function rewind(): void
    {
        $this->position = 0;
        $this->positionType = self::HISTORICAL;
    }

    public function count(): int
    {
        $count = count($this->historical) + count($this->forecast);
        if ($this->current !== null) {
            $count++;
        }

        return $count;
    }

    public function add(Weather $weather): \PhpWeather\WeatherCollection
    {
        if ($weather->getType() === Weather::HISTORICAL) {
            $this->historical[] = $weather;
        }
        if ($weather->getType() === Weather::FORECAST) {
            $this->forecast[] = $weather;
        }
        if ($this->current === null && ($weather->getType() === Weather::CURRENT)) {
            $this->current = $weather;
        }

        if ($this->firstDate === null || $this->firstDate > $weather->getUtcDateTime()) {
            $this->firstDate = $weather->getUtcDateTime();
        }
        if ($this->latestDate === null || $this->latestDate < $weather->getUtcDateTime()) {
            $this->latestDate = $weather->getUtcDateTime();
        }

        usort($this->historical, [$this, 'sortByDate']);
        usort($this->forecast, [$this, 'sortByDate']);
        $this->rewind();

        return $this;
    }

    public function getFirstDate(): ?DateTimeInterface
    {
        return $this->firstDate;
    }

    public function getLatestDate(): ?DateTimeInterface
    {
        return $this->latestDate;
    }

    public function getClosest(DateTimeInterface $dateTime): ?Weather
    {
        $closestWeather = null;
        $difference = null;
        $weatherArray = $this->historical;
        if ($this->current !== null) {
            $weatherArray[] = $this->current;
        }
        $weatherArray += $this->forecast;
        foreach ($weatherArray as $weather) {
            if ($weather->getUtcDateTime() === null) {
                continue;
            }
            $checkDifference = abs($weather->getUtcDateTime()->getTimestamp() - $dateTime->getTimestamp());
            if ($difference === null || $checkDifference < $difference) {
                $closestWeather = $weather;
                $difference = $checkDifference;
            }
        }

        return $closestWeather;
    }

    public function hasCurrent(): bool
    {
        return $this->current !== null;
    }

    public function hasHistorical(): bool
    {
        return count($this->historical) > 0;
    }

    public function hasForecast(): bool
    {
        return count($this->forecast) > 0;
    }

    /** @noinspection PhpMixedReturnTypeCanBeReducedInspection */
    #[ArrayShape(['historical' => "\PhpWeather\Weather[]", 'current' => "null|\PhpWeather\Weather", 'forecast' => "\PhpWeather\Weather[]"])]
    public function jsonSerialize(): mixed
    {
        return [
            'historical' => $this->historical,
            'current' => $this->current,
            'forecast' => $this->forecast,
        ];
    }

    public function getCurrentWeather(): ?Weather
    {
        return $this->current;
    }

    public function getHistorical(): array
    {
        return $this->historical;
    }

    public function getForecast(): array
    {
        return $this->forecast;
    }

    private function sortByDate(Weather $a, Weather $b): int
    {
        if ($a->getUtcDateTime() === $b->getUtcDateTime()) {
            return 0;
        }

        return ($a->getUtcDateTime() < $b->getUtcDateTime()) ? -1 : 1;
    }
}