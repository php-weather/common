<?php
declare(strict_types=1);

namespace PhpWeather\Common;

use DateTimeInterface;

class Weather implements \PhpWeather\Weather
{
    private ?float $latitude = null;
    private ?float $longitude = null;
    private ?float $temperature = null;
    private ?float $feelsLike = null;
    private ?float $dewPoint = null;
    private ?float $humidity = null;
    private ?float $pressure = null;
    private ?float $windSpeed = null;
    private ?float $windDirection = null;
    private ?float $precipitation = null;
    private ?float $precipitationProbability = null;
    private ?float $cloudCover = null;
    private ?DateTimeInterface $utcDateTime = null;
    private ?string $type = null;

    private ?int $weatherCode = null;
    private ?string $icon = null;

    /**
     * @var Source[]
     */
    protected array $sources = [];

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getTemperature(): ?float
    {
        return $this->temperature;
    }

    public function setTemperature(?float $temperature): self
    {
        $this->temperature = $temperature;

        return $this;
    }

    public function getFeelsLike(): ?float
    {
        return $this->feelsLike;
    }

    public function setFeelsLike(?float $feelsLike): self
    {
        $this->feelsLike = $feelsLike;

        return $this;
    }

    public function getHumidity(): ?float
    {
        return $this->humidity;
    }

    public function setHumidity(?float $humidity): self
    {
        $this->humidity = $humidity;

        return $this;
    }

    public function getPressure(): ?float
    {
        return $this->pressure;
    }

    public function setPressure(?float $pressure): self
    {
        $this->pressure = $pressure;

        return $this;
    }

    public function getWindSpeed(): ?float
    {
        return $this->windSpeed;
    }

    public function setWindSpeed(?float $windSpeed): self
    {
        $this->windSpeed = $windSpeed;

        return $this;
    }

    public function getWindDirection(): ?float
    {
        return $this->windDirection;
    }

    public function setWindDirection(?float $windDirection): self
    {
        $this->windDirection = $windDirection;

        return $this;
    }

    public function getPrecipitation(): ?float
    {
        return $this->precipitation;
    }

    public function setPrecipitation(?float $precipitation): self
    {
        $this->precipitation = $precipitation;

        return $this;
    }

    public function getPrecipitationProbability(): ?float
    {
        return $this->precipitationProbability;
    }

    public function setPrecipitationProbability(?float $precipitationProbability): self
    {
        $this->precipitationProbability = $precipitationProbability;

        return $this;
    }

    public function getCloudCover(): ?float
    {
        return $this->cloudCover;
    }

    public function setCloudCover(?float $cloudCover): self
    {
        $this->cloudCover = $cloudCover;

        return $this;
    }

    public function getUtcDateTime(): ?DateTimeInterface
    {
        return $this->utcDateTime;
    }

    public function setUtcDateTime(?DateTimeInterface $utcDateTime): self
    {
        $this->utcDateTime = $utcDateTime;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Source[]
     */
    public function getSources(): array
    {
        return $this->sources;
    }

    public function addSource(Source $source): self
    {
        if (!in_array($source, $this->sources, true)) {
            $this->sources[] = $source;
        }

        return $this;
    }

    public function removeSource(Source $source): self
    {
        if (($key = array_search($source, $this->sources, true)) !== false) {
            unset($this->sources[$key]);
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }

    public function getWeathercode(): ?int
    {
        return $this->weatherCode;
    }

    public function setWeathercode(?int $code): self
    {
        $this->weatherCode = $code;

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function getDewPoint(): ?float
    {
        return $this->dewPoint;
    }

    public function setDewPoint(?float $dewPoint): self
    {
        $this->dewPoint = $dewPoint;

        return $this;
    }
}