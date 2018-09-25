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
}
