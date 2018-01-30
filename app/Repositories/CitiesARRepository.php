<?php

namespace App\Repositories;

use App\City;

/**
 * Class CitiesARRepository
 * @package App\Repositories
 */
class CitiesARRepository implements CitiesRepositoryInterface
{
    /**
     * @param string $name
     * @return City|null
     */
    public function findByName(string $name): ?City
    {
        return (new City())->where('name', '=', $name)->first();
    }

    /**
     * @param City $city
     * @return bool
     */
    public function save(City $city): bool
    {
        return $city->save();
    }
}