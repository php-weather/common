<?php
declare(strict_types=1);

namespace PhpWeather\Common;

use JsonSerializable;

class Source implements JsonSerializable
{
    private string $shortName;
    private string $name;
    private ?string $creditUrl;

    /**
     * @param  string  $shortName
     * @param  string  $name
     * @param  string|null  $creditUrl
     */
    public function __construct(string $shortName, string $name, ?string $creditUrl)
    {
        $this->shortName = $shortName;
        $this->name = $name;
        $this->creditUrl = $creditUrl;
    }

    public function getShortName(): string
    {
        return $this->shortName;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCreditUrl(): ?string
    {
        return $this->creditUrl;
    }

    /**
     * @return array{shortName: string, name: string, creditUrl: ?string}
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * @return array{shortName: string, name: string, creditUrl: ?string}
     */
    public function toArray(): array
    {
        return [
            'shortName' => $this->shortName,
            'name' => $this->name,
            'creditUrl' => $this->creditUrl,
        ];
    }
}