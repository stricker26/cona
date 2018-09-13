<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class dashboardPageController extends Controller
{
    //
    public function dashboard() {
    	return view('dashboard.dashboard');
    }

    public function pending() {
    	return view('dashboard.nomination.pending');
    }

    public function approve() {
    	return view('dashboard.nomination.approve');
    }

    public function reject() {
    	return view('dashboard.nomination.reject');
    }
}
