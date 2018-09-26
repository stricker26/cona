<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class statCandidatesController extends Controller
{
    public function status(Request $request) {
        $status = $request->statusData;
        $data = explode(",", $status);
        $status = $data[0];
        $region = $data[1];
        $province = $data[2];
        $province_type = $data[3];

        if($region == "ph"){
            $location = "All Region";
            $governor = 'empty';
            $vice_governor = 'empty';
            $board_members = 'empty';
            $congressman = 'empty';
            $HUC_congressman = 'empty';
            $city_mayor = 'empty';
            $city_vice_mayor = 'empty';
            $city_councilor = 'empty';
            $municipal_mayor = 'empty';
            $municipal_vice_mayor = 'empty';
            $municipal_councilor = 'empty';
            $count_positions = (object) array(
                'governor' => 0,
                'vice_governor' => 0,
                'board_members' => 0,
                'congressman' => 0,
                'HUC_congressman' => 0,
                'city_mayor' => 0,
                'city_vice_mayor' => 0,
                'city_councilor' => 0,
                'municipal_mayor' => 0,
                'municipal_vice_mayor' => 0,
                'municipal_councilor' => 0
            );
            $positions = array('governor','vice_governor','board_members','congressman','HUC_congressman','city_mayor','city_vice_mayor','city_councilor','municipal_mayor','municipal_vice_mayor','municipal_councilor');
            
            if($status == '0'){
                $candidates = DB::table('candidates')->where('signed_by_lp',0)->get();
                if(count($candidates)) {
                    foreach($candidates as $candidate) {
                        if($candidate->candidate_for === "Governor") {
                            $governors = 'not empty';
                            $count_positions->governor = ($count_positions->governor) + 1;
                        } elseif($candidate->candidate_for === "Vice Governor") {
                            $vice_governors = 'not empty';
                            $count_positions->vice_governor = ($count_positions->vice_governor) + 1;
                        } elseif($candidate->candidate_for === "Provincal Board Member") {
                            $board_members = 'not empty';
                            $count_positions->board_members = ($count_positions->board_members) + 1;
                        } elseif($candidate->candidate_for === "Congressman") {
                            $congressman = 'not empty';
                            $count_positions->congressman = ($count_positions->congressman) + 1;
                        } elseif($candidate->candidate_for === "HUC Congressman") {
                            $HUC_congressman = 'not empty';
                            $count_positions->HUC_congressman = ($count_positions->HUC_congressman) + 1;
                        } elseif($candidate->candidate_for === "City Mayor") {
                            $city_mayor = 'not empty';
                            $count_positions->city_mayor = ($count_positions->city_mayor) + 1;
                        } elseif($candidate->candidate_for === "City Vice Mayor") {
                            $city_vice_mayor = 'not empty';
                            $count_positions->city_vice_mayor = ($count_positions->city_vice_mayor) + 1;
                        } elseif($candidate->candidate_for === "City Councilor") {
                            $city_councilor = 'not empty';
                            $count_positions->city_councilor = ($count_positions->city_councilor) + 1;
                        } elseif($candidate->candidate_for === "Municipal Mayor") {
                            $municipal_mayor = 'not empty';
                            $count_positions->municipal_mayor = ($count_positions->municipal_mayor) + 1;
                        } elseif($candidate->candidate_for === "Municipal Vice Mayor") {
                            $municipal_vice_mayor = 'not empty';
                            $count_positions->municipal_vice_mayor = ($count_positions->municipal_vice_mayor) + 1;
                        } elseif($candidate->candidate_for === "Municipal Councilor") {
                            $municipal_councilor = 'not empty';
                            $count_positions->municipal_councilor = ($count_positions->municipal_councilor) + 1;
                        }
                    }
                }
                
                $status_page = '0';
                return view('dashboard.status.pending', compact(
                    'candidates',
                    'governor',
                    'vice_governor',
                    'board_members',
                    'congressman',
                    'HUC_congressman',
                    'city_mayor',
                    'city_vice_mayor',
                    'city_councilor',
                    'municipal_mayor',
                    'municipal_vice_mayor',
                    'municipal_councilor',
                    'positions',
                    'count_positions',
                    'location',
                    'status_page'
                ));
            } elseif($status == '1') {
                $candidates = DB::table('candidates')->where('signed_by_lp',1)->get();
                if(count($candidates)) {
                    foreach($candidates as $candidate) {
                        if($candidate->candidate_for === "Governor") {
                            $governors = 'not empty';
                            $count_positions->governor = ($count_positions->governor) + 1;
                        } elseif($candidate->candidate_for === "Vice Governor") {
                            $vice_governors = 'not empty';
                            $count_positions->vice_governor = ($count_positions->vice_governor) + 1;
                        } elseif($candidate->candidate_for === "Provincal Board Member") {
                            $board_members = 'not empty';
                            $count_positions->board_members = ($count_positions->board_members) + 1;
                        } elseif($candidate->candidate_for === "Congressman") {
                            $congressman = 'not empty';
                            $count_positions->congressman = ($count_positions->congressman) + 1;
                        } elseif($candidate->candidate_for === "HUC Congressman") {
                            $HUC_congressman = 'not empty';
                            $count_positions->HUC_congressman = ($count_positions->HUC_congressman) + 1;
                        } elseif($candidate->candidate_for === "City Mayor") {
                            $city_mayor = 'not empty';
                            $count_positions->city_mayor = ($count_positions->city_mayor) + 1;
                        } elseif($candidate->candidate_for === "City Vice Mayor") {
                            $city_vice_mayor = 'not empty';
                            $count_positions->city_vice_mayor = ($count_positions->city_vice_mayor) + 1;
                        } elseif($candidate->candidate_for === "City Councilor") {
                            $city_councilor = 'not empty';
                            $count_positions->city_councilor = ($count_positions->city_councilor) + 1;
                        } elseif($candidate->candidate_for === "Municipal Mayor") {
                            $municipal_mayor = 'not empty';
                            $count_positions->municipal_mayor = ($count_positions->municipal_mayor) + 1;
                        } elseif($candidate->candidate_for === "Municipal Vice Mayor") {
                            $municipal_vice_mayor = 'not empty';
                            $count_positions->municipal_vice_mayor = ($count_positions->municipal_vice_mayor) + 1;
                        } elseif($candidate->candidate_for === "Municipal Councilor") {
                            $municipal_councilor = 'not empty';
                            $count_positions->municipal_councilor = ($count_positions->municipal_councilor) + 1;
                        }
                    }
                }

                $status_page = '1';
                return view('dashboard.status.approved', compact(
                    'candidates',
                    'governor',
                    'vice_governor',
                    'board_members',
                    'congressman',
                    'HUC_congressman',
                    'city_mayor',
                    'city_vice_mayor',
                    'city_councilor',
                    'municipal_mayor',
                    'municipal_vice_mayor',
                    'municipal_councilor',
                    'positions',
                    'count_positions',
                    'location',
                    'status_page'
                ));
            } else {
                $candidates = DB::table('candidates')->where('signed_by_lp',2)->get();
                if(count($candidates)) {
                    foreach($candidates as $candidate) {
                        if($candidate->candidate_for === "Governor") {
                            $governors = 'not empty';
                            $count_positions->governor = ($count_positions->governor) + 1;
                        } elseif($candidate->candidate_for === "Vice Governor") {
                            $vice_governors = 'not empty';
                            $count_positions->vice_governor = ($count_positions->vice_governor) + 1;
                        } elseif($candidate->candidate_for === "Provincal Board Member") {
                            $board_members = 'not empty';
                            $count_positions->board_members = ($count_positions->board_members) + 1;
                        } elseif($candidate->candidate_for === "Congressman") {
                            $congressman = 'not empty';
                            $count_positions->congressman = ($count_positions->congressman) + 1;
                        } elseif($candidate->candidate_for === "HUC Congressman") {
                            $HUC_congressman = 'not empty';
                            $count_positions->HUC_congressman = ($count_positions->HUC_congressman) + 1;
                        } elseif($candidate->candidate_for === "City Mayor") {
                            $city_mayor = 'not empty';
                            $count_positions->city_mayor = ($count_positions->city_mayor) + 1;
                        } elseif($candidate->candidate_for === "City Vice Mayor") {
                            $city_vice_mayor = 'not empty';
                            $count_positions->city_vice_mayor = ($count_positions->city_vice_mayor) + 1;
                        } elseif($candidate->candidate_for === "City Councilor") {
                            $city_councilor = 'not empty';
                            $count_positions->city_councilor = ($count_positions->city_councilor) + 1;
                        } elseif($candidate->candidate_for === "Municipal Mayor") {
                            $municipal_mayor = 'not empty';
                            $count_positions->municipal_mayor = ($count_positions->municipal_mayor) + 1;
                        } elseif($candidate->candidate_for === "Municipal Vice Mayor") {
                            $municipal_vice_mayor = 'not empty';
                            $count_positions->municipal_vice_mayor = ($count_positions->municipal_vice_mayor) + 1;
                        } elseif($candidate->candidate_for === "Municipal Councilor") {
                            $municipal_councilor = 'not empty';
                            $count_positions->municipal_councilor = ($count_positions->municipal_councilor) + 1;
                        }
                    }
                }

                $status_page = '2';
                return view('dashboard.status.rejected', compact(
                    'candidates',
                    'governor',
                    'vice_governor',
                    'board_members',
                    'congressman',
                    'HUC_congressman',
                    'city_mayor',
                    'city_vice_mayor',
                    'city_councilor',
                    'municipal_mayor',
                    'municipal_vice_mayor',
                    'municipal_councilor',
                    'positions',
                    'count_positions',
                    'location',
                    'status_page'
                ));
            }

        } elseif($province === 'empty') {
            //region sidebar clicked
            $location = "Region ".$region;
            $province_region = DB::table('province')->where('region',$region)->get();
            $provinces_id = array();
            foreach($province_region as $prov_reg){
                array_push($provinces_id, $prov_reg->province_code);
            }
            $candidates = DB::table('candidates')->whereIn('province_id',$provinces_id)->get();
            $governor = 'empty';
            $vice_governor = 'empty';
            $board_members = 'empty';
            $congressman = 'empty';
            $HUC_congressman = 'empty';
            $city_mayor = 'empty';
            $city_vice_mayor = 'empty';
            $city_councilor = 'empty';
            $municipal_mayor = 'empty';
            $municipal_vice_mayor = 'empty';
            $municipal_councilor = 'empty';
            $count_positions = (object) array(
                'governor' => 0,
                'vice_governor' => 0,
                'board_members' => 0,
                'congressman' => 0,
                'HUC_congressman' => 0,
                'city_mayor' => 0,
                'city_vice_mayor' => 0,
                'city_councilor' => 0,
                'municipal_mayor' => 0,
                'municipal_vice_mayor' => 0,
                'municipal_councilor' => 0
            );
            $positions = array('governor','vice_governor','board_members','congressman','HUC_congressman','city_mayor','city_vice_mayor','city_councilor','municipal_mayor','municipal_vice_mayor','municipal_councilor');

            foreach($candidates as $candidate){
                if($status === '0' && $candidate->signed_by_lp === '0') {
                    if($candidate->candidate_for === "Governor") {
                        $governors = 'not empty';
                        $count_positions->governor = ($count_positions->governor) + 1;
                    } elseif($candidate->candidate_for === "Vice Governor") {
                        $vice_governors = 'not empty';
                        $count_positions->vice_governor = ($count_positions->vice_governor) + 1;
                    } elseif($candidate->candidate_for === "Provincal Board Member") {
                        $board_members = 'not empty';
                        $count_positions->board_members = ($count_positions->board_members) + 1;
                    } elseif($candidate->candidate_for === "Congressman") {
                        $congressman = 'not empty';
                        $count_positions->congressman = ($count_positions->congressman) + 1;
                    } elseif($candidate->candidate_for === "HUC Congressman") {
                        $HUC_congressman = 'not empty';
                        $count_positions->HUC_congressman = ($count_positions->HUC_congressman) + 1;
                    } elseif($candidate->candidate_for === "City Mayor") {
                        $city_mayor = 'not empty';
                        $count_positions->city_mayor = ($count_positions->city_mayor) + 1;
                    } elseif($candidate->candidate_for === "City Vice Mayor") {
                        $city_vice_mayor = 'not empty';
                        $count_positions->city_vice_mayor = ($count_positions->city_vice_mayor) + 1;
                    } elseif($candidate->candidate_for === "City Councilor") {
                        $city_councilor = 'not empty';
                        $count_positions->city_councilor = ($count_positions->city_councilor) + 1;
                    } elseif($candidate->candidate_for === "Municipal Mayor") {
                        $municipal_mayor = 'not empty';
                        $count_positions->municipal_mayor = ($count_positions->municipal_mayor) + 1;
                    } elseif($candidate->candidate_for === "Municipal Vice Mayor") {
                        $municipal_vice_mayor = 'not empty';
                        $count_positions->municipal_vice_mayor = ($count_positions->municipal_vice_mayor) + 1;
                    } elseif($candidate->candidate_for === "Municipal Councilor") {
                        $municipal_councilor = 'not empty';
                        $count_positions->municipal_councilor = ($count_positions->municipal_councilor) + 1;
                    }
                } elseif($status === '1' && $candidate->signed_by_lp === '1') {
                    if($candidate->candidate_for === "Governor") {
                        $governors = 'not empty';
                        $count_positions->governor = ($count_positions->governor) + 1;
                    } elseif($candidate->candidate_for === "Vice Governor") {
                        $vice_governors = 'not empty';
                        $count_positions->vice_governor = ($count_positions->vice_governor) + 1;
                    } elseif($candidate->candidate_for === "Provincal Board Member") {
                        $board_members = 'not empty';
                        $count_positions->board_members = ($count_positions->board_members) + 1;
                    } elseif($candidate->candidate_for === "Congressman") {
                        $congressman = 'not empty';
                        $count_positions->congressman = ($count_positions->congressman) + 1;
                    } elseif($candidate->candidate_for === "HUC Congressman") {
                        $HUC_congressman = 'not empty';
                        $count_positions->HUC_congressman = ($count_positions->HUC_congressman) + 1;
                    } elseif($candidate->candidate_for === "City Mayor") {
                        $city_mayor = 'not empty';
                        $count_positions->city_mayor = ($count_positions->city_mayor) + 1;
                    } elseif($candidate->candidate_for === "City Vice Mayor") {
                        $city_vice_mayor = 'not empty';
                        $count_positions->city_vice_mayor = ($count_positions->city_vice_mayor) + 1;
                    } elseif($candidate->candidate_for === "City Councilor") {
                        $city_councilor = 'not empty';
                        $count_positions->city_councilor = ($count_positions->city_councilor) + 1;
                    } elseif($candidate->candidate_for === "Municipal Mayor") {
                        $municipal_mayor = 'not empty';
                        $count_positions->municipal_mayor = ($count_positions->municipal_mayor) + 1;
                    } elseif($candidate->candidate_for === "Municipal Vice Mayor") {
                        $municipal_vice_mayor = 'not empty';
                        $count_positions->municipal_vice_mayor = ($count_positions->municipal_vice_mayor) + 1;
                    } elseif($candidate->candidate_for === "Municipal Councilor") {
                        $municipal_councilor = 'not empty';
                        $count_positions->municipal_councilor = ($count_positions->municipal_councilor) + 1;
                    }
                } elseif($status === '2' && $candidate->signed_by_lp === '2') {
                    if($candidate->candidate_for === "Governor") {
                        $governors = 'not empty';
                        $count_positions->governor = ($count_positions->governor) + 1;
                    } elseif($candidate->candidate_for === "Vice Governor") {
                        $vice_governors = 'not empty';
                        $count_positions->vice_governor = ($count_positions->vice_governor) + 1;
                    } elseif($candidate->candidate_for === "Provincal Board Member") {
                        $board_members = 'not empty';
                        $count_positions->board_members = ($count_positions->board_members) + 1;
                    } elseif($candidate->candidate_for === "Congressman") {
                        $congressman = 'not empty';
                        $count_positions->congressman = ($count_positions->congressman) + 1;
                    } elseif($candidate->candidate_for === "HUC Congressman") {
                        $HUC_congressman = 'not empty';
                        $count_positions->HUC_congressman = ($count_positions->HUC_congressman) + 1;
                    } elseif($candidate->candidate_for === "City Mayor") {
                        $city_mayor = 'not empty';
                        $count_positions->city_mayor = ($count_positions->city_mayor) + 1;
                    } elseif($candidate->candidate_for === "City Vice Mayor") {
                        $city_vice_mayor = 'not empty';
                        $count_positions->city_vice_mayor = ($count_positions->city_vice_mayor) + 1;
                    } elseif($candidate->candidate_for === "City Councilor") {
                        $city_councilor = 'not empty';
                        $count_positions->city_councilor = ($count_positions->city_councilor) + 1;
                    } elseif($candidate->candidate_for === "Municipal Mayor") {
                        $municipal_mayor = 'not empty';
                        $count_positions->municipal_mayor = ($count_positions->municipal_mayor) + 1;
                    } elseif($candidate->candidate_for === "Municipal Vice Mayor") {
                        $municipal_vice_mayor = 'not empty';
                        $count_positions->municipal_vice_mayor = ($count_positions->municipal_vice_mayor) + 1;
                    } elseif($candidate->candidate_for === "Municipal Councilor") {
                        $municipal_councilor = 'not empty';
                        $count_positions->municipal_councilor = ($count_positions->municipal_councilor) + 1;
                    }
                }
            }

            if($status === '0') {
                foreach($candidates as $candidate) {
                    $status_page = $candidate->signed_by_lp;
                }
                return view('dashboard.status.pending', compact(
                    'candidates',
                    'governor',
                    'vice_governor',
                    'board_members',
                    'congressman',
                    'HUC_congressman',
                    'city_mayor',
                    'city_vice_mayor',
                    'city_councilor',
                    'municipal_mayor',
                    'municipal_vice_mayor',
                    'municipal_councilor',
                    'positions',
                    'count_positions',
                    'location',
                    'status_page'
                ));
            } elseif($status === '1') {
                foreach($candidates as $candidate) {
                    $status_page = $candidate->signed_by_lp;
                }
                return view('dashboard.status.approved', compact(
                    'candidates',
                    'governor',
                    'vice_governor',
                    'board_members',
                    'congressman',
                    'HUC_congressman',
                    'city_mayor',
                    'city_vice_mayor',
                    'city_councilor',
                    'municipal_mayor',
                    'municipal_vice_mayor',
                    'municipal_councilor',
                    'positions',
                    'count_positions',
                    'location',
                    'status_page'
                ));
            } else {
                foreach($candidates as $candidate) {
                    $status_page = $candidate->signed_by_lp;
                }
                return view('dashboard.status.rejected', compact(
                    'candidates',
                    'governor',
                    'vice_governor',
                    'board_members',
                    'congressman',
                    'HUC_congressman',
                    'city_mayor',
                    'city_vice_mayor',
                    'city_councilor',
                    'municipal_mayor',
                    'municipal_vice_mayor',
                    'municipal_councilor',
                    'positions',
                    'count_positions',
                    'location',
                    'status_page'
                ));
            }
        } else {
            //province sidebar clicked
            if($province_type === 'HUC' || $province_type === 'ICC') {
                //city mayor
                $province_table = DB::table('province')->where('province_code',$province)->first();
                $location = ucwords(strtolower($province_table->lgu));
                $location_type = $province_table->type;
                $candidates = DB::table('candidates')->where('province_id',$province)->get();

                $city_mayor = 'empty';
                $city_vice_mayor = 'empty';
                $city_councilor = 'empty';
                $count_positions = (object) array(
                    'city_mayor' => 0,
                    'city_vice_mayor' => 0,
                    'city_councilor' => 0
                );
                $positions = array('city_mayor','city_vice_mayor','city_councilor');

                foreach($candidates as $candidate){
                    if($status === '0' && $candidate->signed_by_lp === '0') {
                        if($candidate->candidate_for === "City Mayor") {
                            $city_mayor = 'not empty';
                            $count_positions->city_mayor = ($count_positions->city_mayor) + 1;
                        } elseif($candidate->candidate_for === "City Vice Mayor") {
                            $city_vice_mayor = 'not empty';
                            $count_positions->city_vice_mayor = ($count_positions->city_vice_mayor) + 1;
                        } elseif($candidate->candidate_for === "City Councilor") {
                            $city_councilor = 'not empty';
                            $count_positions->city_councilor = ($count_positions->city_councilor) + 1;
                        }
                    } elseif($status === '1' && $candidate->signed_by_lp === '1') {
                        if($candidate->candidate_for === "City Mayor") {
                            $city_mayor = 'not empty';
                            $count_positions->city_mayor = ($count_positions->city_mayor) + 1;
                        } elseif($candidate->candidate_for === "City Vice Mayor") {
                            $city_vice_mayor = 'not empty';
                            $count_positions->city_vice_mayor = ($count_positions->city_vice_mayor) + 1;
                        } elseif($candidate->candidate_for === "City Councilor") {
                            $city_councilor = 'not empty';
                            $count_positions->city_councilor = ($count_positions->city_councilor) + 1;
                        }
                    } elseif($status === '2' && $candidate->signed_by_lp === '2') {
                        if($candidate->candidate_for === "City Mayor") {
                            $city_mayor = 'not empty';
                            $count_positions->city_mayor = ($count_positions->city_mayor) + 1;
                        } elseif($candidate->candidate_for === "City Vice Mayor") {
                            $city_vice_mayor = 'not empty';
                            $count_positions->city_vice_mayor = ($count_positions->city_vice_mayor) + 1;
                        } elseif($candidate->candidate_for === "City Councilor") {
                            $city_councilor = 'not empty';
                            $count_positions->city_councilor = ($count_positions->city_councilor) + 1;
                        }
                    }
                }

                if($status === '0') {
                    foreach($candidates as $candidate) {
                        $status_page = $candidate->signed_by_lp;
                    }
                    return view('dashboard.status.pending', compact(
                        'candidates',
                        'city_mayor',
                        'city_vice_mayor',
                        'city_councilor',
                        'positions',
                        'count_positions',
                        'location',
                        'status_page'
                    ));
                } elseif($status === '1') {
                    foreach($candidates as $candidate) {
                        $status_page = $candidate->signed_by_lp;
                    }
                    return view('dashboard.status.approved', compact(
                        'candidates',
                        'city_mayor',
                        'city_vice_mayor',
                        'city_councilor',
                        'positions',
                        'count_positions',
                        'location',
                        'status_page'
                    ));
                } else {
                    foreach($candidates as $candidate) {
                        $status_page = $candidate->signed_by_lp;
                    }
                    return view('dashboard.status.rejected', compact(
                        'candidates',
                        'city_mayor',
                        'city_vice_mayor',
                        'city_councilor',
                        'positions',
                        'count_positions',
                        'location',
                        'status_page'
                    ));
                }
            } else {
                //governor
                $province_table = DB::table('province')->where('province_code',$province)->first();
                $location = ucwords(strtolower($province_table->lgu));
                $location_type = $province_table->type;
                $candidates = DB::table('candidates')->where('province_id',$province.'%')->get();

                $governor = 'empty';
                $vice_governor = 'empty';
                $board_members = 'empty';
                $congressman = 'empty';
                $HUC_congressman = 'empty';
                $city_mayor = 'empty';
                $city_vice_mayor = 'empty';
                $city_councilor = 'empty';
                $municipal_mayor = 'empty';
                $municipal_vice_mayor = 'empty';
                $municipal_councilor = 'empty';
                $count_positions = (object) array(
                    'governor' => 0,
                    'vice_governor' => 0,
                    'board_members' => 0,
                    'congressman' => 0,
                    'HUC_congressman' => 0,
                    'city_mayor' => 0,
                    'city_vice_mayor' => 0,
                    'city_councilor' => 0,
                    'municipal_mayor' => 0,
                    'municipal_vice_mayor' => 0,
                    'municipal_councilor' => 0
                );
                $positions = array('governor','vice_governor','board_members','congressman','HUC_congressman','city_mayor','city_vice_mayor','city_councilor','municipal_mayor','municipal_vice_mayor','municipal_councilor');

                foreach($candidates as $candidate){
                    if($status === '0' && $candidate->signed_by_lp === '0') {
                        if($candidate->candidate_for === "Governor") {
                            $governors = 'not empty';
                            $count_positions->governor = ($count_positions->governor) + 1;
                        } elseif($candidate->candidate_for === "Vice Governor") {
                            $vice_governors = 'not empty';
                            $count_positions->vice_governor = ($count_positions->vice_governor) + 1;
                        } elseif($candidate->candidate_for === "Provincal Board Member") {
                            $board_members = 'not empty';
                            $count_positions->board_members = ($count_positions->board_members) + 1;
                        } elseif($candidate->candidate_for === "Congressman") {
                            $congressman = 'not empty';
                            $count_positions->congressman = ($count_positions->congressman) + 1;
                        } elseif($candidate->candidate_for === "HUC Congressman") {
                            $HUC_congressman = 'not empty';
                            $count_positions->HUC_congressman = ($count_positions->HUC_congressman) + 1;
                        } elseif($candidate->candidate_for === "City Mayor") {
                            $city_mayor = 'not empty';
                            $count_positions->city_mayor = ($count_positions->city_mayor) + 1;
                        } elseif($candidate->candidate_for === "City Vice Mayor") {
                            $city_vice_mayor = 'not empty';
                            $count_positions->city_vice_mayor = ($count_positions->city_vice_mayor) + 1;
                        } elseif($candidate->candidate_for === "City Councilor") {
                            $city_councilor = 'not empty';
                            $count_positions->city_councilor = ($count_positions->city_councilor) + 1;
                        } elseif($candidate->candidate_for === "Municipal Mayor") {
                            $municipal_mayor = 'not empty';
                            $count_positions->municipal_mayor = ($count_positions->municipal_mayor) + 1;
                        } elseif($candidate->candidate_for === "Municipal Vice Mayor") {
                            $municipal_vice_mayor = 'not empty';
                            $count_positions->municipal_vice_mayor = ($count_positions->municipal_vice_mayor) + 1;
                        } elseif($candidate->candidate_for === "Municipal Councilor") {
                            $municipal_councilor = 'not empty';
                            $count_positions->municipal_councilor = ($count_positions->municipal_councilor) + 1;
                        }
                    } elseif($status === '1' && $candidate->signed_by_lp === '1') {
                        if($candidate->candidate_for === "Governor") {
                            $governors = 'not empty';
                            $count_positions->governor = ($count_positions->governor) + 1;
                        } elseif($candidate->candidate_for === "Vice Governor") {
                            $vice_governors = 'not empty';
                            $count_positions->vice_governor = ($count_positions->vice_governor) + 1;
                        } elseif($candidate->candidate_for === "Provincal Board Member") {
                            $board_members = 'not empty';
                            $count_positions->board_members = ($count_positions->board_members) + 1;
                        } elseif($candidate->candidate_for === "Congressman") {
                            $congressman = 'not empty';
                            $count_positions->congressman = ($count_positions->congressman) + 1;
                        } elseif($candidate->candidate_for === "HUC Congressman") {
                            $HUC_congressman = 'not empty';
                            $count_positions->HUC_congressman = ($count_positions->HUC_congressman) + 1;
                        } elseif($candidate->candidate_for === "City Mayor") {
                            $city_mayor = 'not empty';
                            $count_positions->city_mayor = ($count_positions->city_mayor) + 1;
                        } elseif($candidate->candidate_for === "City Vice Mayor") {
                            $city_vice_mayor = 'not empty';
                            $count_positions->city_vice_mayor = ($count_positions->city_vice_mayor) + 1;
                        } elseif($candidate->candidate_for === "City Councilor") {
                            $city_councilor = 'not empty';
                            $count_positions->city_councilor = ($count_positions->city_councilor) + 1;
                        } elseif($candidate->candidate_for === "Municipal Mayor") {
                            $municipal_mayor = 'not empty';
                            $count_positions->municipal_mayor = ($count_positions->municipal_mayor) + 1;
                        } elseif($candidate->candidate_for === "Municipal Vice Mayor") {
                            $municipal_vice_mayor = 'not empty';
                            $count_positions->municipal_vice_mayor = ($count_positions->municipal_vice_mayor) + 1;
                        } elseif($candidate->candidate_for === "Municipal Councilor") {
                            $municipal_councilor = 'not empty';
                            $count_positions->municipal_councilor = ($count_positions->municipal_councilor) + 1;
                        }
                    } elseif($status === '2' && $candidate->signed_by_lp === '2') {
                        if($candidate->candidate_for === "Governor") {
                            $governors = 'not empty';
                            $count_positions->governor = ($count_positions->governor) + 1;
                        } elseif($candidate->candidate_for === "Vice Governor") {
                            $vice_governors = 'not empty';
                            $count_positions->vice_governor = ($count_positions->vice_governor) + 1;
                        } elseif($candidate->candidate_for === "Provincal Board Member") {
                            $board_members = 'not empty';
                            $count_positions->board_members = ($count_positions->board_members) + 1;
                        } elseif($candidate->candidate_for === "Congressman") {
                            $congressman = 'not empty';
                            $count_positions->congressman = ($count_positions->congressman) + 1;
                        } elseif($candidate->candidate_for === "HUC Congressman") {
                            $HUC_congressman = 'not empty';
                            $count_positions->HUC_congressman = ($count_positions->HUC_congressman) + 1;
                        } elseif($candidate->candidate_for === "City Mayor") {
                            $city_mayor = 'not empty';
                            $count_positions->city_mayor = ($count_positions->city_mayor) + 1;
                        } elseif($candidate->candidate_for === "City Vice Mayor") {
                            $city_vice_mayor = 'not empty';
                            $count_positions->city_vice_mayor = ($count_positions->city_vice_mayor) + 1;
                        } elseif($candidate->candidate_for === "City Councilor") {
                            $city_councilor = 'not empty';
                            $count_positions->city_councilor = ($count_positions->city_councilor) + 1;
                        } elseif($candidate->candidate_for === "Municipal Mayor") {
                            $municipal_mayor = 'not empty';
                            $count_positions->municipal_mayor = ($count_positions->municipal_mayor) + 1;
                        } elseif($candidate->candidate_for === "Municipal Vice Mayor") {
                            $municipal_vice_mayor = 'not empty';
                            $count_positions->municipal_vice_mayor = ($count_positions->municipal_vice_mayor) + 1;
                        } elseif($candidate->candidate_for === "Municipal Councilor") {
                            $municipal_councilor = 'not empty';
                            $count_positions->municipal_councilor = ($count_positions->municipal_councilor) + 1;
                        }
                    }
                }

                if($status === '0') {
                    foreach($candidates as $candidate) {
                        $status_page = $candidate->signed_by_lp;
                    }
                    return view('dashboard.status.pending', compact(
                        'candidates',
                        'governor',
                        'vice_governor',
                        'board_members',
                        'congressman',
                        'HUC_congressman',
                        'city_mayor',
                        'city_vice_mayor',
                        'city_councilor',
                        'municipal_mayor',
                        'municipal_vice_mayor',
                        'municipal_councilor',
                        'positions',
                        'count_positions',
                        'location',
                        'status_page'
                    ));
                } elseif($status === '1') {
                    foreach($candidates as $candidate) {
                        $status_page = $candidate->signed_by_lp;
                    }
                    return view('dashboard.status.approved', compact(
                        'candidates',
                        'governor',
                        'vice_governor',
                        'board_members',
                        'congressman',
                        'HUC_congressman',
                        'city_mayor',
                        'city_vice_mayor',
                        'city_councilor',
                        'municipal_mayor',
                        'municipal_vice_mayor',
                        'municipal_councilor',
                        'positions',
                        'count_positions',
                        'location',
                        'status_page'
                    ));
                } else {
                    foreach($candidates as $candidate) {
                        $status_page = $candidate->signed_by_lp;
                    }
                    return view('dashboard.status.rejected', compact(
                        'candidates',
                        'governor',
                        'vice_governor',
                        'board_members',
                        'congressman',
                        'HUC_congressman',
                        'city_mayor',
                        'city_vice_mayor',
                        'city_councilor',
                        'municipal_mayor',
                        'municipal_vice_mayor',
                        'municipal_councilor',
                        'positions',
                        'count_positions',
                        'location',
                        'status_page'
                    ));
                }
            }
        }
    }
}
