<?php

namespace App\Console\Commands;

use App\Console\Services\HHService;
use Illuminate\Console\Command;

class UpdateVacanciesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hh:update-vacancies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse vacancies from HeadHunter';
    /**
     * @var HHService
     */
    private $HHService;

    /**
     * Create a new command instance.
     *
     * @param HHService $HHService
     */
    public function __construct(HHService $HHService)
    {
        parent::__construct();

        $this->HHService = $HHService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->HHService->update($this);
    }
}
