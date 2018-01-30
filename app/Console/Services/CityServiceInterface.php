<?php

namespace App\Console\Services;

use App\City;

/**
 * Interface CityServiceInterface
 * @package App\Console\Services
 */
interface CityServiceInterface
{
    /**
     * @param string $name
     * @return City
     */
    public function getCityByName(string $name): City;
}