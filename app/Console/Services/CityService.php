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
        if (array_key_exists($name, $this->cache)) {
            $city = $this->cache[$name];
        } else {
            $city = $this->citiesRepository->findByName($name);

            if ($city === null) {
                $city = new City();
                $city->name = $name;
                $this->citiesRepository->save($city);
            }
        }

        return $city;
    }
}