<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class LECController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function lec_dashboard() {
        $user_id = Auth::user()->id;
        $user = DB::table('lec')->where('user',$user_id)->orWhere('user',$user_id)->first();
        return view('lec.lec')->with('user',$user);
    }

    public function lec_profile(Request $request) {
        $user_id = $request->lec_edit_btn;
        $user = DB::table('lec')->where('user',$user_id)->orWhere('user',$user_id)->first();
        
    }

    public function lec_candidates() {
        $candidates_db = DB::table('candidates')->get();
    	return view('lec.candidates', compact('candidates_db'));
    }

    public static function lec_candidate($lec_id) {

        $query = DB::table('province AS pv')
            ->join('lec AS lc', 'pv.lec', '=', 'lc.id')
            ->select('lc.name')
            ->where('pv.province_code', '=', $lec_id)
            ->limit(1)
            ->get();

        $queryCity = DB::table('city AS ct')
            ->join('lec AS lc', 'ct.lec', '=', 'lc.id')
            ->select('lc.name')
            ->where('ct.province_code', '=', $lec_id)
            ->limit(1)
            ->get();

        $queryMunicipal = DB::table('municipality AS muni')
            ->join('lec AS lc', 'muni.lec', '=', 'lc.id')
            ->select('lc.name')
            ->where('muni.province_code', '=', $lec_id)
            ->limit(1)
            ->get();

        if(count($query) > 0) {
            return $query[0]->name;
        } else {
            if(count($queryCity)) {
                return $queryCity[0]->name;
            } else {
                if(count($queryMunicipal)) {
                     return $queryMunicipal[0]->name;
                }
            }
        }

        return 'No assigned LEC';

    }
}
