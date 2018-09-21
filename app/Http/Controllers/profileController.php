<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class profileController extends Controller
{
    public function profile(Request $request) {
        // $profile = $request->screening_btn;
        $candidate = DB::table('candidates')->first();

        $province = DB::table('province')
                        ->select('lgu')
                        ->where('province_code','=',$candidate->province_id)
                        ->first();

        $district = DB::table('municipality')
                        ->select('municipality','district')
                        ->where('province_code','=',$candidate->province_id)
                        ->first();

        $city = DB::table('city')
                    ->select('city')
                    ->where('province_code','=',$candidate->province_id)
                    ->first();

        $cos = DB::table('chief_of_staff')->where('cos_id','=',$candidate->cos_id)->first();

        return view('dashboard.screening.profile', compact('candidate','province','district','city','cos'));
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
            'sma' => $data_candidate->fb.','.$data_candidate->twitter.','.$data_candidate->ig.','.$data_candidate->website,
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

    public function redirect(){
        return redirect()->action('ScreeningController@screening');
    }
}
