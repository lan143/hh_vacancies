<?php

namespace App\Repositories;

use App\City;

/**
 * Interface CitiesRepositoryInterface
 * @package App\Repositories
 */
interface CitiesRepositoryInterface
{
    /**
     * @param string $name
     * @return City|null
     */
    public function findByName(string $name): ?City;

    /**
     * @param City $city
     * @return bool
     */
    public function save(City $city): bool;
}