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

        //hq sidebar
        view()->composer('dashboard.layouts.sidebar', function($view) {
            $provinces = DB::table('province')->where('province_code', '!=', '1374')->get();
            $regions = array();
            foreach($provinces as $prov_region) {
                if(!in_array($prov_region->region, $regions)) {
                    array_push($regions, $prov_region->region);
                }
            }
            sort($regions);

            //over all status
            $pending_count_all = count(DB::table('candidates')
                ->where('signed_by_lp',0)
                ->where('candidate_for','!=','Senator')
                ->get());
            $approved_count_all = count(DB::table('candidates')
                ->where('signed_by_lp',1)
                ->where('candidate_for','!=','Senator')
                ->get());
            $rejected_count_all = count(DB::table('candidates')
                ->where('signed_by_lp',2)
                ->where('candidate_for','!=','Senator')
                ->get());

            //regional status
            $pending_count_region = (object)[];
            $approved_count_region = (object)[];
            $rejected_count_region = (object)[];
            foreach($regions as $region){
                $province_id = DB::table('province')
                                ->select('province_code')
                                ->where('region',$region)
                                ->get();

                $count_p = 0;
                $count_a = 0;
                $count_r = 0;
                foreach($province_id as $id_province){
                    $count = count(DB::table('candidates')
                        ->where('province_id',$id_province->province_code)
                        ->where('signed_by_lp',0)
                        ->get());
                    $count_p += $count;
                    
                    $count = count(DB::table('candidates')
                                ->where('province_id',$id_province->province_code)
                                ->where('signed_by_lp',1)
                                ->get());
                    $count_a += $count;

                    $count = count(DB::table('candidates')
                                ->where('province_id',$id_province->province_code)
                                ->where('signed_by_lp',2)
                                ->get());
                    $count_r += $count;
                }

                $pending_count_region->$region = $count_p;
                $approved_count_region->$region = $count_a;
                $rejected_count_region->$region = $count_r;
            }

            //provincial status
            $pending_count_province = (object)[];
            $approved_count_province = (object)[];
            $rejected_count_province = (object)[];
            foreach($regions as $region){
                $province_id = DB::table('province')
                                ->where('region',$region)
                                ->get();

                foreach($province_id as $id_province) {
                    if($id_province->type === 'HUC' && $region !== 'NCR') {
                        $candidates_HUC = DB::table('candidates')
                            ->where('province_id',$id_province->province_code)
                            ->where('signed_by_lp',0)
                            ->get();
                        foreach($candidates_HUC as $candidate_HUC) {
                            $candidate_HUC_array = explode("-", $candidate_HUC->province_id);
                            $province_key = DB::table('province')
                                ->where('province_code',$candidate_HUC_array[0])
                                ->first()->lgu;
                            if(!isset($pending_count_province->$province_key)) {
                                $pending_count_province->$province_key = 1;
                            } else {
                                $pending_count_province->$province_key += 1;
                            }

                        }

                        $candidates_HUC = DB::table('candidates')
                            ->where('province_id',$id_province->province_code)
                            ->where('signed_by_lp',1)
                            ->get();
                        foreach($candidates_HUC as $candidate_HUC) {
                            $candidate_HUC_array = explode("-", $candidate_HUC->province_id);
                            $province_key = DB::table('province')
                                ->where('province_code',$candidate_HUC_array[0])
                                ->first()->lgu;
                            if(!isset($approved_count_province->$province_key)) {
                                $approved_count_province->$province_key = 1;
                            } else {
                                $approved_count_province->$province_key += 1;
                            }
                        }

                        $candidates_HUC = DB::table('candidates')
                            ->where('province_id',$id_province->province_code)
                            ->where('signed_by_lp',2)
                            ->get();
                        foreach($candidates_HUC as $candidate_HUC) {
                            $candidate_HUC_array = explode("-", $candidate_HUC->province_id);
                            $province_key = DB::table('province')
                                ->where('province_code',$candidate_HUC_array[0])
                                ->first()->lgu;
                            if(!isset($rejected_count_province->$province_key)) {
                                $rejected_count_province->$province_key = 1;
                            } else {
                                $rejected_count_province->$province_key += 1;
                            }
                        }
                    } else {
                        $count = count(DB::table('candidates')
                            ->where('province_id',$id_province->province_code)
                            ->where('signed_by_lp',0)
                            ->get());
                        $province_key = $id_province->lgu;
                        if(!isset($pending_count_province->$province_key)) {
                            $pending_count_province->$province_key = $count;
                        } else {
                            $pending_count_province->$province_key += $count;
                        }

                        $count = count(DB::table('candidates')
                            ->where('province_id',$id_province->province_code)
                            ->where('signed_by_lp',1)
                            ->get());
                        $province_key = $id_province->lgu;
                        if(!isset($approved_count_province->$province_key)) {
                            $approved_count_province->$province_key = $count;
                        } else {
                            $approved_count_province->$province_key += $count;
                        }


                        $count = count(DB::table('candidates')
                            ->where('province_id',$id_province->province_code)
                            ->where('signed_by_lp',2)
                            ->get());
                        $province_key = $id_province->lgu;
                        if(!isset($rejected_count_province->$province_key)) {
                            $rejected_count_province->$province_key = $count;
                        } else {
                            $rejected_count_province->$province_key += $count;
                        }
                    }
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
        
        //lec sidebar
        view()->composer('lec.layouts.sidebar', function($view){
            $userId = Auth::user()->id;
            $lec = DB::table('lec')->where('user', '=', $userId)->orWhere('user_2', '=', $userId)->first();
            $lec_name = $lec->name;
            $lecId = $lec->id;

            if ($lecId == '2018000') {
                $provinces = DB::table('province')->get();
            }
            else {
                $provinces = DB::table('province')->where('lec', 'like', '%'.$lecId.'%')->get();
            }
<<<<<<< HEAD
=======

>>>>>>> staging
            $regions = array();
            foreach($provinces as $prov_region) {
                if(!in_array($prov_region->region, $regions)) {
                    array_push($regions, $prov_region->region);
                }
            }
            sort($regions);

            //over all status
            $pending_count_all = 0;
            $approved_count_all = 0;
            $rejected_count_all = 0;

                foreach($provinces as $province_id) {
                    $pending_a = count(DB::table('candidates')
                                        ->where('signed_by_lec',0)
                                        ->where('province_id',$province_id->province_code)
                                        ->get());
                    $pending_a_HQ = 0;
                    if (strpos($province_id->lec, '2018000') === false && $lecId == '2018000') {
                        $pending_a_HQ = count(DB::table('candidates')
                                        ->where('signed_by_lec',0)
                                        ->where('province_id',$province_id->province_code)
                                        ->where(function($query) {
                                            $query->where('candidate_for', 'City Mayor')
                                                ->orWhere('candidate_for', 'Congressman')
                                                ->orWhere('candidate_for', 'HUC Congressman')
                                                ->orWhere('candidate_for', 'Governor');
                                        })
                                        ->get());
                    }

                    $pending_count_all = $pending_count_all + $pending_a + $pending_a_HQ;

                    $approved_a = count(DB::table('candidates')
                                        ->where('signed_by_lec',1)
                                        ->where('province_id',$province_id->province_code)
                                        ->get());

                    $approved_a_HQ = 0;
                    if (strpos($province_id->lec, '2018000') === false && $lecId == '2018000') {
                        $approved_a_HQ = count(DB::table('candidates')
                                        ->where('signed_by_lec',1)
                                        ->where('province_id',$province_id->province_code)
                                        ->where(function($query) {
                                            $query->where('candidate_for', 'City Mayor')
                                                ->orWhere('candidate_for', 'Congressman')
                                                ->orWhere('candidate_for', 'HUC Congressman')
                                                ->orWhere('candidate_for', 'Governor');
                                        })
                                        ->get());
                    }

                    $approved_count_all = $approved_count_all + $approved_a + $approved_a_HQ;

                    $rejected_a = count(DB::table('candidates')
                                        ->where('signed_by_lec',2)
                                        ->where('province_id',$province_id->province_code)
                                        ->get());

                    $rejected_a_HQ = 0;
                    if (strpos($province_id->lec, '2018000') === false && $lecId == '2018000') {
                        $rejected_a_HQ = count(DB::table('candidates')
                                        ->where('signed_by_lec',2)
                                        ->where('province_id',$province_id->province_code)
                                        ->where(function($query) {
                                            $query->where('candidate_for', 'City Mayor')
                                                ->orWhere('candidate_for', 'Congressman')
                                                ->orWhere('candidate_for', 'HUC Congressman')
                                                ->orWhere('candidate_for', 'Governor');
                                        })
                                        ->get());
                    }

                    $rejected_count_all = $rejected_count_all + $rejected_a + $rejected_a_HQ;
                }

            //regional status
            $pending_count_region = (object)[];
            $approved_count_region = (object)[];
            $rejected_count_region = (object)[];
            foreach($regions as $region){
                foreach($provinces as $province) {
                    if($province->region === $region) {
                        $count_p = count(DB::table('candidates')
                                    ->where('province_id',$province->province_code)
                                    ->where('signed_by_lec',0)
                                    ->get());

                        $count_p_HQ = 0;
                        if (strpos($province->lec, '2018000') === false && $lecId == '2018000') {
                            $count_p_HQ = count(DB::table('candidates')
                                            ->where('signed_by_lec',0)
                                            ->where('province_id',$province->province_code)
                                            ->where(function($query) {
                                                $query->where('candidate_for', 'City Mayor')
                                                    ->orWhere('candidate_for', 'Congressman')
                                                    ->orWhere('candidate_for', 'HUC Congressman')
                                                    ->orWhere('candidate_for', 'Governor');
                                            })
                                            ->get());
                        }

                        if(!isset($pending_count_region->$region)) {
                            $pending_count_region->$region = $count_p + $count_p_HQ;
                        } else {
                            $pending_count_region->$region += $count_p + $count_p_HQ;
                        }

                        $count_a = count(DB::table('candidates')
                                    ->where('province_id',$province->province_code)
                                    ->where('signed_by_lec',1)
                                    ->get());

                        $count_a_HQ = 0;
                        if (strpos($province->lec, '2018000') === false && $lecId == '2018000') {
                            $count_a_HQ = count(DB::table('candidates')
                                            ->where('signed_by_lec',1)
                                            ->where('province_id',$province->province_code)
                                            ->where(function($query) {
                                                $query->where('candidate_for', 'City Mayor')
                                                    ->orWhere('candidate_for', 'Congressman')
                                                    ->orWhere('candidate_for', 'HUC Congressman')
                                                    ->orWhere('candidate_for', 'Governor');
                                            })
                                            ->get());
                        }

                        if(!isset($approved_count_region->$region)) {
                            $approved_count_region->$region = $count_a + $count_a_HQ;
                        } else {
                            $approved_count_region->$region += $count_a + $count_a_HQ;
                        }

                        $count_r = count(DB::table('candidates')
                                    ->where('province_id',$province->province_code)
                                    ->where('signed_by_lec',2)
                                    ->get());

                        $count_r_HQ = 0;
                        if (strpos($province->lec, '2018000') === false && $lecId == '2018000') {
                            $count_r_HQ = count(DB::table('candidates')
                                            ->where('signed_by_lec',2)
                                            ->where('province_id',$province->province_code)
                                            ->where(function($query) {
                                                $query->where('candidate_for', 'City Mayor')
                                                    ->orWhere('candidate_for', 'Congressman')
                                                    ->orWhere('candidate_for', 'HUC Congressman')
                                                    ->orWhere('candidate_for', 'Governor');
                                            })
                                            ->get());
                        }

                        if(!isset($rejected_count_region->$region)) {
                            $rejected_count_region->$region = $count_r + $count_r_HQ;
                        } else {
                            $rejected_count_region->$region += $count_r + $count_r_HQ;
                        }
                    }
                }
            }

            //provincial status
            $pending_count_province = (object)[];
            $approved_count_province = (object)[];
            $rejected_count_province = (object)[];
            foreach($regions as $region) {
                foreach($provinces as $province) {
                    if($province->region === $region) {
                        if($province->type === 'HUC' && $region !== 'NCR') {
                            $candidates_HUC = DB::table('candidates')
                                ->where('province_id',$province->province_code)
                                ->where('signed_by_lec',0)
                                ->get();
                            foreach($candidates_HUC as $candidate_HUC) {
                                $candidate_HUC_array = explode("-", $candidate_HUC->province_id);
                                $province_key = DB::table('province')
                                    ->where('province_code',$candidate_HUC_array[0])
                                    ->first()->lgu;
                                if(!isset($pending_count_province->$province_key)) {
                                    $pending_count_province->$province_key = 1;
                                } else {
                                    $pending_count_province->$province_key += 1;
                                }

                            }

                            if (strpos($province->lec, '2018000') === false && $lecId == '2018000') {
                                $candidates_HUC = DB::table('candidates')
                                                ->where('signed_by_lec',0)
                                                ->where('province_id',$province->province_code)
                                                ->where(function($query) {
                                                    $query->where('candidate_for', 'City Mayor')
                                                        ->orWhere('candidate_for', 'Congressman')
                                                        ->orWhere('candidate_for', 'HUC Congressman')
                                                        ->orWhere('candidate_for', 'Governor');
                                                })
                                                ->get();
                                foreach($candidates_HUC as $candidate_HUC) {
                                    $candidate_HUC_array = explode("-", $candidate_HUC->province_id);
                                    $province_key = DB::table('province')
                                        ->where('province_code',$candidate_HUC_array[0])
                                        ->first()->lgu;
                                    if(!isset($pending_count_province->$province_key)) {
                                        $pending_count_province->$province_key = 1;
                                    } else {
                                        $pending_count_province->$province_key += 1;
                                    }

                                }
                            }

                            $candidates_HUC = DB::table('candidates')
                                ->where('province_id',$province->province_code)
                                ->where('signed_by_lec',1)
                                ->get();
                            foreach($candidates_HUC as $candidate_HUC) {
                                $candidate_HUC_array = explode("-", $candidate_HUC->province_id);
                                $province_key = DB::table('province')
                                    ->where('province_code',$candidate_HUC_array[0])
                                    ->first()->lgu;
                                if(!isset($approved_count_province->$province_key)) {
                                    $approved_count_province->$province_key = 1;
                                } else {
                                    $approved_count_province->$province_key += 1;
                                }
                            }

                            if (strpos($province->lec, '2018000') === false && $lecId == '2018000') {
                                $candidates_HUC = DB::table('candidates')
                                                ->where('signed_by_lec',1)
                                                ->where('province_id',$province->province_code)
                                                ->where(function($query) {
                                                    $query->where('candidate_for', 'City Mayor')
                                                        ->orWhere('candidate_for', 'Congressman')
                                                        ->orWhere('candidate_for', 'HUC Congressman')
                                                        ->orWhere('candidate_for', 'Governor');
                                                })
                                                ->get();
                                foreach($candidates_HUC as $candidate_HUC) {
                                    $candidate_HUC_array = explode("-", $candidate_HUC->province_id);
                                    $province_key = DB::table('province')
                                        ->where('province_code',$candidate_HUC_array[0])
                                        ->first()->lgu;
                                    if(!isset($pending_count_province->$province_key)) {
                                        $approved_count_province->$province_key = 1;
                                    } else {
                                        $approved_count_province->$province_key += 1;
                                    }

                                }
                            }

                            $candidates_HUC = DB::table('candidates')
                                ->where('province_id',$province->province_code)
                                ->where('signed_by_lec',2)
                                ->get();
                            foreach($candidates_HUC as $candidate_HUC) {
                                $candidate_HUC_array = explode("-", $candidate_HUC->province_id);
                                $province_key = DB::table('province')
                                    ->where('province_code',$candidate_HUC_array[0])
                                    ->first()->lgu;
                                if(!isset($rejected_count_province->$province_key)) {
                                    $rejected_count_province->$province_key = 1;
                                } else {
                                    $rejected_count_province->$province_key += 1;
                                }
                            }

                            if (strpos($province->lec, '2018000') === false && $lecId == '2018000') {
                                $candidates_HUC = DB::table('candidates')
                                                ->where('signed_by_lec',2)
                                                ->where('province_id',$province->province_code)
                                                ->where(function($query) {
                                                    $query->where('candidate_for', 'City Mayor')
                                                        ->orWhere('candidate_for', 'Congressman')
                                                        ->orWhere('candidate_for', 'HUC Congressman')
                                                        ->orWhere('candidate_for', 'Governor');
                                                })
                                                ->get();
                                foreach($candidates_HUC as $candidate_HUC) {
                                    $candidate_HUC_array = explode("-", $candidate_HUC->province_id);
                                    $province_key = DB::table('province')
                                        ->where('province_code',$candidate_HUC_array[0])
                                        ->first()->lgu;
                                    if(!isset($pending_count_province->$province_key)) {
                                        $rejected_count_province->$province_key = 1;
                                    } else {
                                        $rejected_count_province->$province_key += 1;
                                    }

                                }
                            }
                        } else {
                            $count = count(DB::table('candidates')
                                ->where('province_id',$province->province_code)
                                ->where('signed_by_lec',0)
                                ->get());
                            $province_key = $province->lgu;

                            $count_HQ = 0;
                            if (strpos($province->lec, '2018000') === false && $lecId == '2018000') {
                                $count_HQ = count(DB::table('candidates')
                                                ->where('signed_by_lec',0)
                                                ->where('province_id',$province->province_code)
                                                ->where(function($query) {
                                                    $query->where('candidate_for', 'City Mayor')
                                                        ->orWhere('candidate_for', 'Congressman')
                                                        ->orWhere('candidate_for', 'HUC Congressman')
                                                        ->orWhere('candidate_for', 'Governor');
                                                })
                                                ->get());
                            }
                            if(!isset($pending_count_province->$province_key)) {
                                $pending_count_province->$province_key = $count + $count_HQ;
                            } else {
                                $pending_count_province->$province_key += $count + $count_HQ;
                            }

                            $count = count(DB::table('candidates')
                                ->where('province_id',$province->province_code)
                                ->where('signed_by_lec',1)
                                ->get());
                            $province_key = $province->lgu;

                            $count_HQ = 0;
                            if (strpos($province->lec, '2018000') === false && $lecId == '2018000') {
                                $count_HQ = count(DB::table('candidates')
                                                ->where('signed_by_lec',1)
                                                ->where('province_id',$province->province_code)
                                                ->where(function($query) {
                                                    $query->where('candidate_for', 'City Mayor')
                                                        ->orWhere('candidate_for', 'Congressman')
                                                        ->orWhere('candidate_for', 'HUC Congressman')
                                                        ->orWhere('candidate_for', 'Governor');
                                                })
                                                ->get());
                            }
                            if(!isset($approved_count_province->$province_key)) {
                                $approved_count_province->$province_key = $count + $count_HQ;
                            } else {
                                $approved_count_province->$province_key += $count + $count_HQ;
                            }


                            $count = count(DB::table('candidates')
                                ->where('province_id',$province->province_code)
                                ->where('signed_by_lec',2)
                                ->get());
                            $province_key = $province->lgu;

                            $count_HQ = 0;
                            if (strpos($province->lec, '2018000') === false && $lecId == '2018000') {
                                $count_HQ = count(DB::table('candidates')
                                                ->where('signed_by_lec',2)
                                                ->where('province_id',$province->province_code)
                                                ->where(function($query) {
                                                    $query->where('candidate_for', 'City Mayor')
                                                        ->orWhere('candidate_for', 'Congressman')
                                                        ->orWhere('candidate_for', 'HUC Congressman')
                                                        ->orWhere('candidate_for', 'Governor');
                                                })
                                                ->get());
                            }
                            if(!isset($rejected_count_province->$province_key)) {
                                $rejected_count_province->$province_key = $count + $count_HQ;
                            } else {
                                $rejected_count_province->$province_key += $count + $count_HQ;
                            }
                        }
                    }
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
                'rejected_count_province',
                'lec_name'
            ));
        });

        view()->composer('lec.lec', function($view){
            $userId = Auth::user()->id;
            $lec = DB::table('lec')->where('user', '=', $userId)->orWhere('user_2', '=', $userId)->first();
            if(count($lec) > 0) {
                $lecId = $lec->id;
                $lec_name = $lec->name;
                $lec_des = $lec->designation_gov;
                $lec_user1 = DB::table('users')->where('id',$lec->user)->first();
                $lec_user2 = DB::table('users')->where('id',$lec->user_2)->first();
                // $provinces = DB::table('province')->where('lec', 'like', '%'.$lecId.'%')->get();
                // $regions = array();
                // foreach($provinces as $prov_region) {
                //     if(!in_array($prov_region->region, $regions)) {
                //         array_push($regions, $prov_region->region);
                //     }
                // }
                // sort($regions);

                $view->with(compact(
                    'lec_name',
                    'lec_user1',
                    'lec_user2',
                    'lec_des'
                ));
            } else {

                redirect()->route('access-denied')->send();
            
            }
        });

        view()->composer('lec.screening.screening', function($view){
            $userId = Auth::user()->id;
            $lec = DB::table('lec')->where('user', '=', $userId)->orWhere('user_2', '=', $userId)->first();
            $lecId = $lec->id;

            if ($lecId == '2018000') {
                $provinces = DB::table('province')->where('province_code', '!=', '1374')->get();
            }
            else {
                $provinces = DB::table('province')->where('lec', 'like', '%'.$lecId.'%')->where('province_code', '!=', '1374')->get();
            }
            
            $regions = array();
            $municipalities = array();
            $cities = array();
            foreach($provinces as $prov_region) {
                if(!in_array($prov_region->region, $regions)) {
                    array_push($regions, $prov_region->region);
                }

                $municipality_table = DB::table('municipality')->where('province_code',$prov_region->province_code)->get()->toArray();
                if(count($municipality_table) !== 0) {
                    array_merge($municipalities, $municipality_table);
                }

                $city_table = DB::table('city')->where('province_code',$prov_region->province_code)->get()->toArray();
                if(count($city_table) !== 0) {
                    array_merge($cities, $city_table);
                }
            }
            sort($regions);

            $view->with(compact(
                'provinces',
                'regions',
                'municipalities',
                'cities'
            ));
        });

        view()->composer('lec.layouts.sidebar', function($view){
            $userId = Auth::user()->id;
            $lec = DB::table('lec')->where('user', '=', $userId)->orWhere('user_2', '=', $userId)->get()->first();
            $lecId = $lec->id;
<<<<<<< HEAD
            
=======

>>>>>>> staging
            if ($lecId == '2018000') {
                $provinces = DB::table('province')->get();
            }
            else {
                $provinces = DB::table('province')->where('lec', 'like', '%'.$lecId.'%')->get();
            }

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
