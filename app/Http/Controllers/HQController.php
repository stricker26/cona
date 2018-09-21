<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HQController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    
    public function admin() {

        return view('hq.admin');

    }
}
