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
        
        $candidates = DB::table('candidates')->get();

        if(!count($candidates)){
            $candidates = 'empty';
        }
        
    	if($status == '0'){
            $arrayLocation = array();
            $arrayPosition = array();
            foreach($candidates as $candidate) {
                array_push($arrayPosition, $candidate->candidate_for);
            }

    		return view('dashboard.status.pending', compact('candidates'));
    	} elseif($status == '1') {
    		return view('dashboard.status.approved', compact('candidates'));
    	} else {
    		return view('dashboard.status.rejected', compact('candidates'));
    	}
    }
}
