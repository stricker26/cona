<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        return view('home');

    }

    public function admin() {

        return view('hq.admin');

    }

    public function register(Request $request) {

        $rules = array(
            'firstname' => 'required',
            'lastname' => 'required',
            'birthmonth' => 'required',
            'birthday' => 'required',
            'birthyear' => 'required',
            'address' => 'required',
            'email' => 'required|email',
            'mobile' => 'required',
            'position' => 'required',
            'province' => 'required',
            'district' => 'required',
            'city' => 'required',
        );

        $validator = Validator::make(Input::all(), $rules);

        if($validator->fails()) {

           Session::flash('warning', 'Please fill out all required fields.');
           return redirect()->back(); 

        } else {

        }

    }
}
