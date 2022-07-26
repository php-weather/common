<?php
declare(strict_types=1);

namespace PhpWeather;

use DateTimeInterface;
use JsonSerializable;
use PhpWeather\Common\Source;

interface Weather extends JsonSerializable
{
    public function getLatitude(): ?float;
    public function setLatitude(?float $latitude): self;
    public function getLongitude(): ?float;
    public function setLongitude(?float $longitude): self;

    public function getTemperature(): ?float;
    public function setTemperature(?float $temperature): self;
    public function getFeelsLike(): ?float;
    public function setFeelsLike(?float $feelsLike): self;
    public function getDewPoint(): ?float;
    public function setDewPoint(?float $dewPoint): self;

    public function getHumidity(): ?float;
    public function setHumidity(?float $humidity): self;
    public function getPressure(): ?float;
    public function setPressure(?float $pressure): self;

    public function getWindSpeed(): ?float;
    public function setWindSpeed(?float $windSpeed): self;
    public function getWindDirection(): ?float;
    public function setWindDirection(?float $windDirection): self;

    public function getPrecipitation(): ?float;
    public function setPrecipitation(?float $precipitation): self;
    public function getPrecipitationProbability(): ?float;
    public function setPrecipitationProbability(?float $precipitationProbability): self;
    public function getCloudCover(): ?float;
    public function setCloudCover(?float $cloudCover): self;

    public function getUtcDateTime(): ?DateTimeInterface;
    public function setUtcDateTime(?DateTimeInterface $utcDateTime): self;
    public function getType(): ?string;
    public function setType(?string $type): self;

    public function getWeathercode(): ?int;
    public function setWeathercode(?int $code): self;

    public function getIcon(): ?string;
    public function setIcon(?string $icon): self;

    /**
     * @return Source[]
     */
    public function getSources(): array;
    public function addSource(Source $source): self;
    public function removeSource(Source $source): self;
}