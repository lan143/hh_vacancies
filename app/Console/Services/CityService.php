<?php

namespace App\Console\Services;

use App\City;
use App\Repositories\CitiesRepositoryInterface;

class CityService implements CityServiceInterface
{
    /**
     * @var CitiesRepositoryInterface
     */
    private $citiesRepository;

    /**
     * @var array
     */
    private $cache = [];

    /**
     * @var bool
     */
    private $cacheInited = false;

    /**
     * CityService constructor.
     * @param CitiesRepositoryInterface $citiesRepository
     */
    public function __construct(CitiesRepositoryInterface $citiesRepository)
    {
        $this->citiesRepository = $citiesRepository;
    }

    /**
     * @param string $name
     * @return City
     */
    public function getCityByName(string $name): City
    {
        if (!$this->cacheInited) {
            $this->initCache();
        }

        if (array_key_exists($name, $this->cache)) {
            $city = $this->cache[$name];
        } else {
            $city = new City();
            $city->name = $name;
            $this->citiesRepository->save($city);

            $this->cache[$name] = $city;
        }

        return $city;
    }

    protected function initCache(): void
    {
        $cities = $this->citiesRepository->all();

        foreach ($cities as $city) {
            $this->cache[$city->name] = $city;
        }
    }
}