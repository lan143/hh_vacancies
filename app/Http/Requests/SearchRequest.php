<?php

namespace App\Http\Requests;

use App\Repositories\CitiesRepositoryInterface;
use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
    /**
     * @var CitiesRepositoryInterface
     */
    private $citiesRepository;

    /**
     * SearchRequest constructor.
     * @param array $query
     * @param array $request
     * @param array $attributes
     * @param array $cookies
     * @param array $files
     * @param array $server
     * @param null $content
     * @param CitiesRepositoryInterface $citiesRepository
     */
    public function __construct(
        array $query = array(),
        array $request = array(),
        array $attributes = array(),
        array $cookies = array(),
        array $files = array(),
        array $server = array(),
        $content = null,
        CitiesRepositoryInterface $citiesRepository
    ) {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);

        $this->citiesRepository = $citiesRepository;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $cityIds = [0];
        $cities = $this->citiesRepository->all();

        foreach ($cities as $city) {
            $cityIds[] = $city->id;
        }

        return [
            'query' => 'max:500',
            'city' => 'required|in:' . implode(',', $cityIds),
        ];
    }
}
