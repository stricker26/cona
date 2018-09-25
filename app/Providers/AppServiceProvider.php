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

            //over all status
            $pending_count_all = count(DB::table('candidates')->where('signed_by_lp',NULL)->get());
            $approved_count_all = count(DB::table('candidates')->where('signed_by_lp',1)->get());
            $rejected_count_all = count(DB::table('candidates')->where('signed_by_lp',2)->get());

            //regional status
            $pending_count_region = array();
            $approved_count_region = array();
            $rejected_count_region = array();
            foreach($regions as $region){
                $province_id = DB::table('province')
                                ->select('province_code')
                                ->where('region',$region)
                                ->get();
                $count_p = 0;
                $count_a = 0;
                $count_r = 0;
                foreach($province_id as $id_province){
                    if(count(DB::table('candidates')
                                ->where('province_id',$id_province->province_code)
                                ->where('signed_by_lp',NULL)
                                ->get()) !== 0) {
                        $count_p++;
                    }
                    
                    if(count(DB::table('candidates')
                                ->where('province_id',$id_province->province_code)
                                ->where('signed_by_lp',1)
                                ->get()) !== 0) {
                        $count_a++;
                    }

                    if(count(DB::table('candidates')
                                ->where('province_id',$id_province->province_code)
                                ->where('signed_by_lp',2)
                                ->get()) !== 0) {
                        $count_r++;
                    }
                }

                if($count_p === 0){
                    array_push($pending_count_region, 0);
                } else {
                    array_push($pending_count_region, $count_p);
                }

                if($count_a === 0){
                    array_push($approved_count_region, 0);
                } else {
                    array_push($approved_count_region, $count_a);
                }
          
                if($count_r === 0){
                    array_push($rejected_count_region, 0);
                } else {
                    array_push($rejected_count_region, $count_r);
                }
            }

            //provincial status
            $pending_count_province = (object)[];
            $approved_count_province = (object)[];
            $rejected_count_province = (object)[];
            foreach($regions as $region){
                $province_id = DB::table('province')
                                ->select('province_code')
                                ->where('region',$region)
                                ->get();
                $array_p = array();
                $array_a = array();
                $array_r = array();
                foreach($province_id as $id_province) {
                    $count = count(DB::table('candidates')
                                ->where('province_id',$id_province->province_code)
                                ->where('signed_by_lp',NULL)
                                ->get());
                    if($count !== 0) {
                        array_push($array_p, $count);
                    } else {
                        array_push($array_p, 0);
                    }

                    $count = count(DB::table('candidates')
                                ->where('province_id',$id_province->province_code)
                                ->where('signed_by_lp',1)
                                ->get());
                    if($count !== 0) {
                        array_push($array_a, $count);
                    } else {
                        array_push($array_a, 0);
                    }

                    $count = count(DB::table('candidates')
                                ->where('province_id',$id_province->province_code)
                                ->where('signed_by_lp',2)
                                ->get());
                    if($count !== 0) {
                        array_push($array_r, $count);
                    } else {
                        array_push($array_r, 0);
                    }

                    $pending_count_province->$region = $array_p;
                    $approved_count_province->$region = $array_a;
                    $rejected_count_province->$region = $array_r;
                }
            }

            $view->with(compact(
                'provinces',
                'regions',
                'pending_count_all',
                'approved_count_all',
                'rejected_count_all',
                'pending_count_region',
                'approved_count_region',
                'rejected_count_region',
                'pending_count_province',
                'approved_count_province',
                'rejected_count_province'
            ));
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
