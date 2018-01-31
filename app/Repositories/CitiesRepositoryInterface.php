<?php

namespace App\Repositories;

use App\City;
use Illuminate\Database\Eloquent\Collection;

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
     * @return Collection
     */
    public function all(): Collection;

    /**
     * @param City $city
     * @return bool
     */
    public function save(City $city): bool;
}