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
}
