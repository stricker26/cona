<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;

class profileController extends Controller
{
    public function profile(Request $request) {
        $profile = $request->screening_btn;
        $candidate = DB::table('candidates')->where('id', '=', $profile)->first();
        
        if(!$candidate->province_id) {
            $province = (object)[];
            $province->loc = "Republic of the Philippines";
            $province->type = "Nation";
            $province->lgu = "Philippines";
            $district = null;
            $city = null;
            $municipality = null;
        } else {
            $province = DB::table('province')
                            ->select('lgu','type',  'province_code', 'region')
                            ->where('province_code','=',$candidate->province_id)
                            ->first();

            $district = $candidate->district_id;
            $city = $candidate->city_id;

            if($province->type === 'HUC') {
                $municipality = null;
            } else {
                $municipality = DB::table('municipality')
                            ->select('municipality')
                            ->where('district','=',$candidate->district_id)
                            ->where('province_code','=',$candidate->province_id)
                            ->first();
                            
                if($municipality) {         
                    if(isset($municipality) === 0) {
                        $municipality = null;
                    } else {
                        $municipality = $municipality->municipality;
                    }
                }
            }
        }
        
        $cos = DB::table('chief_of_staff')->where('cos_id','=',$candidate->cos_id)->first();

        return view('dashboard.screening.profile', compact(
            'candidate',
            'province',
            'district',
            'city',
            'cos',
            'municipality'
        ));
    }

    public function profile_lec (Request $request) {
        $profile = $request->screening_btn;
        $candidate = DB::table('candidates')->where('id', '=', $profile)->first();

        if(!$candidate->province_id) {
            $province = (object)[];
            $province->loc = "Republic of the Philippines";
            $province->type = "Nation";
            $province->lgu = "Philippines";
            $district = null;
            $city = null;
            $municipality = null;
        } else {
            $province = DB::table('province')
                            ->select('lgu','type', 'province_code', 'region')
                            ->where('province_code','=',$candidate->province_id)
                            ->first();

            $district = $candidate->district_id;
            $city = $candidate->city_id;

            if($province->type === 'HUC') {
                $municipality = null;
            } else {
                $municipality = DB::table('municipality')
                            ->select('municipality')
                            ->where('district','=',$candidate->district_id)
                            ->where('province_code','=',$candidate->province_id)
                            ->first();

                if($municipality) {         
                    if(isset($municipality) === 0) {
                        $municipality = null;
                    } else {
                        $municipality = $municipality->municipality;
                    }
                }
            } 
        }

        $cos = DB::table('chief_of_staff')->where('cos_id','=',$candidate->cos_id)->first();
        return view('lec.screening.profile', compact(
            'candidate',
            'province',
            'district',
            'city',
            'cos',
            'municipality'
        ));
    }

