<?php

namespace App\Repositories;

use App\Vacancy;

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
}