<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LECController;
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
    	$data = DB::table('municipality as m')
            ->join('candidates as c', 'm.province_code', '=', 'c.province_id')
            ->select('m.*', DB::raw('(SELECT count(signed_by_lp) FROM candidates WHERE municipality = c.city_id AND signed_by_lp = 0 AND province_id = '. $code .') AS pending'))
            ->where('m.province_code', '=', $code)
            ->where('c.province_id', '=', $code)
            ->get();

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

        $lec = new LECController;

        //if($request->ajax()) {

            $provinceCode = $request->input('provinceCode');
            $requesType = $request->input('requesType');

            $mayor = array();
            $vmayor = array();
            $councilor = array();

            if($requesType == 'HUC' || $requesType == 'CC' || $requesType == 'MUNICIPAL') {
                $query = DB::table('candidates')
                    ->where('province_id', '=', $provinceCode)
                    ->where('signed_by_lp', '<>', 3)
                    ->get();
                if(count($query) > 0) {
                    foreach ($query as $rows => $row) {
                        if($row->candidate_for == 'City Mayor' || $row->candidate_for == 'Municipal Mayor') {
                            $mayor[] = array(
                                'id' => $row->id,
                                'name' => $row->firstname . ' ' . $row->middlename . ' ' . $row->lastname,
                                'status' => $row->signed_by_lp == 0 ? 'Pending' : $row->signed_by_lp
                            );
                            
                        } else if ($row->candidate_for == 'City Vice Mayor' || $row->candidate_for == 'Municipal Vice-Mayor') {
                            $vmayor[] = array(
                                'id' => $row->id,
                                'name' => $row->firstname . ' ' . $row->middlename . ' ' . $row->lastname,
                                'status' => $row->signed_by_lp == 0 ? 'Pending' : $row->signed_by_lp
                            );
                        } else if($row->candidate_for == 'City Councilor' || $row->candidate_for == 'Municipal Councilor') {
                            $councilor[] = array(
                                'id' => $row->id,
                                'name' => $row->firstname . ' ' . $row->middlename . ' ' . $row->lastname, 
                                'status' => $row->signed_by_lp == 0 ? 'Pending' : $row->signed_by_lp
                            );
                        } 
                    }
                    return response()->json(['mayor' => $mayor, 'vmayor' => $vmayor, 'councilor' => $councilor, 'lec' => $lec->lec_candidate($provinceCode)]);
                } else {
                    return response()->json(['mayor' => $mayor, 'vmayor' => $vmayor, 'councilor' => $councilor, 'lec' => $lec->lec_candidate($provinceCode), 'pass' => $requesType]);
                }

            }  

        // }  else {

        //     return response()->json(['warning' => 'Invalid request.']);

        // }

    }

    public function districtCandidate(Request $request) {

        $lec = new LECController;

        if($request->ajax()) {
            
            $provinceCode = $request->input('provinceCode');
            $district = $request->input('district');

            $query = DB:: table('candidates')
                ->where('province_id', '=', $provinceCode)
                ->where('district_id', '=', $district)
                ->where('signed_by_lp', '<>', '3')
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
                            'status' => $row->signed_by_lp == 0 ? 'Pending' : $row->signed_by_lp
                        );
                    } else if($row->candidate_for == 'City Councilor') {
                        $councilor[] = array(
                            'id' => $row->id,
                            'name' => $row->firstname . ' ' . $row->middlename . ' ' . $row->lastname, 
                            'status' => $row->signed_by_lp == 0 ? 'Pending' : $row->signed_by_lp
                        );
                    } else if ($row->candidate_for == 'Provincial Board Member') {
                            $bmember[] = array(
                            'id' => $row->id,
                            'name' => $row->firstname . ' ' . $row->middlename . ' ' . $row->lastname,
                            'status' => $row->signed_by_lp == 0 ? 'Pending' : $row->signed_by_lp
                        );
                    } else if ($row->candidate_for == 'Congressman') {
                        $prvcongressman[] = array(
                            'id' => $row->id,
                            'name' => $row->firstname . ' ' . $row->middlename . ' ' . $row->lastname,
                            'status' => $row->signed_by_lp == 0 ? 'Pending' : $row->signed_by_lp
                        );
                    }
                }
                return response()->json(['congressman' => $congressman, 'councilor' => $councilor, 'provCongressman' => $prvcongressman, 'bmember' => $bmember, 'lec' => $lec->lec_candidate($provinceCode)]);
            } else {
                return response()->json(['congressman' => $congressman, 'councilor' => $councilor, 'provCongressman' => $prvcongressman, 'bmember' => $bmember, 'lec' => $lec->lec_candidate($provinceCode)]);
            }      

        } else {

            return response()->json(['warning' => 'Invalid request.']);

        }

    }

    public function governor(Request $request) {

        $lec = new LECController;

        if($request->ajax()) {

            $provinceCode = $request->input('provinceCode');
            $requesType = $request->input('requesType');

            if($requesType == 'PROVINCE') {

                $query = DB::table('candidates')
                    ->where('province_id', '=', $provinceCode)
                    ->where('signed_by_lp', '<>', '3')
                    ->get();

                $governor = array();
                $vgovernor = array();

                if(count($query) > 0) {
                    foreach ($query as $rows => $row) {
                        if($row->candidate_for == 'Governor') {
                            $governor[] = array(
                                'id' => $row->id,
                                'name' => $row->firstname . ' ' . $row->middlename . ' ' . $row->lastname,
                                'status' => $row->signed_by_lp == 0 ? 'Pending' : $row->signed_by_lp
                            );
                            
                        } else if ($row->candidate_for == 'Vice-Governor') {
                            $vgovernor[] = array(
                                'id' => $row->id,
                                'name' => $row->firstname . ' ' . $row->middlename . ' ' . $row->lastname,
                                'status' => $row->signed_by_lp == 0 ? 'Pending' : $row->signed_by_lp
                            );
                        }
                    }
                    return response()->json(['governor' => $governor, 'vgovernor' => $vgovernor, 'lec' => $lec->lec_candidate($provinceCode)]);
                } else {
                    return response()->json(['governor' => $governor, 'vgovernor' => $vgovernor, 'lec' => $lec->lec_candidate($provinceCode)]);
                }

            } else {

                return response()->json(['warning' => 'Invalid request.']); 

            }

        } else {

            return response()->json(['warning' => 'Invalid Request']);

        }

    }


}
