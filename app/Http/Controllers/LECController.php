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

    public function screening() {
        return view('lec.screening.screening');
    }

    public function huc($code) {
        $userId = Auth::user()->id;
        $lec = DB::table('lec')->where('user', '=', $userId)->orWhere('user_2', '=', $userId)->first();
        $lecId = $lec->id;

        $data = DB::table('huc')
            ->join('province as p', 'huc.province_code', '=', 'p.province_code')
            ->select('huc.*', DB::raw('(SELECT count(signed_by_lp) FROM candidates WHERE district_id = huc.district AND signed_by_lp = 0 AND province_id = huc.province_code) AS pending, (SELECT count(signed_by_lp) FROM candidates WHERE district_id = huc.district AND signed_by_lp = 1 AND province_id = huc.province_code) AS approved, (SELECT count(signed_by_lp) FROM candidates WHERE district_id = huc.district AND signed_by_lp = 2 AND province_id = huc.province_code) AS rejected, (SELECT name FROM lec WHERE id = p.lec AND p.province_code = huc.province_code) AS assigned_lec'))
            ->where('huc.province_code', '=', $code)
            ->orWhere('huc.parent_province_code', '=', $code)
            ->distinct('huc.id')
            ->get();
        //$data = DB::table('huc')->where('province_code', '=', $code)->orWhere('parent_province_code', '=', $code)->get();
        return $data;
    }

    public function municipality($code) {
        $userId = Auth::user()->id;
        $lec = DB::table('lec')->where('user', '=', $userId)->orWhere('user_2', '=', $userId)->first();
        $lecId = $lec->id;

        if ($code == '0505' || $code == '0630' || $code == '0155') {
            $data = DB::table('municipality as m')
                ->select('m.*', DB::raw('(SELECT count(signed_by_lp) FROM candidates WHERE city_id = m.municipality AND signed_by_lp = 0 AND province_id = '. $code .') AS pending, (SELECT count(signed_by_lp) FROM candidates WHERE city_id = m.municipality AND signed_by_lp = 1 AND province_id = '. $code .') AS approved, (SELECT count(signed_by_lp) FROM candidates WHERE city_id = m.municipality AND signed_by_lp = 2 AND province_id = '. $code .') AS rejected'))
                ->where('lec', '=', $lecId)
                ->where('m.province_code', '=', $code)
                ->get();
            //$data = DB::table('municipality')->get()->where('province_code', '=', $code)->where('lec', '=', $lecId);
        }
        else {
            $data = DB::table('municipality as m')
                ->select('m.*', DB::raw('(SELECT count(signed_by_lp) FROM candidates WHERE city_id = m.municipality AND signed_by_lp = 0 AND province_id = '. $code .') AS pending, (SELECT count(signed_by_lp) FROM candidates WHERE city_id = m.municipality AND signed_by_lp = 1 AND province_id = '. $code .') AS approved, (SELECT count(signed_by_lp) FROM candidates WHERE city_id = m.municipality AND signed_by_lp = 2 AND province_id = '. $code .') AS rejected'))
                ->where('m.province_code', '=', $code)
                ->get();
            //$data = DB::table('municipality')->get()->where('province_code', '=', $code);
        }
        return $data;
    }

    public function district($code) {
        $userId = Auth::user()->id;
        $lec = DB::table('lec')->where('user', '=', $userId)->orWhere('user_2', '=', $userId)->first();
        $lecId = $lec->id;

        if ($code == '0505' || $code == '0630' || $code == '0155') {
            $data = DB::table('municipality as m')
                ->join('candidates as c', 'c.province_id', '=', 'm.province_code')
                ->select('m.*', DB::raw('(SELECT count(signed_by_lp) FROM candidates WHERE district_id = m.district AND signed_by_lp = 0 AND province_id = '. $code .') AS pending, (SELECT count(signed_by_lp) FROM candidates WHERE district_id = m.district AND signed_by_lp = 1 AND province_id = '. $code .') AS approved, (SELECT count(signed_by_lp) FROM candidates WHERE district_id = m.district AND signed_by_lp = 2 AND province_id = '. $code .') AS rejected'))
                ->where('lec', '=', $lecId)
                ->where('m.province_code', '=', $code)
                ->get();
            //$data = DB::table('municipality')->get()->where('province_code', '=', $code)->where('lec', '=', $lecId);
        }
        else {
            $data = DB::table('municipality as m')
                ->join('candidates as c', 'c.province_id', '=', 'm.province_code')
                ->select('m.*', DB::raw('(SELECT count(signed_by_lp) FROM candidates WHERE district_id = m.district AND signed_by_lp = 0 AND province_id = '. $code .') AS pending, (SELECT count(signed_by_lp) FROM candidates WHERE district_id = m.district AND signed_by_lp = 1 AND province_id = '. $code .') AS approved, (SELECT count(signed_by_lp) FROM candidates WHERE district_id = m.district AND signed_by_lp = 2 AND province_id = '. $code .') AS rejected'))
                ->where('m.province_code', '=', $code)
                ->get();
            //$data = DB::table('municipality')->get()->where('province_code', '=', $code);
        }
        return $data;
    }

    public function city($code) {
        $userId = Auth::user()->id;
        $lec = DB::table('lec')->where('user', '=', $userId)->orWhere('user_2', '=', $userId)->first();
        $lecId = $lec->id;

        if ($code == '0505' || $code == '0973' || $code == '0354' || $code == '0349' || $code == '0215' || $code == '0155') {
            $data = DB::table('city')
                ->select('city.*', DB::raw('(SELECT count(signed_by_lp) FROM candidates WHERE city_id = city.city AND signed_by_lp = 0 AND province_id = '. $code .') AS pending, (SELECT count(signed_by_lp) FROM candidates WHERE city_id = city.city AND signed_by_lp = 1 AND province_id = '. $code .') AS approved, (SELECT count(signed_by_lp) FROM candidates WHERE city_id = city.city AND signed_by_lp = 2 AND province_id = '. $code .') AS rejected'))
                ->where('lec', '=', $lecId)
                ->where('city.province_code', '=', $code)
                ->get();
            //$data = DB::table('city')->get()->where('province_code', '=', $code)->where('lec', '=', $lecId);
        }
        else {
            $data = DB::table('city')
                ->select('city.*', DB::raw('(SELECT count(signed_by_lp) FROM candidates WHERE city_id = city.city AND signed_by_lp = 0 AND province_id = '. $code .') AS pending, (SELECT count(signed_by_lp) FROM candidates WHERE city_id = city.city AND signed_by_lp = 1 AND province_id = '. $code .') AS approved, (SELECT count(signed_by_lp) FROM candidates WHERE city_id = city.city AND signed_by_lp = 2 AND province_id = '. $code .') AS rejected'))
                ->where('city.province_code', '=', $code)
                ->get();
            //$data = DB::table('city')->get()->where('province_code', '=', $code);
        }
        return $data;
    }

    public function region($code) {
        $userId = Auth::user()->id;
        $lec = DB::table('lec')->where('user', '=', $userId)->orWhere('user_2', '=', $userId)->first();
        $lecId = $lec->id;

        if ($code == 'NCR') {
            $data = DB::table('province as p')
                ->select('p.*', DB::raw('(SELECT count(signed_by_lp) FROM candidates WHERE signed_by_lp = 0 AND province_id = p.province_code) AS pending, (SELECT count(signed_by_lp) FROM candidates WHERE signed_by_lp = 1 AND province_id = p.province_code) AS approved, (SELECT count(signed_by_lp) FROM candidates WHERE signed_by_lp = 2 AND province_id = p.province_code) AS rejected'))
                ->where('p.region', '=', $code)
                ->where('lec', '=', $lecId)
                ->get();
            //$data = DB::table('province')->get()->where('region', '=', $code)->where('lec', '=', $lecId);
        }
        else {
            $data = DB::table('province as p')
                ->select('p.*', DB::raw('(SELECT count(signed_by_lp) FROM candidates WHERE signed_by_lp = 0 AND province_id = p.province_code) AS pending, (SELECT count(signed_by_lp) FROM candidates WHERE signed_by_lp = 1 AND province_id = p.province_code) AS approved, (SELECT count(signed_by_lp) FROM candidates WHERE signed_by_lp = 2 AND province_id = p.province_code) AS rejected'))
                ->where('p.region', '=', $code)
                ->where('lec', '=', $lecId)
                ->where('type', '!=', 'HUC')
                ->get();
            //$data = DB::table('province')->get()->where('region', '=', $code)->where('type', '!=', 'HUC')->where('lec', '=', $lecId);
        }
        return $data;
    }

    public static function lec_candidate($province_code) {

        $query = DB::table('province AS pv')
            ->join('lec AS lc', 'pv.lec', '=', 'lc.id')
            ->select('lc.name')
            ->where('pv.province_code', '=', $province_code)
            ->limit(1)
            ->get();

        $queryCity = DB::table('city AS ct')
            ->join('lec AS lc', 'ct.lec', '=', 'lc.id')
            ->select('lc.name')
            ->where('ct.province_code', '=', $province_code)
            ->limit(1)
            ->get();

        $queryMunicipal = DB::table('municipality AS muni')
            ->join('lec AS lc', 'muni.lec', '=', 'lc.id')
            ->select('lc.name')
            ->where('muni.province_code', '=', $province_code)
            ->limit(1)
            ->get();

        if(count($queryMunicipal) > 0) {
            return $queryMunicipal[0]->name;
        } else {
            if(count($queryCity) > 0) {
                return $queryCity[0]->name;
            } else {
                if(count($query) > 0) {
                    return $query[0]->name;
                } else {
                    return 'No assigned LEC';
                }
            }
        }

        // if(count($query) > 0) {
        //     return $query[0]->name;
        // } else {
        //     if(count($queryCity) > 0) {
        //         return $queryCity[0]->name;
        //     } else {
        //         if(count($queryMunicipal) > 0) {
        //             return $queryMunicipal[0]->name;
        //         } else {
        //             return 'No assigned LEC';
        //         }
        //     }
        // }
    }

    public function status(Request $request) {
        $status = $request->statusData;
        $data = explode(",", $status);
        $status = $data[0];
        $region = $data[1];
        $province = $data[2];
        $province_type = $data[3];
        $status_page = null;
        
        $userId = Auth::user()->id;
        $lec = DB::table('lec')->where('user', '=', $userId)->orWhere('user_2', '=', $userId)->first();
        $lecId = $lec->id;
        $province_table = DB::table('province')->where('lec', '=', $lecId)->get();
        $province_arr = array();
        foreach($province_table as $prov) {
            array_push($province_arr, $prov->province_code);
        }

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
                $candidates = DB::table('candidates')
                                    ->where('signed_by_lec',0)
                                    ->whereIn('province_id',$province_arr)
                                    ->get();
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

                foreach($candidates as $candidate) {
                    if($candidate->signed_by_lec == $status)
                        $status_page = $status;
                }
                return view('lec.status.pending', compact(
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
                $candidates = DB::table('candidates')
                                    ->where('signed_by_lec',1)
                                    ->whereIn('province_id',$province_arr)
                                    ->get();
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

                foreach($candidates as $candidate) {
                    if($candidate->signed_by_lec == $status)
                        $status_page = $status;
                }
                return view('lec.status.approved', compact(
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
                $candidates = DB::table('candidates')
                                    ->where('signed_by_lec',2)
                                    ->whereIn('province_id',$province_arr)
                                    ->get();
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

                foreach($candidates as $candidate) {
                    if($candidate->signed_by_lec == $status)
                        $status_page = $status;
                }
                return view('lec.status.rejected', compact(
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
            $province_region = DB::table('province')
                                    ->where('region',$region)
                                    ->where('lec',$lecId)
                                    ->get();
            $provinces_id = array();
            foreach($province_region as $prov_regs){
                array_push($provinces_id, $prov_regs->province_code);
            }
            $candidates = DB::table('candidates')
                            ->whereIn('province_id',$provinces_id)
                            ->get();
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
                if($status === '0' && $candidate->signed_by_lec === '0') {
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
                } elseif($status === '1' && $candidate->signed_by_lec === '1') {
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
                } elseif($status === '2' && $candidate->signed_by_lec === '2') {
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
                    if($candidate->signed_by_lec == $status)
                        $status_page = $status;
                }
                return view('lec.status.pending', compact(
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
                    if($candidate->signed_by_lec == $status)
                        $status_page = $status;
                }
                return view('lec.status.approved', compact(
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
                    if($candidate->signed_by_lec == $status)
                        $status_page = $status;
                }
                return view('lec.status.rejected', compact(
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
            $province_table = DB::table('province')
                                ->where('province_code',$province)
                                ->where('lec',$lecId)
                                ->first();
            $location = ucwords(strtolower($province_table->lgu));
            $location_type = $province_table->type;
            $candidates = DB::table('candidates')->where('province_id',$province)->get();

            if($location_type === 'HUC' || $location_type === 'ICC') {
                //city mayor
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
                    if($status === '0' && $candidate->signed_by_lec === '0') {
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
                    } elseif($status === '1' && $candidate->signed_by_lec === '1') {
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
                    } elseif($status === '2' && $candidate->signed_by_lec === '2') {
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
                        if($candidate->signed_by_lec == $status)
                            $status_page = $status;
                    }
                    return view('lec.status.pending', compact(
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
                        if($candidate->signed_by_lec == $status)
                            $status_page = $status;
                    }
                    return view('lec.status.approved', compact(
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
                        if($candidate->signed_by_lec == $status)
                            $status_page = $status;
                    }
                    return view('lec.status.rejected', compact(
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
                $governor = 'empty';
                $vice_governor = 'empty';
                $board_members = 'empty';
                $count_positions = (object) array(
                    'governor' => 0,
                    'vice_governor' => 0,
                    'board_members' => 0
                );
                $positions = array('governor','vice_governor','board_members');

                foreach($candidates as $candidate){
                    if($status === '0' && $candidate->signed_by_lec === '0') {
                        if($candidate->candidate_for === "Governor") {
                            $governors = 'not empty';
                            $count_positions->governor = ($count_positions->governor) + 1;
                        } elseif($candidate->candidate_for === "Vice Governor") {
                            $vice_governors = 'not empty';
                            $count_positions->vice_governor = ($count_positions->vice_governor) + 1;
                        } elseif($candidate->candidate_for === "Provincal Board Member") {
                            $board_members = 'not empty';
                            $count_positions->board_members = ($count_positions->board_members) + 1;
                        }
                    } elseif($status === '1' && $candidate->signed_by_lec === '1') {
                        if($candidate->candidate_for === "Governor") {
                            $governors = 'not empty';
                            $count_positions->governor = ($count_positions->governor) + 1;
                        } elseif($candidate->candidate_for === "Vice Governor") {
                            $vice_governors = 'not empty';
                            $count_positions->vice_governor = ($count_positions->vice_governor) + 1;
                        } elseif($candidate->candidate_for === "Provincal Board Member") {
                            $board_members = 'not empty';
                            $count_positions->board_members = ($count_positions->board_members) + 1;
                        }
                    } elseif($status === '2' && $candidate->signed_by_lec === '2') {
                        if($candidate->candidate_for === "Governor") {
                            $governors = 'not empty';
                            $count_positions->governor = ($count_positions->governor) + 1;
                        } elseif($candidate->candidate_for === "Vice Governor") {
                            $vice_governors = 'not empty';
                            $count_positions->vice_governor = ($count_positions->vice_governor) + 1;
                        } elseif($candidate->candidate_for === "Provincal Board Member") {
                            $board_members = 'not empty';
                            $count_positions->board_members = ($count_positions->board_members) + 1;
                        }
                    }
                }

                if($status === '0') {
                    foreach($candidates as $candidate) {
                        if($candidate->signed_by_lec == $status)
                            $status_page = $status;
                    }
                    return view('lec.status.pending', compact(
                        'candidates',
                        'governor',
                        'vice_governor',
                        'board_members',
                        'positions',
                        'count_positions',
                        'location',
                        'status_page'
                    ));
                } elseif($status === '1') {
                    foreach($candidates as $candidate) {
                        if($candidate->signed_by_lec == $status)
                            $status_page = $status;
                    }
                    return view('lec.status.approved', compact(
                        'candidates',
                        'governor',
                        'vice_governor',
                        'board_members',
                        'positions',
                        'count_positions',
                        'location',
                        'status_page'
                    ));
                } else {
                    foreach($candidates as $candidate) {
                        if($candidate->signed_by_lec == $status)
                            $status_page = $status;
                    }
                    return view('lec.status.rejected', compact(
                        'candidates',
                        'governor',
                        'vice_governor',
                        'board_members',
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
