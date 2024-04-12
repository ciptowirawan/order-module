<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\OpenRegistration;

class OnsiteRegistrationTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:onsite-registration-task';

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
        \Log::info("Onsite Registration Task is Running ... !");

        OpenRegistration::where('kode_status', "open-registration")
                ->update([
                    'value' => 'onsite'
                ]);
            
        $this->info('app:onsite-registration-task Command Run Successfully !');
    }
}
