<?php

namespace App\Console\Commands;

use App\Stats;
use Illuminate\Console\Command;

class GetStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stats:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches latest data from woldometer.com';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        empty(Stats::fetchKEData()) ?
            $this->error('There was a network problem updating latest information') :
            $this->info('Stats updated!');
    }
}
