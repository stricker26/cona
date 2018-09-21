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
            $governor = array();
            $vice_governor = array();
            $board_members = array();
            $congressman = array();
            $HUC_congressman = array();
            $city_mayor = array();
            $city_vice_mayor = array();
            $city_councilor = array();
            $municipal_mayor = array();
            $municipal_vice_mayor = array();
            $municipal_councilor = array();
            $arrayPosition = array();
            foreach($candidates as $candidate) {
                if(!in_array($candidate->candidate_for, $arrayPosition)) {
                    array_push($arrayPosition, $candidate->candidate_for);
                }

                if($candidate->candidate_for === "Governor") {
                    array_push($governors, $candidate->province_id);
                } elseif($candidate->candidate_for === "Vice-Governor") {
                    array_push($vice_governors, $candidate->province_id);
                } elseif($candidate->candidate_for === "Provincal Board Member") {
                    array_push($board_members, $candidate->province_id);
                } elseif($candidate->candidate_for === "Congressman") {
                    array_push($congressman, $candidate->district_id);
                } elseif($candidate->candidate_for === "HUC Congressman") {
                    array_push($HUC_congressman, $candidate->district_id);
                } elseif($candidate->candidate_for === "City Mayor") {
                    array_push($city_mayor, $candidate->city_id);
                } elseif($candidate->candidate_for === "City Vice Mayor") {
                    array_push($city_vice_mayor, $candidate->city_id);
                } elseif($candidate->candidate_for === "City Councilor") {
                    array_push($city_councilor, $candidate->city_id);
                } elseif($candidate->candidate_for === "Municipal Mayor") {
                    array_push($municipal_mayor, $candidate->province_id);
                } elseif($candidate->candidate_for === "Municipal Vice Mayor") {
                    array_push($municipal_vice_mayor, $candidate->province_id);
                } elseif($candidate->candidate_for === "Municipal Councilor") {
                    array_push($municipal_councilor, $candidate->province_id);
                }
            }

    		return view('dashboard.status.pending', compact('candidates'));
    	} elseif($status == '1') {
    		return view('dashboard.status.approved', compact('candidates'));
    	} else {
    		return view('dashboard.status.rejected', compact('candidates'));
    	}
    }
}
