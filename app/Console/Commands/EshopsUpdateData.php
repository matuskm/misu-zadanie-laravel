<?php

namespace App\Console\Commands;

use App\Services\EshopService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class EshopsUpdateData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eshop-action:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run a script to update e-shop data from a feed.';

    public function __construct(EshopService $eshopService)
    {
        parent::__construct();
        $this->eshopService = $eshopService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info( 'The command "eshop-action:update" has been launched.' );

        $run = $this->eshopService->getDataFromAllEshops();

        Log::info( 'E-shops class: '. implode(' | ', $run['eshops_class']) );
        Log::info( 'E-shops: '. implode(' | ', $run['eshops']) );
        Log::info( 'The command "eshop-action:update" has been successfully completed.' );

        return 0;
    }
}
