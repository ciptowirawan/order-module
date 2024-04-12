<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\OpenRegistration;

class OpenRegistrationTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:open-registration-task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     */
    public function handle()
    {
        \Log::info("Open Registration Task is Running ... !");

        OpenRegistration::where('kode_status', "open-registration")
                ->update([
                    'value' => 'regular'
                ]);
            
        $this->info('app:open-registration-task Command Run Successfully !');
    }
}
