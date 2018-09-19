<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class GeoLocationController extends Controller
{

	public static function getRegion() {

		$query = DB::table('province')
			->select('region')
			->distinct('region')
			->get();

		$out = '';

		foreach ($query as $rows => $row) {

			$out .= '<option value="'. $row->region .'">'. $row->region .'</option>';	
		
		}

		return $out;

	}

	public function location(Request $request) {

		if($request->ajax()) {

			$requestType = $request->input('requestType');
			$requestValue = $request->input('requestValue');
			$out = '';

			switch ($requestType) {
				case 'huc_province':
					
					$query = DB::table('province')
						->select('lgu', 'province_code')
						->where('region', '=', $requestValue)
						->where('type', '=', 'HUC')
						->get();

					$out = '';

					$out .= '<option value="">Select Province <span>*</span></option>';

					foreach ($query as $rows => $row) {

						$out .= '<option value="'. $row->province_code .'">'. $row->lgu .'</option>';	
					
					}

				break;

				case 'province':

					$query = DB::table('city AS ct')
						->join('province AS pv', 'ct.province_code', '=', 'pv.province_code')
						->select('pv.lgu', 'ct.province_code')
						->where('ct.region', '=', $requestValue)
						->groupBy('ct.province_code', 'pv.lgu')
						->get();


					$out .= '<option value="">Select Province <span>*</span></option>';

					foreach ($query as $rows => $row) {

						$out .= '<option value="'. $row->province_code .'">'. $row->lgu .'</option>';	
					
					}

				break;

				case 'huc_city':

					$query = DB::table('huc')
						->select('city')
						->where('huc_province_code', '=', $requestValue)
						->distinct('city')
						->get();

					$out .= '<option value="">Select City <span>*</span></option>';

					foreach ($query as $rows => $row) {

						$out .= '<option value="'. $row->city .'">'. $row->city .'</option>';	
					}

				break;

				case 'huc_district':

					$query = DB::table('huc')
						->select('district')
						->where('province_code', '=', $requestValue)
						->get();

					$out .= '<option value="">Select District <span>*</span></option>';

					foreach ($query as $rows => $row) {

						$out .= '<option value="'. $row->district .'">'. $row->district .'</option>';	
					}

				break;

				case 'district':

					$query = DB::table('municipality')
						->select('district', 'province_code')
						->where('province_code', '=', $requestValue)
						->distinct('district')
						->get();

					$out .= '<option value="">Select District <span>*</span></option>';

					foreach ($query as $rows => $row) {

						$out .= '<option data-province="'. $row->province_code .'" value="'. $row->district .'">'. $row->district .'</option>';	
					}

				break;

				case 'city':

					$provinceCode = $request->input('provinceCode');
					$query = DB::table('municipality')
						->select('municipality')
						->where('district', '=', $requestValue)
						->where('province_code', '=', $provinceCode)
						->distinct('municipality')
						->get();

					$out .= '<option value="">Select Municipality <span>*</span></option>';

					foreach ($query as $rows => $row) {

						$out .= '<option value="'. $row->municipality .'">'. $row->municipality .'</option>';	
					}

				break;

				case 'component_city':

					$query = DB::table('city')
						->select('city')
						->where('province_code', '=', $requestValue)
						->distinct('city')
						->get();

					$out .= '<option value="">Select City <span>*</span></option>';

					foreach ($query as $rows => $row) {

						$out .= '<option value="'. $row->city .'">'. $row->city .'</option>';	
					}

				break;
				
				default:
					# code...
				break;
			}

			return $out;

		}
	}

}
