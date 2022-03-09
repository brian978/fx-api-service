<?php

namespace App\Console\Commands;

use App\Services\RateImportService;
use Illuminate\Console\Command;

class ImportRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:rates';

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
        $years = range(2005, 2022);

        foreach ($years as $year) {
            $service->fileUrl = "https://www.bnr.ro/files/xml/years/nbrfxrates$year.xml";
            $service->import();
        }

        return static::SUCCESS;
    }
}
