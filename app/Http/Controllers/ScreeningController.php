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

    public function candidate(Request $request) {

        if($request->ajax()) {

            $provinceCode = $request->input('provinceCode');
            $requesType = $request->input('requesType');

            if($requesType == 'HUC') {
                $query = DB::table('candidates')
                    ->where('province_id', '=', $provinceCode)
                    ->get();

                //$mayor = array();

                foreach ($query as $rows => $row) {
                    if($row->candidate_for == 'City Mayor') {
                        $mayor[] = $row->firstname . ' ' . $row->middlename . ' ' .$row->lastname;
                    } elseif ($row->candidate_for == 'City Vice Mayor') {
                        $vmayor[] = $row->firstname . ' ' . $row->middlename . ' ' .$row->lastname;
                    } else {
                        $councilor[] = $row->firstname . ' ' . $row->middlename . ' ' .$row->lastname;
                    }
                }

                return response()->json(['mayor' => $mayor, 'vmayor' => $vmayor, 'councilor' => $councilor]);

            } else {

            }

        }

    }
}
