<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LECController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function lec_dashboard() {
        return view('lec.lec');
    }

    public function lec_candidates() {
        $candidates_db = DB::table('candidates')->get();
    	return view('lec.candidates', compact('candidates_db'));
    }
}