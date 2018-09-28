<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Session;
use App\Candidate;
use DB;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        return view('home');

    }

    public function register(Request $request) {

        $rules = array(
            'firstname' => 'required',
            'lastname' => 'required',
            'birthmonth' => 'required',
            'birthday' => 'required',
            'birthyear' => 'required',
            'address' => 'required',
            'email' => 'required|email|unique:candidates',
            'mobile' => 'required',
            'position' => 'required',
        );

        $validator = Validator::make(Input::all(), $rules);

        if($validator->fails()) {

            return response()->json(['warning' => 'Fields with (*) are mandatory.']);

        } else {

            $cos_id = strftime(time());

            $smaObj = array(
                'facebook' => $request->input('facebook'),
                'twitter' => $request->input('twitter'),
                'instagram' => $request->input('instagram'),
                'website' => $request->input('website'),
            );

            $sma = json_encode($smaObj);

            if(empty($request->input('city'))) {
                $city = $request->input('huc_city');
            } else {
                $city = $request->input('city');
            }

            if($request->input('position') == 'Senator') {
                $signed_by_lec = '3';
                $signed_by_lp = '0';
            } else {
                $signed_by_lec = '0';
                $signed_by_lp = '3';
            }

            $candidate = Candidate::create([
                'firstname' => $request->input('firstname'),
                'middlename' => $request->input('middlename'),
                'lastname' => $request->input('lastname'),
                'birthdate' => $request->input('birthyear') . '-' . $request->input('birthmonth') . '-' . $request->input('birthday'),
                'address' => $request->input('address'),
                'email' => $request->input('email'),
                'landline' => $request->input('landline'),
                'mobile' => $request->input('mobile'),
                'candidate_for' => $request->input('position'),
                'sma' => $sma,
                'province_id' => $request->input('province'),
                'district_id' => $request->input('district'),
                'city_id' => $city,
                'signed_by_lec' => $signed_by_lec,
                'signed_by_lp' => $signed_by_lp,
                'cos_id' => $cos_id,
            ]);

            $query = DB::table('chief_of_staff')->insertGetId([
                'cos_id' => $cos_id,
                'name' => $request->input('cos_name'),
                'relationship' => $request->input('relation'),
                'position' => $request->input('cos_position'),
                'address' => $request->input('cos_address'),
                'contact' => $request->input('cos_contact'),
                'email' => $request->input('cos_email'),
            ]);

            return response()->json(['success' => 'Successfully Registered!!!']);

        }

    }
}
