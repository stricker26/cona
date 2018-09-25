<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class ScreeningController extends Controller
{
    public function screening() {
    	return view('dashboard.screening.screening');
    }

    public function huc($code) {
    	$data = DB::table('huc')->where('province_code', '=', $code)->orWhere('parent_province_code', '=', $code)->get();
    	return $data;
    }

    public function municipality($code) {
    	$data = DB::table('municipality')->get()->where('province_code', '=', $code);
    	return $data;
    }

    public function district($code) {
    	$data = DB::table('municipality')->get()->where('province_code', '=', $code);
    	return $data;
    }

    public function city($code) {
    	$data = DB::table('city')->get()->where('province_code', '=', $code);
    	return $data;
    }

    public function region($code) {
        if ($code == 'NCR') {
            $data = DB::table('province')->get()->where('region', '=', $code);
        }
        else {
            $data = DB::table('province')->get()->where('region', '=', $code)->where('type', '!=', 'HUC');
        }
        return $data;
    }

    public function table($code) {
    	$data = DB::table('province')->get()->where('region', '=', $code);
    	if (count($data) == 0) {
	    	$data = DB::table('district')->get()->where('province_code', '=', $code);
	    	if (count($data) == 0) {
	    		$data = DB::table('city')->get()->where('province_code', '=', $code);
	    		if (count($data) == 0) {
	    			$data = '';
	    		}
	    	}
	    }
		return $data;
    }

    public function cc($code) {
        return null;
    }

    //Get City/Municipality Candidate
    public function candidate(Request $request) {

        if($request->ajax()) {

            $provinceCode = $request->input('provinceCode');
            $requesType = $request->input('requesType');

            $mayor = array();
            $vmayor = array();
            $councilor = array();

            if($requesType == 'HUC' || $requesType == 'CC' || $requesType == 'MUNICIPAL') {
                $query = DB::table('candidates')
                    ->where('province_id', '=', $provinceCode)
                    ->get();
                if(count($query) > 0) {
                    foreach ($query as $rows => $row) {
                        if($row->candidate_for == 'City Mayor') {
                            $mayor[] = array(
                                'id' => $row->id,
                                'name' => $row->firstname . ' ' . $row->middlename . ' ' . $row->lastname,
                                'status' => is_null($row->signed_by_lp) ? 'Pending' : $row->signed_by_lp
                            );
                            
                        } else if ($row->candidate_for == 'City Vice Mayor') {
                            $vmayor[] = array(
                                'id' => $row->id,
                                'name' => $row->firstname . ' ' . $row->middlename . ' ' . $row->lastname,
                                'status' => is_null($row->signed_by_lp) ? 'Pending' : $row->signed_by_lp
                            );
                        } else if($row->candidate_for == 'City Councilor') {
                            $councilor[] = array(
                                'id' => $row->id,
                                'name' => $row->firstname . ' ' . $row->middlename . ' ' . $row->lastname, 
                                'status' => is_null($row->signed_by_lp) ? 'Pending' : $row->signed_by_lp
                            );
                        }
                    }
                    return response()->json(['mayor' => $mayor, 'vmayor' => $vmayor, 'councilor' => $councilor]);
                } else {
                    return response()->json(['mayor' => $mayor, 'vmayor' => $vmayor, 'councilor' => $councilor]);
                }

            }  

        }

    }

    public function districtCandidate(Request $request) {

        if($request->ajax()) {
            
            $provinceCode = $request->input('provinceCode');
            $district = $request->input('district');

            $query = DB:: table('candidates')
                ->where('province_id', '=', $provinceCode)
                ->where('district_id', '=', $district)
                ->get();

            $congressman = array();
            $councilor = array();
            $bmember = array();
            $prvcongressman = array();

            if(count($query) > 0) {
                foreach($query as $rows => $row) {
                    if($row->candidate_for == 'HUC Congressman') {
                        $congressman[] = array(
                            'id' => $row->id,
                            'name' => $row->firstname . ' ' . $row->middlename . ' ' . $row->lastname,
                            'status' => is_null($row->signed_by_lp) ? 'Pending' : $row->signed_by_lp
                        );
                    } else if($row->candidate_for == 'City Councilor') {
                        $councilor[] = array(
                            'id' => $row->id,
                            'name' => $row->firstname . ' ' . $row->middlename . ' ' . $row->lastname, 
                            'status' => is_null($row->signed_by_lp) ? 'Pending' : $row->signed_by_lp
                        );
                    } else if ($row->candidate_for == 'Provincial Board Member') {
                            $bmember[] = array(
                            'id' => $row->id,
                            'name' => $row->firstname . ' ' . $row->middlename . ' ' . $row->lastname,
                            'status' => is_null($row->signed_by_lp) ? 'Pending' : $row->signed_by_lp
                        );
                    } else if ($row->candidate_for == 'Congressman') {
                        $prvcongressman[] = array(
                            'id' => $row->id,
                            'name' => $row->firstname . ' ' . $row->middlename . ' ' . $row->lastname,
                            'status' => is_null($row->signed_by_lp) ? 'Pending' : $row->signed_by_lp
                        );
                    }
                }
                return response()->json(['congressman' => $congressman, 'councilor' => $councilor, 'provCongressman' => $prvcongressman, 'bmember' => $bmember]);
            } else {
                return response()->json(['congressman' => $congressman, 'councilor' => $councilor, 'provCongressman' => $prvcongressman, 'bmember' => $bmember]);
            }      

        } else {

            return response()->json(['warning' => 'Invalid request.']);

        }

    }

    public function governor(Request $request) {

        if($request->ajax()) {

            $provinceCode = $request->input('provinceCode');
            $requesType = $request->input('requesType');

            if($requesType == 'PROVINCE') {

                $query = DB::table('candidates')
                    ->where('province_id', '=', $provinceCode)
                    ->get();

                $governor = array();
                $vgovernor = array();

                if(count($query) > 0) {
                    foreach ($query as $rows => $row) {
                        if($row->candidate_for == 'Governor') {
                            $governor[] = array(
                                'id' => $row->id,
                                'name' => $row->firstname . ' ' . $row->middlename . ' ' . $row->lastname,
                                'status' => is_null($row->signed_by_lp) ? 'Pending' : $row->signed_by_lp
                            );
                            
                        } else if ($row->candidate_for == 'Vice-Governor') {
                            $vgovernor[] = array(
                                'id' => $row->id,
                                'name' => $row->firstname . ' ' . $row->middlename . ' ' . $row->lastname,
                                'status' => is_null($row->signed_by_lp) ? 'Pending' : $row->signed_by_lp
                            );
                        }
                    }
                    return response()->json(['governor' => $governor, 'vgovernor' => $vgovernor]);
                } else {
                    return response()->json(['governor' => $governor, 'vgovernor' => $vgovernor]);
                }

            } else {

                return response()->json(['warning' => 'Invalid request.']); 

            }

        } else {

            return response()->json(['warning' => 'Invalid Request']);

        }

    }


}
