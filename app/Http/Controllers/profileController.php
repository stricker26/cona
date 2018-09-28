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

        if($candidate->candidate_for === 'Senator') {
            $province = (object) array(
                'lgu' => 'Philippines',
                'type'=> 'Nation'
            );
            
            $municipality = null;
            $district = null;
            $city = null;
        } else {
            $province = DB::table('province')
                            ->select('lgu','type')
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

        $province = DB::table('province')
                        ->select('lgu','type')
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
        $date_now = date("Y-m-d h:i:s");

        if(isset($data_candidate->cos_name)) {
            $data_update_cos = array(
                'name' => $data_candidate->cos_name,
                'relationship' => $data_candidate->cos_relationship,
                'address' => $data_candidate->cos_address,
                'contact' => $data_candidate->cos_contact,
                'email' => $data_candidate->cos_email
            );
            $cos_id = DB::table('candidates')->where('id',$candidate_id)->first();
            $update_cos = DB::table('chief_of_staff')->where('cos_id',$candidate->cos_id)->update($data_update_cos);

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
        $date_now = date("Y-m-d h:i:s");

        $candidate_id = $data_candidate->id;
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
        return $alert;
    }

    public function approve_lec(Request $data_candidate) {
        date_default_timezone_set("Asia/Manila");
        $date_now = date("Y-m-d h:i:s");

        $candidate_id = $data_candidate->id;
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
        return $alert;
    }

    public function reject(Request $data_candidate) {
        date_default_timezone_set("Asia/Manila");
        $date_now = date("Y-m-d h:i:s");

        $candidate_id = $data_candidate->id;
        $reject = DB::table('candidates')->where('id', $candidate_id)->update(['signed_by_lp' => '2', 'signed_by_lec' => '2']);
        if($reject) {
            $alert = 'Rejected';
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
            $alert = 'Fail';
        }
        return $alert;
    }

    public function reject_lec(Request $data_candidate) {
        date_default_timezone_set("Asia/Manila");
        $date_now = date("Y-m-d h:i:s");

        $candidate_id = $data_candidate->id;
        $reject = DB::table('candidates')->where('id', $candidate_id)->update(['signed_by_lec' => '2']);
        if($reject) {
            $alert = 'Rejected';
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
        else {
            $alert = 'Fail';
        }
        return $alert;
    }

    public function senator(){
        $senators = DB::table('candidates')->where('candidate_for','Senator')->get();
        return view('dashboard.screening.senator')->with('senators',$senators);
    }

    public function redirect(){
        return redirect()->action('ScreeningController@screening');
    }
    
}
