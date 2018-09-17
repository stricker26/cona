<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class ScreeningController extends Controller
{
    public function screening() {
    	$province = DB::table('province')->get();
    	return view('dashboard.screening.screening', compact('province'));
    }

    public function table($province_code) {
    	$data = DB::table('district')->get()->where('province_code', '=', $province_code);
		return $data;
    }
}