    public function sent(Request $data_candidate) {
        $candidate_id = $data_candidate->id;
        date_default_timezone_set("Asia/Manila");
        $date_now = date("Y-m-d H:i:s");

        if(isset($data_candidate->cos_name)) {
            $data_update_cos = array(
                'name' => $data_candidate->cos_name,
                'relationship' => $data_candidate->cos_relationship,
                'address' => $data_candidate->cos_address,
                'contact' => $data_candidate->cos_contact,
                'email' => $data_candidate->cos_email
            );
            $cos_id = DB::table('candidates')->where('id',$candidate_id)->first()->cos_id;
            $update_cos = DB::table('chief_of_staff')->where('cos_id','=',$cos_id)->update($data_update_cos);

            if($update_cos) {
                if(Auth::user()->isAdmin == 1) {
                    DB::table('edit_logs')->insert([
                        'updated_candidate_id' => $candidate_id,
                        'isAdmin' => Auth::user()->isAdmin,
                        'action' => 'HQ COS Edit',
                        'updated_by_id' => Auth::user()->id,
                        'url' => \Request::fullUrl(),
                        'ip' => \Request::ip(),
                        'updated_at' => $date_now
                    ]);
                } else {
                    DB::table('edit_logs')->insert([
                        'updated_candidate_id' => $candidate_id,
                        'isAdmin' => Auth::user()->isAdmin,
                        'action' => 'LEC COS Edit',
                        'updated_by_id' => Auth::user()->id,
                        'url' => \Request::fullUrl(),
                        'ip' => \Request::ip(),
                        'updated_at' => $date_now
                    ]);
                }

                $data_candidate_province = DB::table('province')->where('lgu',strtoupper($data_candidate->loc_province))->first();
                $data_update = array(
                    'address' => $data_candidate->address,
                    'birthdate' => $data_candidate->birthdate,
                    'email' => $data_candidate->email,
                    'firstname' => $data_candidate->firstname,
                    'lastname' => $data_candidate->lastname,
                    'middlename' => $data_candidate->middlename,
                    'incumbent' => $data_candidate->incumbent,
                    'mobile' => $data_candidate->mobile,
                    'province_id' => $data_candidate_province->province_code,
                    'district_id' => ucwords(strtolower($data_candidate->loc_district)),
                    'city_id' => strtoupper($data_candidate->loc_city),
                    'landline' => $data_candidate->landline,
                    'sma' => '{"facebook":"'.$data_candidate->fb.'","twitter":"'.$data_candidate->twitter.'","instagram":"'.$data_candidate->ig.'","website":"'.$data_candidate->website.'"}',
                    'updated_at' => $date_now
                );

                $update = DB::table('candidates')->where('id','=',$candidate_id)->update($data_update);

                if($update) {
                    $alert = 'candidate success';

                    
                    if(Auth::user()->isAdmin == 1) {
                        DB::table('edit_logs')->insert([
                            'updated_candidate_id' => $candidate_id,
                            'isAdmin' => Auth::user()->isAdmin,
                            'action' => 'HQ Candidate Edit',
                            'updated_by_id' => Auth::user()->id,
                            'url' => \Request::fullUrl(),
                            'ip' => \Request::ip(),
                            'updated_at' => $date_now
                        ]);
                    } else {
                        DB::table('edit_logs')->insert([
                            'updated_candidate_id' => $candidate_id,
                            'isAdmin' => Auth::user()->isAdmin,
                            'action' => 'LEC Candidate Edit',
                            'updated_by_id' => Auth::user()->id,
                            'url' => \Request::fullUrl(),
                            'ip' => \Request::ip(),
                            'updated_at' => $date_now
                        ]);
                    }
                } else {
                    $alert = 'candidate failed';
                }
            } else {
                $alert = 'cos failed';
            }
        } else {
            $data_candidate_province = DB::table('province')->where('lgu',strtoupper($data_candidate->loc_province))->first();
            $data_update = array(
                'address' => $data_candidate->address,
                'birthdate' => $data_candidate->birthdate,
                'email' => $data_candidate->email,
                'firstname' => $data_candidate->firstname,
                'lastname' => $data_candidate->lastname,
                'middlename' => $data_candidate->middlename,
                'incumbent' => $data_candidate->incumbent,
                'mobile' => $data_candidate->mobile,
                'province_id' => $data_candidate_province->province_code,
                'district_id' => ucwords(strtolower($data_candidate->loc_district)),
                'city_id' => strtoupper($data_candidate->loc_city),
                'landline' => $data_candidate->landline,
                'sma' => '{"facebook":"'.$data_candidate->fb.'","twitter":"'.$data_candidate->twitter.'","instagram":"'.$data_candidate->ig.'","website":"'.$data_candidate->website.'"}',
                'updated_at' => $date_now
            );

            $update = DB::table('candidates')->where('id','=',$candidate_id)->update($data_update);

            if($update) {
                $alert = 'candidate success';

                if(Auth::user()->isAdmin == 1) {
                    DB::table('edit_logs')->insert([
                        'updated_candidate_id' => $candidate_id,
                        'isAdmin' => Auth::user()->isAdmin,
                        'action' => 'HQ Candidate Edit',
                        'updated_by_id' => Auth::user()->id,
                        'url' => \Request::fullUrl(),
                        'ip' => \Request::ip(),
                        'updated_at' => $date_now
                    ]);
                } else {
                    DB::table('edit_logs')->insert([
                        'updated_candidate_id' => $candidate_id,
                        'isAdmin' => Auth::user()->isAdmin,
                        'action' => 'LEC Candidate Edit',
                        'updated_by_id' => Auth::user()->id,
                        'url' => \Request::fullUrl(),
                        'ip' => \Request::ip(),
                        'updated_at' => $date_now
                    ]);
                }
            } else {
                $alert = 'candidate failed';
            }
        }
        
        return $alert;
    }

