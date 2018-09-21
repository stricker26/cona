<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class statCandidatesController extends Controller
{
    public function status(Request $request) {
    	$status = $request->statusData;
    	$data = explode(",", $status);
    	$status = $data[0];
    	$location = $data[1];

    	$candidates = DB::table('candidates')->where('signed_by_lp', $status)->get();

    	if(count($candidates)){
    		
    	} else {
    		$candidates = 'empty';
    	}
        
    	if($status == '0'){
    		return view('dashboard.status.pending', compact('candidates'));
    	} elseif($status == '1') {
    		return view('dashboard.status.approved', compact('candidates'));
    	} else {
    		return view('dashboard.status.rejected', compact('candidates'));
    	}
    }
}
