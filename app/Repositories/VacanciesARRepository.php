<?php

namespace App\Repositories;

use App\Vacancy;

/**
 * Class VacanciesARRepository
 * @package App\Repositories
 */
class VacanciesARRepository implements VacanciesRepositoryInterface
{
    /**
     * @param int $externalId
     * @return Vacancy
     */
    public function findByExternalId(int $externalId): ?Vacancy
    {
        return (new Vacancy)->where('external_id', '=', $externalId)->first();
    }

    /**
     * @param Vacancy $vacancy
     * @return bool
     */
    public function save(Vacancy $vacancy): bool
    {
        return $vacancy->save();
    }
}