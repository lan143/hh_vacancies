<?php

namespace App\Http\Services;

use App\Http\Forms\SearchForm;
use App\Vacancy;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface SearchServiceInterface
 * @package App\Http\Services
 */
interface SearchServiceInterface
{
    /**
     * @param SearchForm $searchForm
     * @return array
     */
    public function search(SearchForm $searchForm): array;
}