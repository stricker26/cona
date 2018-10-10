<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\CertificateController;
use DB;

class ExportController extends Controller
{
    public function export($position, $provinceCode, $type) {

    	$pos = str_replace("-", " ", $position);

        if($type == 'province') {

            $query = DB::table('candidates')
                ->select('id')
                ->where('province_id', '=', $provinceCode)
                ->where('candidate_for', '=', $pos)
                ->where('signed_by_lp', '=', 1)
                ->get();


        } elseif($type == 'national') {

            $query = DB::table('candidates')
                ->select('id')
                ->where('candidate_for', '=', $pos)
                ->where('signed_by_lp', '=', 1)
                ->get();

        } elseif($type == 'all') {

            $query = DB::table('candidates')
                ->select('id')
                ->where('signed_by_lp', '=', 1)
                ->where('candidate_for', '<>', 'Senator')
                ->get();

        } elseif($provinceCode == 'region') {

            $query = DB::table('candidates AS c')
                ->join('province AS p', 'c.province_id', '=', 'p.province_code')
                ->select('p.region', 'c.id', 'c.candidate_for')
                ->where('p.region', '=', $type)
                ->where('signed_by_lp', '=', 1)
                ->get();

        } elseif($provinceCode == 'province') {

            $query = DB::table('candidates')
                ->select('id')
                ->where('province_id', '=', $type)
                ->where('signed_by_lp', '=', 1)
                ->get();

        } else {

            $query = DB::table('candidates AS c')
                ->join('province AS p', 'c.province_id', '=', 'p.province_code')
                ->select('p.region', 'c.id', 'c.candidate_for')
                ->where('p.region', '=', $type)
                ->where('signed_by_lp', '=', 1)
                ->where('c.candidate_for', '=', $pos)
                ->get();

        }

        $ids = array();

    	foreach ($query as $candidates => $candidate) {
    		
    		$ids[] = $candidate->id;

    	}

    	return CertificateController::create($ids);

    }

    public function exportByID($id) {

    	$query = DB::table('candidates')->where('id', '=', $id)->get();

    	return CertificateController::create_view($query[0]->id, 'none', 'single');

    }
}
