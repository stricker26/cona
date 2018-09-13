<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class GeoLocationController extends Controller
{
    
	public static function getProvince() {

		$query = DB::table('province')
			->select('code', 'description')
			->get();

		$out = '';

		foreach ($query as $rows => $row) {

			$out .= '<option value="'. $row->code .'">'. $row->description .'</option>';	
		
		}

		return $out;

	}

	public function location(Request $request) {

		if($request->ajax()) {

			$requestType = $request->input('requestType');
			$requestValue = $request->input('requestValue');
			$out = '';

			if($requestType == 'district') {

				$query = DB::table('district')
					->select('province_code', 'description')
					->where('province_code', '=', $requestValue)
					->get();

				$out .= '<option value="">Select District <span>*</span></option>';

				foreach ($query as $rows => $row) {

					$out .= '<option value="'. $row->province_code .'">'. $row->description .'</option>';	
				}

			} else {

				$query = DB::table('city')
					->select('code', 'description')
					->where('province_code', '=', $requestValue)
					->get();

				$out .= '<option value="">Select City <span>*</span></option>';

				foreach ($query as $rows => $row) {

					$out .= '<option value="'. $row->code .'">'. $row->description .'</option>';	
				}

			}

			return $out;

		}
	}

}
