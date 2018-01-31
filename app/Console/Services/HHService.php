<?php

namespace App\Console\Services;

use App\Repositories\VacanciesRepositoryInterface;
use App\Vacancy;
use DiDom\Document;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Console\Command;

/**
 * Class HHService
 * @package App\Console\Services
 */
class HHService implements HHServiceInterface
{
    const START_VACANCY = 1;
    const MAX_VACANCIES = 50000;
    const HH_URL = 'https://hh.ru/vacancy/';

    /**
     * @var VacanciesRepositoryInterface
     */
    private $vacanciesRepository;

    /**
     * @var CityServiceInterface
     */
    private $cityService;

    /**
     * @var Client
     */
    private $client;

    /**
     * HHService constructor.
     * @param VacanciesRepositoryInterface $vacanciesRepository
     * @param CityServiceInterface $cityService
     */
    public function __construct(VacanciesRepositoryInterface $vacanciesRepository, CityServiceInterface $cityService)
    {
        $this->vacanciesRepository = $vacanciesRepository;
        $this->cityService = $cityService;

        $this->client = new Client([
            'base_uri' => self::HH_URL,
        ]);
    }

    /**
     * @param Command $command
     */
    public function update(Command $command): void
    {
        $count = 0;
        $id = self::START_VACANCY;

        while ($count < self::MAX_VACANCIES) {
            try {
                $command->info('Update vacancy ' . $id);
                $this->updateVacancy($id);
                $count++;
            } catch (HHServiceException $e) {
                $command->error($e->getMessage());
            }

            $id++;
        }
    }

    /**
     * @param int $id
     * @throws HHServiceException
     */
    protected function updateVacancy(int $id): void
    {
        $vacancyHH = $this->getVacancyFromHH($id);

        $vacancy = $this->vacanciesRepository->findByExternalId($id);

        if ($vacancy === null) {
            $vacancy = new Vacancy();
        }

        $city = $this->cityService->getCityByName($vacancyHH['city']);

        $vacancy->external_id = $id;
        $vacancy->title = $vacancyHH['title'];
        $vacancy->description = $vacancyHH['description'];
        $vacancy->city_id = $city->id;

        $this->vacanciesRepository->save($vacancy);
    }

    /**
     * @param int $id
     * @return array
     * @throws HHServiceException
     */
    protected function getVacancyFromHH(int $id): array
    {
        try {
            $response = $this->client->request('GET', (string) $id);

            $document = new Document($response->getBody()->getContents());

            $title = null;
            if ($document->has('h1.header')) {
                $title = $document->find('h1.header')[0]->innerHtml();
            }

            $description = null;
            if ($document->has('div.b-vacancy-desc-wrapper')) {
                $description = $document->find('div.b-vacancy-desc-wrapper')[0]->text();
            }

            $city = null;
            if ($document->has('div[data-qa=vacancy-region]')) {
                $city = $document->find('div[data-qa=vacancy-region]')[0]->text();
            }

            return [
                'title' => $title,
                'description' => $description,
                'city' => $city,
            ];
        } catch (ServerException $e) {
            throw new HHServiceException('Guzzle server error: ' . $e->getMessage());
        } catch (ClientException $e) {
            throw new HHServiceException('Guzzle client error: ' . $e->getMessage());
        }
    }
}