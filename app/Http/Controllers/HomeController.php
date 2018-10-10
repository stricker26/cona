<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Session;
use App\Candidate;
use DB;
use Auth;

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
            'mobile' => 'required',
            'position' => 'required',
        );

        $validator = Validator::make(Input::all(), $rules);

        if($validator->fails()) {

            return response()->json(['warning' => 'Fields with (*) are mandatory.']);

        } else {

            if(Candidate::where('mobile', $request->mobile)->first()) {

                return response()->json(['warning' => 'Sorry you have already a record to our database.']);

            } else {

                $cos_id = strftime(time());
                
                $continue_access = false;
                $candidate_for = $request->input('position');
                $province_id = $request->input('province');
                $district_id = $request->input('district');                
                if(empty($request->input('city'))) {
                    $city_id = $request->input('huc_city');
                } else {
                    $city_id = $request->input('city');
                }

                switch ($candidate_for) {
                    case 'Senator':
                        $senator_count = count(DB::table('candidates')
                                        ->where('candidate_for','=',$candidate_for)
                                        ->where('signed_by_lec','=','1')
                                        ->get());
                        
                        //maximum senator in a party is 12
                        if($senator_count == 12) {
                            return response()->json(['warning' => 'Maximum number for Senatorial position is reached.']);
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
                            return response()->json(['warning' => 'Maximum number for Governor position is reached.']);
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
                            return response()->json(['warning' => 'Maximum number for Vice Governor position is reached.']);
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
                            return response()->json(['warning' => 'Maximum number for Board Member position is reached.']);
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
                            return response()->json(['warning' => 'Maximum number for Congressman position is reached.']);
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
                            return response()->json(['warning' => 'Maximum number for HUC Congressman position is reached.']);
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
                            return response()->json(['warning' => 'Maximum number for City Mayor position is reached.']);
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
                            return response()->json(['warning' => 'Maximum number for City Vice Mayor position is reached.']);
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
                            return response()->json(['warning' => 'Maximum number for City Councilor position is reached.']);
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
                            return response()->json(['warning' => 'Maximum number for Municipal Mayor position is reached.']);
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
                            return response()->json(['warning' => 'Maximum number for Municipal Vice Mayor position is reached.']);
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
                            return response()->json(['warning' => 'Maximum number for Municipal Councilor position is reached.']);
                        } else {
                            $continue_access = true;
                        }

                        break;
                }

                if($continue_access) {
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
                        'signed_by_lec' => 0,
                        'signed_by_lp' => 3,
                        'cos_id' => $cos_id,
                    ])->id;

                    $query = DB::table('chief_of_staff')->insertGetId([
                        'cos_id' => $cos_id,
                        'name' => $request->input('cos_name'),
                        'relationship' => $request->input('relation'),
                        'position' => $request->input('cos_position'),
                        'address' => $request->input('cos_address'),
                        'contact' => $request->input('cos_contact'),
                        'email' => $request->input('cos_email'),
                    ]);

                    date_default_timezone_set("Asia/Manila");
                    $date_now = date("Y-m-d H:i:s");
                    if(Auth::check()) {
                        DB::table('edit_logs')->insert([
                            'updated_candidate_id' => $candidate,
                            'isAdmin' => Auth::user()->isAdmin,
                            'action' => 'Nominate Candidate',
                            'updated_by_id' => Auth::user()->id,
                            'url' => \Request::fullUrl(),
                            'ip' => \Request::ip(),
                            'updated_at' => $date_now
                        ]);
                        
                    } else {
                        DB::table('edit_logs')->insert([
                            'updated_candidate_id' => $candidate,
                            'isAdmin' => null,
                            'action' => 'Nominate Candidate',
                            'updated_by_id' => null,
                            'url' => \Request::fullUrl(),
                            'ip' => \Request::ip(),
                            'updated_at' => $date_now
                        ]);
                    }

                    return response()->json(['success' => 'Successfully Registered!!!']);
                }

            }

        }

    }

    public function denied() {

        return view('access');

    }
}
