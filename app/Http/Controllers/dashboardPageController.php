<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class dashboardPageController extends Controller
{
   
    public function __construct() {
        $this->middleware('admin');
    }
         
    public function hq_dashboard() {
    	return view('dashboard.dashboard');
    }
    
    public function screening(Request $request) {
        $data_province = $request->dataProvince;
        $data_province = explode(",", $data_province);
        if($data_province === 'HUC'){
            $loc = DB::table('huc')->get()->where('province_code', '=', $data_province[0]);
            return $loc;
        } elseif($data_province === 'MUNICIPALITY'){
            $loc = DB::table('municipality')->get()->where('province_code', '=', $data_province[0]);
            return $loc;
        } elseif($data_province === 'DISTRICT'){
            $loc = DB::table('municipality')->get()->where('province_code', '=', $data_province[0]);
            return $loc;
        } elseif($data_province === 'CITY'){
            $loc = DB::table('city')->get()->where('province_code', '=', $data_province[0]);
            return $loc;
        }
    }
}