    public function approve(Request $data_candidate) {
        date_default_timezone_set("Asia/Manila");
        $date_now = date("Y-m-d H:i:s");

        $candidate_id = $data_candidate->id;


        $continue_access = false;
        $candidate_data = DB::table('candidates')->where('id',$candidate_id)->first();
        $candidate_for = $candidate_data->candidate_for;
        $province_id = $candidate_data->province_id;
        $district_id = $candidate_data->district_id;
        $city_id = $candidate_data->city_id;
        switch ($candidate_for) {
            case 'Senator':
                $senator_count = count(DB::table('candidates')
                                ->where('candidate_for','=',$candidate_for)
                                ->where('signed_by_lp','=','1')
                                ->get());
                
                //maximum senator in a party is 12
                if($senator_count == 12) {
                    $alert = 'LEC Failed Approved';
                } else {
                    $continue_access = true;
                }

                break;

            case 'Governor':
                $governor_count = count(DB::table('candidates')
                                ->where('candidate_for','=',$candidate_for)
                                ->where('signed_by_lp','=','1')
                                ->where('province_id','=',$province_id)
                                ->get());

                if($governor_count == 1) {
                    $alert = 'LEC Failed Approved';
                } else {
                    $continue_access = true;
                }

                break;

            case 'Vice Governor':
                $vgovernor_count = count(DB::table('candidates')
                                ->where('candidate_for','=',$candidate_for)
                                ->where('signed_by_lp','=','1')
                                ->where('province_id','=',$province_id)
                                ->get());

                if($vgovernor_count == 1) {
                    $alert = 'LEC Failed Approved';
                } else {
                    $continue_access = true;
                }

                break;

            case 'Board Member':
                $bmember_count = count(DB::table('candidates')
                                ->where('candidate_for','=',$candidate_for)
                                ->where('signed_by_lp','=','1')
                                ->where('province_id','=',$province_id)
                                ->where('district_id','=',$district_id)
                                ->get());

                $bmember_max = DB::table('pos_board_member')
                                ->where('province_code','=',$province_id)
                                ->where('district','=',$district_id)
                                ->first()->board_member;

                if($bmember_count == $bmember_max) {
                    $alert = 'LEC Failed Approved';
                } else {
                    $continue_access = true;
                }

                break;

            case 'Congressman':
                $congressman_count = count(DB::table('candidates')
                                ->where('candidate_for','=',$candidate_for)
                                ->where('signed_by_lp','=','1')
                                ->where('province_id','=',$province_id)
                                ->where('district_id','=',$district_id)
                                ->get());

                if($congressman_count == 1) {
                    $alert = 'LEC Failed Approved';
                } else {
                    $continue_access = true;
                }

                break;

            case 'HUC Congressman':
                $HUCcongressman_count = count(DB::table('candidates')
                                ->where('candidate_for','=',$candidate_for)
                                ->where('signed_by_lp','=','1')
                                ->where('province_id','=',$province_id)
                                ->where('district_id','=',$district_id)
                                ->get());

                if($HUCcongressman_count == 1) {
                    $alert = 'LEC Failed Approved';
                } else {
                    $continue_access = true;
                }

                break;

            case 'City Mayor':
                $region = DB::table('province')
                            ->where('province_code','=',$province_id)
                            ->first();

                if($region->region == 'NCR') {
                    $citymayor_count = count(DB::table('candidates')
                                    ->where('candidate_for','=',$candidate_for)
                                    ->where('signed_by_lp','=','1')
                                    ->where('province_id','=',$province_id)
                                    ->get());
                } else {
                    $citymayor_count = count(DB::table('candidates')
                                    ->where('candidate_for','=',$candidate_for)
                                    ->where('signed_by_lp','=','1')
                                    ->where('province_id','=',$province_id)
                                    ->where('city_id','=',$city_id)
                                    ->get());   
                }

                if($citymayor_count == 1) {
                    $alert = 'LEC Failed Approved';
                } else {
                    $continue_access = true;
                }

                break;

            case 'City Vice Mayor':
                $region = DB::table('province')
                            ->where('province_code','=',$province_id)
                            ->first();

                if($region->region == 'NCR') {
                    $cityvmayor_count = count(DB::table('candidates')
                                    ->where('candidate_for','=',$candidate_for)
                                    ->where('signed_by_lp','=','1')
                                    ->where('province_id','=',$province_id)
                                    ->get());
                } else {
                    $cityvmayor_count = count(DB::table('candidates')
                                    ->where('candidate_for','=',$candidate_for)
                                    ->where('signed_by_lp','=','1')
                                    ->where('province_id','=',$province_id)
                                    ->where('city_id','=',$city_id)
                                    ->get());   
                }

                if($cityvmayor_count == 1) {
                    $alert = 'LEC Failed Approved';
                } else {
                    $continue_access = true;
                }

                break;

            case 'City Councilor':
                $region = DB::table('province')
                            ->where('province_code','=',$province_id)
                            ->first();

                if($region->region == 'NCR') {
                    $citycouncilor_count = count(DB::table('candidates')
                                        ->where('candidate_for','=',$candidate_for)
                                        ->where('signed_by_lp','=','1')
                                        ->where('province_id','=',$province_id)
                                        ->where('district_id','=',$district_id)
                                        ->get());

                    $citycouncilor_max = DB::table('pos_city_councilor')
                                        ->where('province_code','=',$province_id)
                                        ->where('city','=',$region->lgu)
                                        ->where('distirct','=',$district_id)
                                        ->first()->city_councilor;
                } else {
                    if($district_id == null) {
                        $citycouncilor_count = count(DB::table('candidates')
                                        ->where('candidate_for','=',$candidate_for)
                                        ->where('signed_by_lp','=','1')
                                        ->where('province_id','=',$province_id)
                                        ->where('city_id','=',$city_id)
                                        ->get());

                        $citycouncilor_max = DB::table('pos_city_councilor')
                                        ->where('province_code','=',$province_id)
                                        ->where('city','=',$city_id)
                                        ->first()->city_councilor;
                    } else {
                        $citycouncilor_count = count(DB::table('candidates')
                                        ->where('candidate_for','=',$candidate_for)
                                        ->where('signed_by_lp','=','1')
                                        ->where('province_id','=',$province_id)
                                        ->where('city_id','=',$city_id)
                                        ->where('district_id','=',$district_id)
                                        ->get());

                        $citycouncilor_max = DB::table('pos_city_councilor')
                                        ->where('province_code','=',$province_id)
                                        ->where('city','=',$city_id)
                                        ->where('district','=',$district_id)
                                        ->first()->city_councilor;
                    }
                }

                if($citycouncilor_count == $citycouncilor_max) {
                    $alert = 'LEC Failed Approved';
                } else {
                    $continue_access = true;
                }

                break;

            case 'Municipal Mayor':
                $munmayor_count = count(DB::table('candidates')
                                    ->where('candidate_for','=',$candidate_for)
                                    ->where('signed_by_lp','=','1')
                                    ->where('province_id','=',$province_id)
                                    ->where('city_id','=',$city_id)
                                    ->where('district_id','=',$district_id)
                                    ->get());

                if($munmayor_count == 1) {
                    $alert = 'LEC Failed Approved';
                } else {
                    $continue_access = true;
                }

                break;

            case 'Municipal Vice Mayor':
                $munvmayor_count = count(DB::table('candidates')
                                    ->where('candidate_for','=',$candidate_for)
                                    ->where('signed_by_lp','=','1')
                                    ->where('province_id','=',$province_id)
                                    ->where('city_id','=',$city_id)
                                    ->where('district_id','=',$district_id)
                                    ->get());

                if($munvmayor_count == 1) {
                    $alert = 'LEC Failed Approved';
                } else {
                    $continue_access = true;
                }

                break;

            case 'Municipal Councilor':
                $muncouncilor_count = count(DB::table('candidates')
                                    ->where('candidate_for','=',$candidate_for)
                                    ->where('signed_by_lp','=','1')
                                    ->where('province_id','=',$province_id)
                                    ->where('city_id','=',$city_id)
                                    ->where('district_id','=',$district_id)
                                    ->get());

                $muncouncilor_max = DB::table('pos_municipal_councilor')
                                    ->where('province_code','=',$province_id)
                                    ->where('municipal_name','=',$city_id)
                                    ->first()->municipal_councilor;

                if($muncouncilor_count == $muncouncilor_max) {
                    $alert = 'LEC Failed Approved';
                } else {
                    $continue_access = true;
                }

                break;
        }

        if($continue_access) {
            $approve = DB::table('candidates')->where('id', $candidate_id)->update(['signed_by_lp' => '1']);
            if($approve) {
                $alert = 'Approved';
                DB::table('edit_logs')->insert([
                    'updated_candidate_id' => $candidate_id,
                    'isAdmin' => Auth::user()->isAdmin,
                    'action' => 'HQ Approve Candidate',
                    'updated_by_id' => Auth::user()->id,
                    'url' => \Request::fullUrl(),
                    'ip' => \Request::ip(),
                    'updated_at' => $date_now
                ]);
            }
            else {
                $alert = 'Fail';
            }
        }

        return $alert;
    }

