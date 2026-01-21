<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

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
      Passport::enablePasswordGrant();  
    }
}


//cliente
//  Client ID ........       019bdc7e-cf51-735f-8716-99627e7e12b9  
//  Client Secret .    Xwn9q4xkKbaOyWeiPygjkR3nfRbrqFqiy09d73GU  