<?php

namespace App\Http\Services;

use App\Http\Forms\SearchForm;
use App\Repositories\VacanciesRepositoryInterface;
use App\Vacancy;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class SearchService
 * @package App\Http\Services
 */
class SearchService implements SearchServiceInterface
{
    /**
     * @var VacanciesRepositoryInterface
     */
    private $vacanciesRepository;

    /**
     * SearchService constructor.
     * @param VacanciesRepositoryInterface $vacanciesRepository
     */
    public function __construct(VacanciesRepositoryInterface $vacanciesRepository)
    {
        $this->vacanciesRepository = $vacanciesRepository;
    }

    /**
     * @param SearchForm $searchForm
     * @return array
     */
    public function search(SearchForm $searchForm): array
    {
        return $this->vacanciesRepository->searchByContentAndCity($searchForm->query, $searchForm->city);
    }
}