    public function approve_lec(Request $data_candidate) {
        date_default_timezone_set("Asia/Manila");
        $date_now = date("Y-m-d H:i:s");

        $candidate_id = $data_candidate->id;

        $continue_access = false;
        $candidate_data = DB::table('candidates')->where('id',$candidate_id)->first();
        $candidate_for = $candidate_data->candidate_for;
        $province_id = $candidate_data->province_id;
        $district_id = $candidate_data->district_id;
        $city_id = $candidate_data->city_id;
        switch ($candidate_for) {
            case 'Senator':
                $senator_count = count(DB::table('candidates')
                                ->where('candidate_for','=',$candidate_for)
                                ->where('signed_by_lec','=','1')
                                ->get());
                
                //maximum senator in a party is 12
                if($senator_count == 12) {
                    $alert = 'LEC Failed Approved';
                } else {
                    $continue_access = true;
                }

                break;

            case 'Governor':
                $governor_count = count(DB::table('candidates')
                                ->where('candidate_for','=',$candidate_for)
                                ->where('signed_by_lec','=','1')
                                ->where('province_id','=',$province_id)
                                ->get());

                if($governor_count == 1) {
                    $alert = 'LEC Failed Approved';
                } else {
                    $continue_access = true;
                }

                break;

            case 'Vice Governor':
                $vgovernor_count = count(DB::table('candidates')
                                ->where('candidate_for','=',$candidate_for)
                                ->where('signed_by_lec','=','1')
                                ->where('province_id','=',$province_id)
                                ->get());

                if($vgovernor_count == 1) {
                    $alert = 'LEC Failed Approved';
                } else {
                    $continue_access = true;
                }

                break;

            case 'Board Member':
                $bmember_count = count(DB::table('candidates')
                                ->where('candidate_for','=',$candidate_for)
                                ->where('signed_by_lec','=','1')
                                ->where('province_id','=',$province_id)
                                ->where('district_id','=',$district_id)
                                ->get());

                $bmember_max = DB::table('pos_board_member')
                                ->where('province_code','=',$province_id)
                                ->where('district','=',$district_id)
                                ->first()->board_member;

                if($bmember_count == $bmember_max) {
                    $alert = 'LEC Failed Approved';
                } else {
                    $continue_access = true;
                }

                break;

            case 'Congressman':
                $congressman_count = count(DB::table('candidates')
                                ->where('candidate_for','=',$candidate_for)
                                ->where('signed_by_lec','=','1')
                                ->where('province_id','=',$province_id)
                                ->where('district_id','=',$district_id)
                                ->get());

                if($congressman_count == 1) {
                    $alert = 'LEC Failed Approved';
                } else {
                    $continue_access = true;
                }

                break;

            case 'HUC Congressman':
                $HUCcongressman_count = count(DB::table('candidates')
                                ->where('candidate_for','=',$candidate_for)
                                ->where('signed_by_lec','=','1')
                                ->where('province_id','=',$province_id)
                                ->where('district_id','=',$district_id)
                                ->get());

                if($HUCcongressman_count == 1) {
                    $alert = 'LEC Failed Approved';
                } else {
                    $continue_access = true;
                }

                break;

            case 'City Mayor':
                $region = DB::table('province')
                            ->where('province_code','=',$province_id)
                            ->first();

                if($region->region == 'NCR') {
                    $citymayor_count = count(DB::table('candidates')
                                    ->where('candidate_for','=',$candidate_for)
                                    ->where('signed_by_lec','=','1')
                                    ->where('province_id','=',$province_id)
                                    ->get());
                } else {
                    $citymayor_count = count(DB::table('candidates')
                                    ->where('candidate_for','=',$candidate_for)
                                    ->where('signed_by_lec','=','1')
                                    ->where('province_id','=',$province_id)
                                    ->where('city_id','=',$city_id)
                                    ->get());   
                }

                if($citymayor_count == 1) {
                    $alert = 'LEC Failed Approved';
                } else {
                    $continue_access = true;
                }

                break;

            case 'City Vice Mayor':
                $region = DB::table('province')
                            ->where('province_code','=',$province_id)
                            ->first();

                if($region->region == 'NCR') {
                    $cityvmayor_count = count(DB::table('candidates')
                                    ->where('candidate_for','=',$candidate_for)
                                    ->where('signed_by_lec','=','1')
                                    ->where('province_id','=',$province_id)
                                    ->get());
                } else {
                    $cityvmayor_count = count(DB::table('candidates')
                                    ->where('candidate_for','=',$candidate_for)
                                    ->where('signed_by_lec','=','1')
                                    ->where('province_id','=',$province_id)
                                    ->where('city_id','=',$city_id)
                                    ->get());   
                }

                if($cityvmayor_count == 1) {
                    $alert = 'LEC Failed Approved';
                } else {
                    $continue_access = true;
                }

                break;

            case 'City Councilor':
                $region = DB::table('province')
                            ->where('province_code','=',$province_id)
                            ->first();

                if($region->region == 'NCR') {
                    $citycouncilor_count = count(DB::table('candidates')
                                        ->where('candidate_for','=',$candidate_for)
                                        ->where('signed_by_lec','=','1')
                                        ->where('province_id','=',$province_id)
                                        ->where('district_id','=',$district_id)
                                        ->get());

                    $citycouncilor_max = DB::table('pos_city_councilor')
                                        ->where('province_code','=',$province_id)
                                        ->where('city','=',$region->lgu)
                                        ->where('distirct','=',$district_id)
                                        ->first()->city_councilor;
                } else {
                    if($district_id == null) {
                        $citycouncilor_count = count(DB::table('candidates')
                                        ->where('candidate_for','=',$candidate_for)
                                        ->where('signed_by_lec','=','1')
                                        ->where('province_id','=',$province_id)
                                        ->where('city_id','=',$city_id)
                                        ->get());

                        $citycouncilor_max = DB::table('pos_city_councilor')
                                        ->where('province_code','=',$province_id)
                                        ->where('city','=',$city_id)
                                        ->first()->city_councilor;
                    } else {
                        $citycouncilor_count = count(DB::table('candidates')
                                        ->where('candidate_for','=',$candidate_for)
                                        ->where('signed_by_lec','=','1')
                                        ->where('province_id','=',$province_id)
                                        ->where('city_id','=',$city_id)
                                        ->where('district_id','=',$district_id)
                                        ->get());

                        $citycouncilor_max = DB::table('pos_city_councilor')
                                        ->where('province_code','=',$province_id)
                                        ->where('city','=',$city_id)
                                        ->where('district','=',$district_id)
                                        ->first()->city_councilor;
                    }
                }

                if($citycouncilor_count == $citycouncilor_max) {
                    $alert = 'LEC Failed Approved';
                } else {
                    $continue_access = true;
                }

                break;

            case 'Municipal Mayor':
                $munmayor_count = count(DB::table('candidates')
                                    ->where('candidate_for','=',$candidate_for)
                                    ->where('signed_by_lec','=','1')
                                    ->where('province_id','=',$province_id)
                                    ->where('city_id','=',$city_id)
                                    ->where('district_id','=',$district_id)
                                    ->get());

                if($munmayor_count == 1) {
                    $alert = 'LEC Failed Approved';
                } else {
                    $continue_access = true;
                }

                break;

            case 'Municipal Vice Mayor':
                $munvmayor_count = count(DB::table('candidates')
                                    ->where('candidate_for','=',$candidate_for)
                                    ->where('signed_by_lec','=','1')
                                    ->where('province_id','=',$province_id)
                                    ->where('city_id','=',$city_id)
                                    ->where('district_id','=',$district_id)
                                    ->get());

                if($munvmayor_count == 1) {
                    $alert = 'LEC Failed Approved';
                } else {
                    $continue_access = true;
                }

                break;

            case 'Municipal Councilor':
                $muncouncilor_count = count(DB::table('candidates')
                                    ->where('candidate_for','=',$candidate_for)
                                    ->where('signed_by_lec','=','1')
                                    ->where('province_id','=',$province_id)
                                    ->where('city_id','=',$city_id)
                                    ->where('district_id','=',$district_id)
                                    ->get());

                $muncouncilor_max = DB::table('pos_municipal_councilor')
                                    ->where('province_code','=',$province_id)
                                    ->where('municipal_name','=',$city_id)
                                    ->first()->municipal_councilor;

                if($muncouncilor_count == $muncouncilor_max) {
                    $alert = 'LEC Failed Approved';
                } else {
                    $continue_access = true;
                }

                break;
        }

        if($continue_access) {
            $approve = DB::table('candidates')->where('id', $candidate_id)->update(['signed_by_lp' => '0', 'signed_by_lec' => '1']);
            if($approve) {
                $alert = 'Approved';
                DB::table('edit_logs')->insert([
                    'updated_candidate_id' => $candidate_id,
                    'isAdmin' => Auth::user()->isAdmin,
                    'action' => 'LEC Approve Candidate',
                    'updated_by_id' => Auth::user()->id,
                    'url' => \Request::fullUrl(),
                    'ip' => \Request::ip(),
                    'updated_at' => $date_now
                ]);
            }
            else {
                $alert = 'Fail';
            }
        }

        return $alert;
    }

