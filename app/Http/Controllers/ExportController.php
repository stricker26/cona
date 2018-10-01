<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\CertificateController;
use DB;

class ExportController extends Controller
{
    public function export($position, $province) {

    	$pos = str_replace("-", " ", $position);

    	$query = DB::table('candidates')
    		->select('id')
    		->where('province_id', '=', $province)
    		->where('candidate_for', '=', $pos)
    		->where('signed_by_lp', '=', 1)
    		->get();

    	$ids = array();

    	foreach ($query as $candidates => $candidate) {
    		
    		$ids[] = $candidate->id;

    	}

    	return CertificateController::create($ids);

    }

    public function exportByID($id) {

    	$query = DB::table('candidates')->where('id', '=', $id)->get();

    	return CertificateController::create($query[0]->id);

    }
}
