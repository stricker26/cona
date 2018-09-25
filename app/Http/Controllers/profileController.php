<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class profileController extends Controller
{
    public function profile(Request $request) {
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
                        ->first()->municipality;
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

    public function sent(Request $data_candidate) {
        $candidate_id = $data_candidate->id;
        date_default_timezone_set("Asia/Manila");
        $date_now = date("Y-m-d h:i:s");

        $data_update = array(
            'address' => $data_candidate->address,
            'birthdate' => $data_candidate->birthdate,
            'email' => $data_candidate->email,
            'firstname' => $data_candidate->firstname,
            'lastname' => $data_candidate->lastname,
            'middlename' => $data_candidate->middlename,
            'incumbent' => $data_candidate->incumbent,
            'mobile' => $data_candidate->mobile,
            'landline' => $data_candidate->landline,
            'sma' => '{"facebook":"'.$data_candidate->fb.'","twitter":"'.$data_candidate->twitter.'","instagram":"'.$data_candidate->ig.'","website":"'.$data_candidate->website.'"}',
            'updated_at' => $date_now
        );

        $update = DB::table('candidates')->where('id','=',$candidate_id)->update($data_update);

        if($update) {
            $alert = 'Success';
        } else {
            $alert = 'Fail';
        }

        
        return response()->json(['response'=> $alert]);
    }

    public function approve(Request $data_candidate) {
        //$candidate_id = $data_candidate->id;
        $candidate_id = 9;
        $approve = DB::table('candidates')->where('id', $candidate_id)->update(['signed_by_lp' => '1']);
        if($approve) {
            $alert = 'Approved';
        }
        else {
            $alert = 'Fail';
        }
        return $alert;
    }

    public function reject(Request $data_candidate) {
        //$candidate_id = $data_candidate->id;
        $candidate_id = 9;
        $reject = DB::table('candidates')->where('id', $candidate_id)->update(['signed_by_lp' => '2']);
        if($reject) {
            $alert = 'Rejected';
        }
        else {
            $alert = 'Fail';
        }
        return $alert;
    }


    public function redirect(){
        return redirect()->action('ScreeningController@screening');
    }
}
