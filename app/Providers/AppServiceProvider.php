<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;

use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        //URL::forceScheme('https');
        view()->composer('dashboard.layouts.sidebar', function($view){
            $provinces = DB::table('province')->get();
            $regions = array();
            foreach($provinces as $prov_region) {
                if(!in_array($prov_region->region, $regions)) {
                    array_push($regions, $prov_region->region);
                }
            }
            sort($regions);
            $view->with('provinces', $provinces)->with('regions', $regions);
        });

        view()->composer('lec.layouts.sidebar', function($view){
            $userId = Auth::user()->id;
            $lec = DB::table('lec')->where('user', '=', $userId)->orWhere('user_2', '=', $userId)->get()->first();
            $lecId = $lec->id;
            $provinces = DB::table('province')->where('lec', '=', $lecId)->get();
            $regions = array();
            foreach($provinces as $prov_region) {
                if(!in_array($prov_region->region, $regions)) {
                    array_push($regions, $prov_region->region);
                }
            }
            sort($regions);
            $view->with('provinces', $provinces)->with('regions', $regions);
        });
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
