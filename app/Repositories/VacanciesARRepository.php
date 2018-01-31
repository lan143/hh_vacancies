<?php

namespace App\Repositories;

use App\Vacancy;
use Illuminate\Database\Eloquent\Builder;

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

    /**
     * @param string $searchQuery
     * @param int $cityId
     * @return array
     */
    public function searchByContentAndCity(?string $searchQuery, int $cityId): array
    {
        $query = (new Vacancy)->whereRaw('1 = 1');

        if ($cityId != 0) {
            $query->where('city_id', '=', $cityId);
        }

        if ($searchQuery !== null) {
            $words = explode(' ', $searchQuery);

            $query->where(function(Builder $query) use($words) {
                foreach ($words as $word) {
                    $query->orWhere('title', 'LIKE', '%' . $word . '%');
                    $query->orWhere('description', 'LIKE', '%' . $word . '%');
                }
            });
        }

        $paginator = $query->paginate(20);

        return [
            'result' => $query->get(),
            'paginator' => $paginator,
        ];
    }
}