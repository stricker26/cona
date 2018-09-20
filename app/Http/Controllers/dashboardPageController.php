<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class dashboardPageController extends Controller
{
    //
    public function hq_dashboard() {
    	return view('dashboard.dashboard');
    }

    public function hq_pending() {
    	return view('dashboard.nomination.pending');
    }

    public function hq_approve() {
    	return view('dashboard.nomination.approve');
    }

    public function hq_reject() {
        return view('dashboard.nomination.reject');
    }

    public function lec_dashboard() {
        return view('lec.lec');
    }

    public function lec_candidates() {
        $candidates_db = DB::table('candidates')->get();
    	return view('lec.candidates', compact('candidates_db'));
    }
}
