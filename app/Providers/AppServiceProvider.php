<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use App\Site;
use Symfony\Component\Routing\Route;
use Illuminate\Support\Facades\Redirect;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ( App::runningInConsole() ) return;

        if (request()->segment(1) === "bedford") {
            DB::setDefaultConnection('milton_keynes');
        }

        if ( is_null(request()->segment(1)) ) {
            return DB::setDefaultConnection('mysql');
        }
        else {
            $slug = request()->segment(1);
        }

        /**
         * If it's a site in the DB
         */
        if ( ! is_null(Site::siteChecker($slug)) ) {
            return DB::setDefaultConnection(Site::formatConnectionName($slug));
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
