<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class dashboardPageController extends Controller
{
   
    public function __construct() {
        $this->middleware('admin');
    }
         
    public function hq_dashboard() {
    	return view('dashboard.dashboard');
    }
    
    public function screening(Request $request) {
        $data_province = $request->dataProvince;
        $data_province = explode(",", $data_province);
        if($data_province === 'HUC'){
            $loc = DB::table('huc')->get()->where('province_code', '=', $data_province[0]);
            return $loc;
        } elseif($data_province === 'MUNICIPALITY'){
            $loc = DB::table('municipality')->get()->where('province_code', '=', $data_province[0]);
            return $loc;
        } elseif($data_province === 'DISTRICT'){
            $loc = DB::table('municipality')->get()->where('province_code', '=', $data_province[0]);
            return $loc;
        } elseif($data_province === 'CITY'){
            $loc = DB::table('city')->get()->where('province_code', '=', $data_province[0]);
            return $loc;
        }
    }

    //Get LEC user activity
    public static function lec_activity() {

        $query = DB::table('edit_logs AS log')
            ->join('candidates AS c', 'log.updated_candidate_id', '=', 'c.id')
            ->where('isAdmin', '=', 0)
            ->orderBy('log.id', 'DESC')
            ->get();

        $out = '';
        $cnt = 1;

        foreach ($query as $actions => $action) {

            $date = new \DateTime($action->updated_at);
            
            $out .= '<tr>';
                $out .= '<td>'. $cnt .'</td>';
                $out .= '<td>'. $action->firstname . ' ' . $action->middlename . ' ' . $action->lastname .'</td>';
                $out .= '<td>'. $action->candidate_for .'</td>';
                $out .= '<td>'. SELF::political_structure($action->candidate_for, $action->province_id, $action->district_id, $action->city_id) .'</td>';
                $out .= '<td>'. $action->action .'</td>';
                $out .= '<td>'. SELF::get_userID($action->updated_by_id) .'</td>';
                $out .= '<td>'. SELF::assigned_lec($action->updated_by_id) .'</td>';
                $out .= '<td>'. $action->ip .'</td>';
                $out .= '<td>'. $date->format('F d Y H:m:s') .'</td>';
            $out .= '</tr>';

            $cnt = $cnt + 1;

        }

        return $out;

    }

    public static function hq_activity() {

         $query = DB::table('edit_logs AS log')
            ->join('candidates AS c', 'log.updated_candidate_id', '=', 'c.id')
            ->where('isAdmin', '=', 1)
            ->orderBy('log.id', 'DESC')
            ->get();

        $out = '';
        $cnt = 1;

        foreach ($query as $actions => $action) {

            $date = new \DateTime($action->updated_at);
            
            $out .= '<tr>';
                $out .= '<td>'. $cnt .'</td>';
                $out .= '<td>'. $action->firstname . ' ' . $action->middlename . ' ' . $action->lastname .'</td>';
                $out .= '<td>'. $action->candidate_for .'</td>';
                $out .= '<td>'. SELF::political_structure($action->candidate_for, $action->province_id, $action->district_id, $action->city_id) .'</td>';
                $out .= '<td>'. $action->action .'</td>';
                $out .= '<td>'. SELF::get_userID($action->updated_by_id) .'</td>';
                $out .= '<td>'. SELF::hq_user($action->updated_by_id) .'</td>';
                $out .= '<td>'. $action->ip .'</td>';
                $out .= '<td>'. $date->format('F d Y H:m:s') .'</td>';
            $out .= '</tr>';

            $cnt = $cnt + 1;

        }

        return $out;

    }

    //Ge HQ user
    static function hq_user($id) {

        $query = DB::table('users')
            ->select('name')
            ->where('id', '=', $id)
            ->where('isAdmin', '=', 1)
            ->first();

        return $query->name;

    }

    //Get assigned LEC
    static function assigned_lec($id) {

        $query = DB::table('lec')
            ->select('name')
            ->where('user', '=', $id)
            ->orWhere('user_2', '=', $id)
            ->first();

        return $query->name;

    }

    //Get User ID
    static function get_userID($userid) {

        $query = DB::table('users')
            ->select('name')
            ->where('id', '=', $userid)
            ->get();

        return $query[0]->name;

    }

    //Political Structure Format
    static function political_structure($position, $province, $district, $city) {

        $query = DB::table('province')
            ->select('region', 'lgu', 'type')
            ->where('province_code', '=', $province)
            ->first();

        if($position == 'Governor' || $position == 'Vice Governor') {

            $location = $query->region . ', ' . $query->lgu;

        } elseif($position == 'Board Member' || $position == 'Congressman') {

            $location = $query->region . ', ' . $query->lgu . ', ' . $district;

        } elseif($query->type == 'HUC' && ($position == 'HUC Congressman' || $position == 'City Councilor')) {

            $location = $query->region . ', ' . $city . ', ' . $district;

        } elseif ($query->type == 'HUC' && ($position == 'City Mayor' || $position == 'City Vice Mayor')) {
            
            $location = $query->region . ', ' . $city;

        } elseif ($query->type == 'PROVINCE' && ($position == 'City Mayor' || $position == 'City Vice Mayor')) {
            
            $location = $query->region . ', ' . $query->lgu . ', ' . $city;

        } else {
            $location = $query->region . ', ' . $query->lgu . ', ' . $district . ', ' . $city;
        }

        return $location;

    }

    
}
