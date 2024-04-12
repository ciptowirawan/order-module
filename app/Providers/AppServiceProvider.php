<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Models\OpenRegistration;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

        Blade::if('open', function () {
            $isOpen = false;

            $opened = OpenRegistration::where('kode_status', 'open-registration')->first();

            // // check if the registration is opened
                if ($opened->value == "off") {
                    return false;
                } 
    
                return true;   

        });

        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');
    }
}