    public function reject(Request $data_candidate) {
        date_default_timezone_set("Asia/Manila");
        $date_now = date("Y-m-d H:i:s");

        $candidate_id = $data_candidate->id;
        $reject = DB::table('candidates')->where('id', $candidate_id)->update(['signed_by_lp' => '2', 'signed_by_lec' => '2']);
        if($reject) {
            $alert = 'Rejected';
            if(Auth::user()->isAdmin == 1) {
                DB::table('edit_logs')->insert([
                    'updated_candidate_id' => $candidate_id,
                    'isAdmin' => Auth::user()->isAdmin,
                    'action' => 'HQ Reject Candidate',
                    'updated_by_id' => Auth::user()->id,
                    'url' => \Request::fullUrl(),
                    'ip' => \Request::ip(),
                    'updated_at' => $date_now
                ]);
            }
            else {
                DB::table('edit_logs')->insert([
                    'updated_candidate_id' => $candidate_id,
                    'isAdmin' => Auth::user()->isAdmin,
                    'action' => 'LEC Reject Candidate',
                    'updated_by_id' => Auth::user()->id,
                    'url' => \Request::fullUrl(),
                    'ip' => \Request::ip(),
                    'updated_at' => $date_now
                ]);
            }
        }
        else {
            $alert = 'Fail';
        }
        return $alert;
    }

    public function senator(){
        $senators = DB::table('candidates')
            ->where('candidate_for','Senator')
            ->where('signed_by_lp','!=',3)
            ->where('signed_by_lp','!=',2)
            ->get();
        return view('dashboard.screening.senator')->with('senators',$senators);
    }

    public function redirect(){
        return redirect()->action('ScreeningController@screening');
    }
    
}
