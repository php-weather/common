<?php
declare(strict_types=1);

namespace PhpWeather;

use PhpWeather\Common\Source;

interface Provider
{
    /**
     * @param  WeatherQuery  $query
     * @return Weather
     *
     * @throws Exception
     */
    public function getCurrentWeather(WeatherQuery $query): Weather;

    /**
     * @param  WeatherQuery  $query
     * @return WeatherCollection
     *
     * @throws Exception
     */
    public function getForecast(WeatherQuery $query): WeatherCollection;

    /**
     * @param  WeatherQuery  $query
     * @return Weather
     *
     * @throws Exception
     */
    public function getHistorical(WeatherQuery $query): Weather;

    /**
     * @param  WeatherQuery  $query
     * @return WeatherCollection
     *
     * @throws Exception
     */
    public function getHistoricalTimeLine(WeatherQuery $query): WeatherCollection;

    /**
     * @return Source[]
     */
    public function getSources(): array;
}