<?php

namespace App\Console\Commands;

use App\Services\RateImportService;
use Illuminate\Console\Command;

class ImportLatestRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:latest-rates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'The command will import the currency rates';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(RateImportService $service): int
    {
        $year = (new \DateTime())->format('Y');

        $service->fileUrl = "https://www.bnr.ro/files/xml/years/nbrfxrates$year.xml";
        $service->import();

        return static::SUCCESS;
    }
}
