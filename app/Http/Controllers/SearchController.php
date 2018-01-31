<?php

namespace App\Http\Controllers;

use App\Http\Forms\SearchForm;
use App\Http\Requests\SearchRequest;
use App\Http\Services\SearchServiceInterface;
use App\Repositories\CitiesRepositoryInterface;
use Illuminate\Html\FormBuilder;
use Illuminate\Html\HtmlBuilder;
use Illuminate\Pagination\Paginator;
use Illuminate\Routing\UrlGenerator;

class SearchController extends \Illuminate\Routing\Controller
{
    /**
     * @var CitiesRepositoryInterface
     */
    private $citiesRepository;

    /**
     * @var SearchServiceInterface
     */
    private $searchService;

    /**
     * SearchController constructor.
     * @param CitiesRepositoryInterface $citiesRepository
     * @param SearchServiceInterface $searchService
     */
    public function __construct(CitiesRepositoryInterface $citiesRepository, SearchServiceInterface $searchService)
    {
        $this->citiesRepository = $citiesRepository;
        $this->searchService = $searchService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $form = new SearchForm();

        return view('search.index', [
            'cities' => $this->getCitiesList(),
            'formBuilder' => $this->getFormBuilder(),
            'form' => $form,
        ]);
    }

    /**
     * @param SearchRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search(SearchRequest $request)
    {
        $form = new SearchForm();

        foreach (['query', 'city'] as $item) {
            $form->$item = $request->get($item);
        }

        $result = $this->searchService->search($form);

        /** @var Paginator $result['paginator'] */
        $result['paginator']->appends([
            'query' => $form->query,
            'city'=> $form->city,
        ]);

        return view('search.index', [
            'cities' => $this->getCitiesList(),
            'formBuilder' => $this->getFormBuilder(),
            'form' => $form,
            'vacancies' => $result['result'],
            'paginator' => $result['paginator'],
        ]);
    }

    /**
     * @return array
     */
    protected function getCitiesList(): array
    {
        $cities = [0 => 'Во всех городах'];
        $_cities = $this->citiesRepository->all();

        foreach ($_cities as $city) {
            $cities[$city->id] = $city->name;
        }

        return $cities;
    }

    /**
     * @return FormBuilder
     */
    protected function getFormBuilder(): FormBuilder
    {
        return new FormBuilder(app()->make(HtmlBuilder::class), app()->make(UrlGenerator::class), csrf_token());
    }
}