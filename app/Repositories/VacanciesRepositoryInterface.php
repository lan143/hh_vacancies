<?php

namespace App\Repositories;

use App\Vacancy;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface VacanciesRepositoryInterface
 * @package App\Repositories
 */
interface VacanciesRepositoryInterface
{
    /**
     * @param int $externalId
     * @return Vacancy
     */
    public function findByExternalId(int $externalId): ?Vacancy;

    /**
     * @param Vacancy $vacancy
     * @return bool
     */
    public function save(Vacancy $vacancy): bool;

    /**
     * @param string $searchQuery
     * @param int $cityId
     * @return array
     */
    public function searchByContentAndCity(string $searchQuery, int $cityId): array;
}