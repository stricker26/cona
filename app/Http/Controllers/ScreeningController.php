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
    	$data = DB::table('huc')->get()->where('province_code', '=', $code);
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
