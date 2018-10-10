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

        if ($lecId == '2018000') {
            $data = DB::table('huc')
                ->join('province as p', 'huc.province_code', '=', 'p.province_code')
                ->select('huc.*', DB::raw('(SELECT count(signed_by_lp) FROM candidates WHERE district_id = huc.district AND signed_by_lec = 0 AND province_id = huc.province_code) AS pending, (SELECT count(signed_by_lp) FROM candidates WHERE district_id = huc.district AND signed_by_lec = 1 AND province_id = huc.province_code) AS approved, (SELECT count(signed_by_lp) FROM candidates WHERE district_id = huc.district AND signed_by_lec = 2 AND province_id = huc.province_code) AS rejected, (SELECT name FROM lec WHERE id = p.lec AND p.province_code = huc.province_code) AS assigned_lec, (SELECT lgu FROM province WHERE province_code = "'. $code .'") AS province'))
                ->where('huc.province_code', '=', $code)
                ->orWhere('huc.parent_province_code', '=', $code)
                ->distinct('huc.id')
                ->get();
        }
        else {
            $data = DB::table('huc')
            ->join('province as p', 'huc.province_code', '=', 'p.province_code')
            ->select('huc.*', DB::raw('(SELECT count(signed_by_lp) FROM candidates WHERE district_id = huc.district AND signed_by_lec = 0 AND province_id = huc.province_code AND (candidate_for != "City Mayor" && candidate_for != "Governor" && candidate_for != "Congressman" && candidate_for != "HUC Congressman")) AS pending, (SELECT count(signed_by_lp) FROM candidates WHERE district_id = huc.district AND signed_by_lec = 1 AND province_id = huc.province_code AND (candidate_for != "City Mayor" && candidate_for != "Governor" && candidate_for != "Congressman" && candidate_for != "HUC Congressman")) AS approved, (SELECT count(signed_by_lp) FROM candidates WHERE district_id = huc.district AND signed_by_lec = 2 AND province_id = huc.province_code AND (candidate_for != "City Mayor" && candidate_for != "Governor" && candidate_for != "Congressman" && candidate_for != "HUC Congressman")) AS rejected, (SELECT name FROM lec WHERE id = p.lec AND p.province_code = huc.province_code) AS assigned_lec, (SELECT lgu FROM province WHERE province_code = "'. $code .'") AS province'))
            ->where('huc.province_code', '=', $code)
            ->where('huc.lec', '=', $lecId)
            ->orWhere('huc.parent_province_code', '=', $code)
            ->distinct('huc.id')
            ->get();
        }
        return $data;
    }

    public function hucs($code) {
        $userId = Auth::user()->id;
        $lec = DB::table('lec')->where('user', '=', $userId)->orWhere('user_2', '=', $userId)->first();
        $lecId = $lec->id;

        if ($lecId == '2018000') {
            $data = DB::table('huc')
                ->join('province as p', 'huc.province_code', '=', 'p.province_code')
                ->select('huc.*', DB::raw('(SELECT count(signed_by_lp) FROM candidates WHERE signed_by_lec = 0 AND ((province_id = huc.parent_province_code AND city_id = huc.city) OR province_id = huc.province_code)) AS pending, (SELECT count(signed_by_lp) FROM candidates WHERE signed_by_lec = 1 AND ((province_id = huc.parent_province_code AND city_id = huc.city) OR province_id = huc.province_code)) AS approved, (SELECT count(signed_by_lp) FROM candidates WHERE signed_by_lec = 2 AND ((province_id = huc.parent_province_code AND city_id = huc.city) OR province_id = huc.province_code)) AS rejected, (SELECT name FROM lec WHERE id = p.lec AND p.province_code = huc.province_code) AS assigned_lec'))
                ->where('huc.parent_province_code', '=', $code)
                ->distinct('huc.id')
                ->get();
        }
        else {
            $data = DB::table('huc')
                ->join('province as p', 'huc.province_code', '=', 'p.province_code')
                ->select('huc.*', DB::raw('(SELECT count(signed_by_lp) FROM candidates WHERE signed_by_lec = 0 AND ((province_id = huc.parent_province_code AND city_id = huc.city) OR province_id = huc.province_code) AND (candidate_for != "City Mayor" && candidate_for != "Governor" && candidate_for != "Congressman" && candidate_for != "HUC Congressman")) AS pending, (SELECT count(signed_by_lp) FROM candidates WHERE signed_by_lec = 1 AND ((province_id = huc.parent_province_code AND city_id = huc.city) OR province_id = huc.province_code) AND (candidate_for != "City Mayor" && candidate_for != "Governor" && candidate_for != "Congressman" && candidate_for != "HUC Congressman")) AS approved, (SELECT count(signed_by_lp) FROM candidates WHERE signed_by_lec = 2 AND ((province_id = huc.parent_province_code AND city_id = huc.city) OR province_id = huc.province_code) AND (candidate_for != "City Mayor" && candidate_for != "Governor" && candidate_for != "Congressman" && candidate_for != "HUC Congressman")) AS rejected, (SELECT name FROM lec WHERE id = p.lec AND p.province_code = huc.province_code) AS assigned_lec'))
                ->where('huc.parent_province_code', '=', $code)
                ->where('huc.lec', '=', $lecId)
                ->distinct('huc.id')
                ->get();
        }
        //$data = DB::table('huc')->where('province_code', '=', $code)->orWhere('parent_province_code', '=', $code)->get();
        return $data;
    }

    public function municipality($code) {
        $userId = Auth::user()->id;
        $lec = DB::table('lec')->where('user', '=', $userId)->orWhere('user_2', '=', $userId)->first();
        $lecId = $lec->id;

        if ($lecId == '2018000') {
            $data = DB::table('municipality as m')
                ->select('m.*', DB::raw('(SELECT count(signed_by_lp) FROM candidates WHERE city_id = m.municipality AND signed_by_lec = 0 AND province_id = '. $code .') AS pending, (SELECT count(signed_by_lp) FROM candidates WHERE city_id = m.municipality AND signed_by_lec = 1 AND province_id = '. $code .') AS approved, (SELECT count(signed_by_lp) FROM candidates WHERE city_id = m.municipality AND signed_by_lec = 2 AND province_id = '. $code .') AS rejected, (SELECT name FROM lec WHERE id = m.lec) AS assigned_lec, (SELECT lgu FROM province WHERE province_code = "'. $code .'") AS province'))
                ->where('m.province_code', '=', $code)
                ->get();
        }
        else {
            $data = DB::table('municipality as m')
                ->select('m.*', DB::raw('(SELECT count(signed_by_lp) FROM candidates WHERE city_id = m.municipality AND signed_by_lec = 0 AND province_id = '. $code .' AND (candidate_for != "City Mayor" && candidate_for != "Governor" && candidate_for != "Congressman" && candidate_for != "HUC Congressman")) AS pending, (SELECT count(signed_by_lp) FROM candidates WHERE city_id = m.municipality AND signed_by_lec = 1 AND province_id = '. $code .' AND (candidate_for != "City Mayor" && candidate_for != "Governor" && candidate_for != "Congressman" && candidate_for != "HUC Congressman")) AS approved, (SELECT count(signed_by_lp) FROM candidates WHERE city_id = m.municipality AND signed_by_lec = 2 AND province_id = '. $code .' AND (candidate_for != "City Mayor" && candidate_for != "Governor" && candidate_for != "Congressman" && candidate_for != "HUC Congressman")) AS rejected, (SELECT name FROM lec WHERE id = m.lec) AS assigned_lec, (SELECT lgu FROM province WHERE province_code = "'. $code .'") AS province'))
                ->where('lec', '=', $lecId)
                ->where('m.province_code', '=', $code)
                ->get();
        }
        //$data = DB::table('municipality')->get()->where('province_code', '=', $code)->where('lec', '=', $lecId);
        return $data;
    }

    public function district($code) {
        $userId = Auth::user()->id;
        $lec = DB::table('lec')->where('user', '=', $userId)->orWhere('user_2', '=', $userId)->first();
        $lecId = $lec->id;

        if ($lecId == '2018000') {
            $data = DB::table('municipality as m')
                ->select('m.*', DB::raw('(SELECT count(signed_by_lp) FROM candidates WHERE district_id = m.district AND signed_by_lec = 0 AND province_id = m.province_code) AS pending, (SELECT count(signed_by_lp) FROM candidates WHERE district_id = m.district AND signed_by_lec = 1 AND province_id = m.province_code) AS approved, (SELECT count(signed_by_lp) FROM candidates WHERE district_id = m.district AND signed_by_lec = 2 AND province_id = m.province_code) AS rejected, (SELECT name FROM lec WHERE id = m.lec) AS assigned_lec'))
                ->groupBy('m.district')
                ->where('m.province_code', '=', $code)
                ->get();
        }
        else {
            $data = DB::table('municipality as m')
                ->select('m.*', DB::raw('(SELECT count(signed_by_lp) FROM candidates WHERE district_id = m.district AND signed_by_lec = 0 AND province_id = m.province_code AND (candidate_for != "City Mayor" && candidate_for != "Governor" && candidate_for != "Congressman" && candidate_for != "HUC Congressman")) AS pending, (SELECT count(signed_by_lp) FROM candidates WHERE district_id = m.district AND signed_by_lec = 1 AND province_id = m.province_code AND (candidate_for != "City Mayor" && candidate_for != "Governor" && candidate_for != "Congressman" && candidate_for != "HUC Congressman")) AS approved, (SELECT count(signed_by_lp) FROM candidates WHERE district_id = m.district AND signed_by_lec = 2 AND province_id = m.province_code AND (candidate_for != "City Mayor" && candidate_for != "Governor" && candidate_for != "Congressman" && candidate_for != "HUC Congressman")) AS rejected, (SELECT name FROM lec WHERE id = m.lec) AS assigned_lec'))
                ->groupBy('m.district')
                ->where('lec', '=', $lecId)
                ->where('m.province_code', '=', $code)
                ->get();
        }
        //$data = DB::table('municipality')->get()->where('province_code', '=', $code)->where('lec', '=', $lecId);
        return $data;
    }

    public function cc($code) {
        return null;
    }

    public function city($code) {
        $userId = Auth::user()->id;
        $lec = DB::table('lec')->where('user', '=', $userId)->orWhere('user_2', '=', $userId)->first();
        $lecId = $lec->id;

        if ($lecId == '2018000') {
            $data = DB::table('city')
                ->select('city.*', DB::raw('(SELECT count(signed_by_lp) FROM candidates WHERE city_id = city.city AND signed_by_lec = 0 AND province_id = '. $code .') AS pending, (SELECT count(signed_by_lp) FROM candidates WHERE city_id = city.city AND signed_by_lec = 1 AND province_id = '. $code .') AS approved, (SELECT count(signed_by_lp) FROM candidates WHERE city_id = city.city AND signed_by_lec = 2 AND province_id = '. $code .') AS rejected, (SELECT name FROM lec WHERE id = city.lec) AS assigned_lec'))
                ->where('city.province_code', '=', $code)
                ->get();
        }
        else {
            $data = DB::table('city')
                ->select('city.*', DB::raw('(SELECT count(signed_by_lp) FROM candidates WHERE city_id = city.city AND signed_by_lec = 0 AND province_id = '. $code .' AND (candidate_for != "City Mayor" && candidate_for != "Governor" && candidate_for != "Congressman" && candidate_for != "HUC Congressman")) AS pending, (SELECT count(signed_by_lp) FROM candidates WHERE city_id = city.city AND signed_by_lec = 1 AND province_id = '. $code .' AND (candidate_for != "City Mayor" && candidate_for != "Governor" && candidate_for != "Congressman" && candidate_for != "HUC Congressman")) AS approved, (SELECT count(signed_by_lp) FROM candidates WHERE city_id = city.city AND signed_by_lec = 2 AND province_id = '. $code .' AND (candidate_for != "City Mayor" && candidate_for != "Governor" && candidate_for != "Congressman" && candidate_for != "HUC Congressman")) AS rejected, (SELECT name FROM lec WHERE id = city.lec) AS assigned_lec'))
                ->where('lec', '=', $lecId)
                ->where('city.province_code', '=', $code)
                ->get();
        }
        //$data = DB::table('city')->get()->where('province_code', '=', $code)->where('lec', '=', $lecId);
        return $data;
    }

    public function region($code) {
        $userId = Auth::user()->id;
        $lec = DB::table('lec')->where('user', '=', $userId)->orWhere('user_2', '=', $userId)->first();
        $lecId = $lec->id;

        if ($code == 'NCR') {
            if ($lecId == '2018000') {
                $data = DB::table('province as p')
                    ->select('p.*', DB::raw('(SELECT count(signed_by_lp) FROM candidates WHERE signed_by_lec = 0 AND province_id = p.province_code) AS pending, (SELECT count(signed_by_lp) FROM candidates WHERE signed_by_lec = 1 AND province_id = p.province_code) AS approved, (SELECT count(signed_by_lp) FROM candidates WHERE signed_by_lec = 2 AND province_id = p.province_code) AS rejected, (SELECT name FROM lec WHERE id = p.lec) AS assigned_lec'))
                    ->where('p.province_code', '!=', '1374')
                    ->where('p.region', '=', $code)
                    ->get();
            }
            else {
                $data = DB::table('province as p')
                    ->select('p.*', DB::raw('(SELECT count(signed_by_lp) FROM candidates WHERE signed_by_lec = 0 AND province_id = p.province_code AND (candidate_for != "City Mayor" && candidate_for != "Governor" && candidate_for != "Congressman" && candidate_for != "HUC Congressman")) AS pending, (SELECT count(signed_by_lp) FROM candidates WHERE signed_by_lec = 1 AND province_id = p.province_code AND (candidate_for != "City Mayor" && candidate_for != "Governor" && candidate_for != "Congressman" && candidate_for != "HUC Congressman")) AS approved, (SELECT count(signed_by_lp) FROM candidates WHERE signed_by_lec = 2 AND province_id = p.province_code AND (candidate_for != "City Mayor" && candidate_for != "Governor" && candidate_for != "Congressman" && candidate_for != "HUC Congressman")) AS rejected, (SELECT name FROM lec WHERE id = p.lec) AS assigned_lec'))
                    ->where('p.province_code', '!=', '1374')
                    ->where('p.region', '=', $code)
                    ->where('lec', '=', $lecId)
                    ->get();
            }
            //$data = DB::table('province')->get()->where('region', '=', $code)->where('lec', '=', $lecId);
        }
        else {
            if ($lecId == '2018000') {
                $data = DB::table('province as p')
                    ->select('p.*', DB::raw('(SELECT count(signed_by_lp) FROM candidates WHERE signed_by_lec = 0 AND ("%"+province_id+"%" like p.province_code OR province_id = p.province_code)) AS pending, (SELECT count(signed_by_lp) FROM candidates WHERE signed_by_lec = 1 AND ("%"+province_id+"%" like p.province_code OR province_id = p.province_code)) AS approved, (SELECT count(signed_by_lp) FROM candidates WHERE signed_by_lec = 2 AND ("%"+province_id+"%" like p.province_code OR province_id = p.province_code)) AS rejected, (SELECT name FROM lec WHERE id = p.lec) AS assigned_lec'))
                    ->where('p.region', '=', $code)
                    ->where('type', '<>', 'HUC')
                    ->get();
            }
            else {
                $data = DB::table('province as p')
                    ->select('p.*', DB::raw('(SELECT count(signed_by_lp) FROM candidates WHERE signed_by_lec = 0 AND ("%"+province_id+"%" like p.province_code OR province_id = p.province_code) AND (candidate_for != "City Mayor" && candidate_for != "Governor" && candidate_for != "Congressman" && candidate_for != "HUC Congressman")) AS pending, (SELECT count(signed_by_lp) FROM candidates WHERE signed_by_lec = 1 AND ("%"+province_id+"%" like p.province_code OR province_id = p.province_code) AND (candidate_for != "City Mayor" && candidate_for != "Governor" && candidate_for != "Congressman" && candidate_for != "HUC Congressman")) AS approved, (SELECT count(signed_by_lp) FROM candidates WHERE signed_by_lec = 2 AND ("%"+province_id+"%" like p.province_code OR province_id = p.province_code) AND (candidate_for != "City Mayor" && candidate_for != "Governor" && candidate_for != "Congressman" && candidate_for != "HUC Congressman")) AS rejected, (SELECT name FROM lec WHERE id = p.lec) AS assigned_lec'))
                    ->where('p.region', '=', $code)
                    ->where('lec', 'like', '%'.$lecId.'%')
                    ->where('type', '<>', 'HUC')
                    ->get();
            }
        }
        return $data;
    }

    public static function lec_candidate($province_code, $type, $city) {

        if($type == 'province' || $type == 'huc_district') {
            $query = DB::table('province AS pv')
                ->join('lec AS lc', 'pv.lec', '=', 'lc.id')
                ->select('lc.name')
                ->where('pv.province_code', '=', $province_code)
                ->limit(1)
                ->get();

            if(count($query) > 0) {
                return $query[0]->name;
            } else {
                return 'NO ASSIGNED LEC';
            }

        } elseif($type == 'district') {

            $query = DB::table('municipality AS muni')
                ->join('lec AS lc', 'muni.lec', '=', 'lc.id')
                ->select('lc.name')
                ->where('muni.province_code', '=', $province_code)
                ->where('muni.district', '=', $city)
                ->limit(1)
                ->get();

            if(count($query) > 0) {
                return $query[0]->name;
            } else {
                return 'NO ASSIGNED LEC';
            }

        } elseif($type == 'municipal') {
            $query = DB::table('municipality AS muni')
                ->join('lec AS lc', 'muni.lec', '=', 'lc.id')
                ->select('lc.name')
                ->where('muni.province_code', '=', $province_code)
                ->where('muni.municipality', '=', $city)
                ->limit(1)
                ->get();

            if(count($query) > 0) {
                return $query[0]->name;
            } else {
                return 'NO ASSIGNED LEC';
            }

        } elseif($type == 'component_city') {
            $query = DB::table('city AS ct')
                ->join('lec AS lc', 'ct.lec', '=', 'lc.id')
                ->select('lc.name')
                ->where('ct.province_code', '=', $province_code)
                ->where('ct.city', '=', $city)
                ->limit(1)
                ->get();

            if(count($query) > 0) {
                return $query[0]->name;
            } else {
                return 'NO ASSIGNED LEC';
            }
        } 


    }

    //Get City/Municipality Candidate
    public function candidate(Request $request) {
        $userId = Auth::user()->id;
        $lec = DB::table('lec')->where('user', '=', $userId)->orWhere('user_2', '=', $userId)->first();
        $lecId = $lec->id;

        $lec = new LECController;

        if($request->ajax()) {

            $provinceCode = $request->input('provinceCode');
            $requesType = $request->input('requesType');
            $city = $request->input('name');
            $region = $request->input('region');

            $mayor = array();
            $vmayor = array();
            $councilor = array();

            if($requesType == 'MUNICIPAL') {
                $lec_type = 'municipal';
                $lec_city = $city;
            } elseif($requesType == 'CC') {
                $lec_type = 'component_city';
                $lec_city = $city;
            } elseif($requesType == 'HUC') {
                $lec_type = 'huc';
                $lec_city = $city;
            } else {
                $lec_type = 'huc_district';
                $lec_city = '';
            }

            $province = DB::table('province')->where('province_code', $provinceCode)->first();

            if($requesType == 'HUC' || $requesType == 'CC' || $requesType == 'MUNICIPAL' || $requesType == 'ICC') {
                if ($requesType == 'HUC' && $region == 'NCR') {
                    $query = DB::table('candidates')
                        ->where('province_id', '=', $provinceCode)
                        ->get();
                }
                else {
                    $query = DB::table('candidates')
                        ->where('province_id', '=', $provinceCode)
                        ->where('city_id', '=', $lec_city)
                        ->get();
                }
                
                if(count($query) > 0) {
                    foreach ($query as $rows => $row) {
                        if($row->candidate_for == 'City Mayor' || $row->candidate_for == 'Municipal Mayor') {
                            if ($lecId == '2018000' || $row->candidate_for == 'Municipal Mayor') {
                                if ($row->signed_by_lp == 1) {
                                    $mayor[] = array(
                                        'id' => $row->id,
                                        'name' => $row->firstname . ' ' . $row->middlename . ' ' . $row->lastname,
                                        'status' => 'Approved' 
                                    );
                                } elseif ($row->signed_by_lp != 2) {
                                    $mayor[] = array(
                                        'id' => $row->id,
                                        'name' => $row->firstname . ' ' . $row->middlename . ' ' . $row->lastname,
                                        'status' => $row->signed_by_lec == 0 ? 'Pending' : $row->signed_by_lec
                                    );
                                }
                            }
                        } elseif ($row->candidate_for == 'City Vice Mayor' || $row->candidate_for == 'Municipal Vice Mayor') {
                            if ($province->lec == $lecId || $lecId == '2018000') {
                                if ($row->signed_by_lp == 1) {
                                    $vmayor[] = array(
                                        'id' => $row->id,
                                        'name' => $row->firstname . ' ' . $row->middlename . ' ' . $row->lastname,
                                        'status' => 'Approved' 
                                    );
                                } elseif($row->signed_by_lp != 2) {
                                    $vmayor[] = array(
                                        'id' => $row->id,
                                        'name' => $row->firstname . ' ' . $row->middlename . ' ' . $row->lastname,
                                        'status' => $row->signed_by_lec == 0 ? 'Pending' : $row->signed_by_lec
                                    );
                                }
                            }
                        } else if($row->candidate_for == 'City Councilor' || $row->candidate_for == 'Municipal Councilor') {
                            if ($province->lec == $lecId || $lecId == '2018000') {
                                if($row->signed_by_lp == 1) {
                                    $councilor[] = array(
                                        'id' => $row->id,
                                        'name' => $row->firstname . ' ' . $row->middlename . ' ' . $row->lastname,
                                        'status' => 'Approved'
                                    );
                                } elseif($row->signed_by_lp != 2) {
                                    $councilor[] = array(
                                        'id' => $row->id,
                                        'name' => $row->firstname . ' ' . $row->middlename . ' ' . $row->lastname, 
                                        'status' => $row->signed_by_lec == 0 ? 'Pending' : $row->signed_by_lec
                                    );
                                }
                            }
                        } 
                    }
                    return response()->json(['mayor' => $mayor, 'vmayor' => $vmayor, 'councilor' => $councilor, 'lec' => $lec->lec_candidate($provinceCode, $lec_type, $lec_city)]);
                } else {
                    return response()->json(['mayor' => $mayor, 'vmayor' => $vmayor, 'councilor' => $councilor, 'lec' => $lec->lec_candidate($provinceCode, $lec_type, $lec_city), 'pass' => $requesType]);
                }

            }
        }

        //     return response()->json(['warning' => 'Invalid request.']);
    }

    public function districtCandidate(Request $request) {
        $userId = Auth::user()->id;
        $lec = DB::table('lec')->where('user', '=', $userId)->orWhere('user_2', '=', $userId)->first();
        $lecId = $lec->id;

        $lec = new LECController;

        if($request->ajax()) {
            
            $provinceCode = $request->input('provinceCode');
            $district = $request->input('district');
            $type = $request->input('type');

            $query = DB:: table('candidates')
                ->where('province_id', '=', $provinceCode)
                ->where('district_id', '=', $district)
                ->get();

            $congressman = array();
            $councilor = array();
            $bmember = array();
            $prvcongressman = array();

            $province = DB::table('province')->where('province_code', $provinceCode)->first();

            if($type == 'HUC DISTRICT') {
                $lec_type = 'huc_district';
                $lec_city = '';
            } elseif($type == 'DISTRICT') {
                $lec_type = 'district';
                $lec_city = $district;
            } elseif($type == 'CC') {
                $lec_type = 'component_city';
                $lec_city = '';
            } else {
                $lec_type = 'municipal';
                $lec_city = $district;
            }

            if(count($query) > 0) {
                foreach($query as $rows => $row) {
                    if($row->candidate_for == 'HUC Congressman' && $lecId == '2018000') {
                        if($row->signed_by_lp == 1) {
                            $congressman[] = array(
                                'id' => $row->id,
                                'name' => $row->firstname . ' ' . $row->middlename . ' ' . $row->lastname,
                                'status' => 'Approved'
                            );
                        }
                        elseif($row->signed_by_lp != 2) {
                            $congressman[] = array(
                                'id' => $row->id,
                                'name' => $row->firstname . ' ' . $row->middlename . ' ' . $row->lastname,
                                'status' => $row->signed_by_lec == 0 ? 'Pending' : $row->signed_by_lec
                            );
                        }
                    } else if($row->candidate_for == 'City Councilor' && ($province->lec == $lecId || $lecId == '2018000')) {
                        if ($row->signed_by_lp == 1) {
                            $councilor[] = array(
                                'id' => $row->id,
                                'name' => $row->firstname . ' ' . $row->middlename . ' ' . $row->lastname, 
                                'status' => 'Approved'
                            );
                        }
                        elseif($row->signed_by_lp != 2) {
                            $councilor[] = array(
                                'id' => $row->id,
                                'name' => $row->firstname . ' ' . $row->middlename . ' ' . $row->lastname, 
                                'status' => $row->signed_by_lec == 0 ? 'Pending' : $row->signed_by_lec
                            );
                        }
                    } else if ($row->candidate_for == 'Board Member' && ($province->lec == $lecId || $lecId == '2018000')) {
                        if($row->signed_by_lp == 1) {
                            $bmember[] = array(
                                'id' => $row->id,
                                'name' => $row->firstname . ' ' . $row->middlename . ' ' . $row->lastname,
                                'status' => 'Approved'
                            );
                        }
                        elseif($row->signed_by_lp != 2) {
                            $bmember[] = array(
                                'id' => $row->id,
                                'name' => $row->firstname . ' ' . $row->middlename . ' ' . $row->lastname,
                                'status' => $row->signed_by_lec == 0 ? 'Pending' : $row->signed_by_lec
                            );
                        }
                    } else if ($row->candidate_for == 'Congressman' && $lecId == '2018000') {
                        if ($row->signed_by_lp == 1) {
                            $prvcongressman[] = array(
                                'id' => $row->id,
                                'name' => $row->firstname . ' ' . $row->middlename . ' ' . $row->lastname,
                                'status' => 'Approved'
                            );
                        }
                        elseif($row->signed_by_lp != 2) {
                            $prvcongressman[] = array(
                                'id' => $row->id,
                                'name' => $row->firstname . ' ' . $row->middlename . ' ' . $row->lastname,
                                'status' => $row->signed_by_lec == 0 ? 'Pending' : $row->signed_by_lec
                            );
                        }
                    }
                }
                return response()->json(['congressman' => $congressman, 'councilor' => $councilor, 'provCongressman' => $prvcongressman, 'bmember' => $bmember, 'lec' => $lec->lec_candidate($provinceCode, $lec_type, $lec_city)]);
            } else {
                return response()->json(['congressman' => $congressman, 'councilor' => $councilor, 'provCongressman' => $prvcongressman, 'bmember' => $bmember, 'lec' => $lec->lec_candidate($provinceCode, $lec_type, $lec_city)]);
            }      

        } else {

            return response()->json(['warning' => 'Invalid request.']);

        }

    }

    public function governor(Request $request) {

        $userId = Auth::user()->id;
        $lec = DB::table('lec')->where('user', '=', $userId)->orWhere('user_2', '=', $userId)->first();
        $lecId = $lec->id;

        $lec = new LECController;

        if($request->ajax()) {

            $provinceCode = $request->input('provinceCode');
            $requesType = $request->input('requesType');

            $province = DB::table('province')->where('province_code', $provinceCode)->first();

            if($requesType == 'PROVINCE') {

                $query = DB::table('candidates')
                    ->where('province_id', '=', $provinceCode)
                    ->get();

                $governor = array();
                $vgovernor = array();

                if(count($query) > 0) {
                    foreach ($query as $rows => $row) {
                        if($row->candidate_for == 'Governor' && $lecId == '2018000') {
                            if ($row->signed_by_lp == 1) {
                                $governor[] = array(
                                    'id' => $row->id,
                                    'name' => $row->firstname . ' ' . $row->middlename . ' ' . $row->lastname,
                                    'status' => 'Approved'
                                );
                            }
                            elseif($row->signed_by_lp != 2) {
                                $governor[] = array(
                                    'id' => $row->id,
                                    'name' => $row->firstname . ' ' . $row->middlename . ' ' . $row->lastname,
                                    'status' => $row->signed_by_lec == 0 ? 'Pending' : $row->signed_by_lec
                                );
                            }
                            
                        } else if ($row->candidate_for == 'Vice Governor' && ($province->lec == $lecId || $lecId == '2018000')) {
                            if ($row->signed_by_lp == 1) {
                                $vgovernor[] = array(
                                    'id' => $row->id,
                                    'name' => $row->firstname . ' ' . $row->middlename . ' ' . $row->lastname,
                                    'status' => 'Approved'
                                );
                            }
                            elseif($row->signed_by_lp != 2) {
                                $vgovernor[] = array(
                                    'id' => $row->id,
                                    'name' => $row->firstname . ' ' . $row->middlename . ' ' . $row->lastname,
                                    'status' => $row->signed_by_lec == 0 ? 'Pending' : $row->signed_by_lec
                                );
                            }
                        }
                    }
                    return response()->json(['governor' => $governor, 'vgovernor' => $vgovernor, 'lec' => $lec->lec_candidate($provinceCode, 'province', '')]);
                } else {
                    return response()->json(['governor' => $governor, 'vgovernor' => $vgovernor, 'lec' => $lec->lec_candidate($provinceCode, 'province', '')]);
                }

            } else {

                return response()->json(['warning' => 'Invalid request.']); 

            }

        } else {

            return response()->json(['warning' => 'Invalid Request']);

        }

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

        if ($lecId == '2018000') {
            $province_table = DB::table('province')->where('province_code','!=','1374')->get();
        }
        else {
            $province_table = DB::table('province')->where('lec', 'like', '%'.$lecId.'%')->get();
        }

        $province_arr = array();
        foreach($province_table as $prov) {
            array_push($province_arr, $prov->province_code);
        }

        if($region == "ph"){
            $location = "All Region";
            $governor = 'empty';
            $vice_governor = 'empty';
            $board_member = 'empty';
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
                'board_member' => 0,
                'congressman' => 0,
                'HUC_congressman' => 0,
                'city_mayor' => 0,
                'city_vice_mayor' => 0,
                'city_councilor' => 0,
                'municipal_mayor' => 0,
                'municipal_vice_mayor' => 0,
                'municipal_councilor' => 0
            );
            $positions = array('governor','vice_governor','board_member','congressman','HUC_congressman','city_mayor','city_vice_mayor','city_councilor','municipal_mayor','municipal_vice_mayor','municipal_councilor');
            
            $candidates = DB::table('candidates')
                                ->where('signed_by_lec',$status)
                                ->whereIn('province_id',$province_arr)
                                ->get();

            foreach($candidates as $candidate) {
                if($candidate->candidate_for === "Governor") {
                    $governors = 'not empty';
                    $count_positions->governor = ($count_positions->governor) + 1;
                } elseif($candidate->candidate_for === "Vice Governor") {
                    $vice_governors = 'not empty';
                    $count_positions->vice_governor = ($count_positions->vice_governor) + 1;
                } elseif($candidate->candidate_for === "Board Member") {
                    $board_member = 'not empty';
                    $count_positions->board_member = ($count_positions->board_member) + 1;
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

                if($candidate->signed_by_lec == $status)
                    $status_page = $status;

                if($candidate->candidate_for == 'Governor' ||
                    $candidate->candidate_for == 'Vice Governor' ||
                    $candidate->candidate_for == 'Board Member' ||
                    $candidate->candidate_for == 'HUC Congressman')
                {
                    $lec_id_province = DB::table('province')
                        ->where('province_code',$candidate->province_id)
                        ->first();

                    if(strpos($lec_id_province->lec, ",") !== false) {
                        $lec_id_prov = explode(",", $lec_id_province->lec);
                        if(is_numeric($lec_id_prov[0])) {
                            $lec_id = DB::table('lec')
                                ->where('id',$lec_id_prov[0])
                                ->first();
                            $candidate->lec = $lec_id->name;
                        } else {
                            $candidate->lec = $lec_id_prov[0];
                        }
                    } else {
                        if(is_numeric($lec_id_province->lec)) {
                            $lec_id = DB::table('lec')
                                ->where('id',$lec_id_province->lec)
                                ->first();
                            $candidate->lec = $lec_id->name;
                        } else {
                            $candidate->lec = $lec_id_province->lec;
                        }
                    }
                } elseif($candidate->candidate_for == 'City Mayor' ||
                    $candidate->candidate_for == 'City Vice Mayor' ||
                    $candidate->candidate_for == 'City Councilor')
                {   
                    if(strpos($candidate->province_id, "-") !== false) {
                        $lec_id_province = DB::table('huc')
                            ->where('province_code',$candidate->province_id)
                            ->first();
                    } else {
                        $lec_id_province = DB::table('province')
                            ->where('province_code',$candidate->province_id)
                            ->first();
                    }

                    if(strpos($lec_id_province->lec, ",") !== false) {
                        $lec_id_prov = explode(",", $lec_id_province->lec);
                        if(is_numeric($lec_id_prov[0])) {
                            $lec_id = DB::table('lec')
                                ->where('id',$lec_id_prov[0])
                                ->first();
                            $candidate->lec = $lec_id->name;
                        } else {
                            $candidate->lec = $lec_id_prov[0];
                        }
                    } else {
                        if(is_numeric($lec_id_province->lec)) {
                            $lec_id = DB::table('lec')
                                ->where('id',$lec_id_province->lec)
                                ->first();
                            $candidate->lec = $lec_id->name;
                        } else {
                            $candidate->lec = $lec_id_province->lec;
                        }
                    }
                } elseif($candidate->candidate_for == 'Municipal Mayor' ||
                    $candidate->candidate_for == 'Municipal Vice Mayor' ||
                    $candidate->candidate_for == 'Municipal Councilor')
                {
                    $lec_id_province = DB::table('municipality')
                        ->where('province_code',$candidate->province_id)
                        ->where('district',$candidate->district_id)
                        ->where('municipality',strtoupper($candidate->city_id))
                        ->first();
                        
                    if(is_numeric($lec_id_province->lec)) {
                        $lec_id = DB::table('lec')
                            ->where('id',$lec_id_province->lec)
                            ->first();
                        $candidate->lec = $lec_id->name;
                    } else {
                        $candidate->lec = $lec_id_province->lec;
                    }
                } elseif($candidate->candidate_for == 'Congressman') {
                    $lec_id_province = DB::table('municipality')
                        ->where('province_code',$candidate->province_id)
                        ->where('district',$candidate->district_id)
                        ->first();

                    if(is_numeric($lec_id_province->lec)) {
                        $lec_id = DB::table('lec')
                            ->where('id',$lec_id_province->lec)
                            ->first();
                        $candidate->lec = $lec_id->name;
                    } else {
                        $candidate->lec = $lec_id_province->lec;
                    }
                }

                if($candidate->candidate_for == 'Senator') {
                    $candidate->location = "Philippines";
                } else {
                    $candidate_provinceLGU = DB::table('province')
                        ->where('province_code',$candidate->province_id)
                        ->first();
                    if($candidate->city_id) {
                        if($candidate->district_id) {
                            $candidate->location = ucwords(strtolower($candidate_provinceLGU->lgu)).', '
                                .ucwords(strtolower($candidate->city_id)).', '
                                .$candidate->district_id;
                        } else {
                            $candidate->location = ucwords(strtolower($candidate_provinceLGU->lgu)).', '
                                .ucwords(strtolower($candidate->city_id));
                        }
                    } else {
                        $candidate->location = ucwords(strtolower($candidate_provinceLGU->lgu));
                    }
                }
            }

            if($status == '0'){
                return view('lec.status.pending', compact(
                    'candidates',
                    'governor',
                    'vice_governor',
                    'board_member',
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
                return view('lec.status.approved', compact(
                    'candidates',
                    'governor',
                    'vice_governor',
                    'board_member',
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
                return view('lec.status.rejected', compact(
                    'candidates',
                    'governor',
                    'vice_governor',
                    'board_member',
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

            if ($lecId == '2018000') {
                $province_region = DB::table('province')
                                    ->where('province_code','!=','1374')
                                    ->where('region',$region)
                                    ->get();
            } else {
                $province_region = DB::table('province')
                                    ->where('region',$region)
                                    ->where('lec', 'like', '%'.$lecId.'%')
                                    ->get();
            }

            $provinces_id = array();
            foreach($province_region as $prov_regs){
                array_push($provinces_id, $prov_regs->province_code);
            }
            $candidates = DB::table('candidates')
                            ->whereIn('province_id',$provinces_id)
                            ->where('signed_by_lec',$status)
                            ->get();
            $governor = 'empty';
            $vice_governor = 'empty';
            $board_member = 'empty';
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
                'board_member' => 0,
                'congressman' => 0,
                'HUC_congressman' => 0,
                'city_mayor' => 0,
                'city_vice_mayor' => 0,
                'city_councilor' => 0,
                'municipal_mayor' => 0,
                'municipal_vice_mayor' => 0,
                'municipal_councilor' => 0
            );
            $positions = array('governor','vice_governor','board_member','congressman','HUC_congressman','city_mayor','city_vice_mayor','city_councilor','municipal_mayor','municipal_vice_mayor','municipal_councilor');

            foreach($candidates as $candidate){
                if($candidate->candidate_for === "Governor") {
                    $governors = 'not empty';
                    $count_positions->governor = ($count_positions->governor) + 1;
                } elseif($candidate->candidate_for === "Vice Governor") {
                    $vice_governors = 'not empty';
                    $count_positions->vice_governor = ($count_positions->vice_governor) + 1;
                } elseif($candidate->candidate_for === "Board Member") {
                    $board_member = 'not empty';
                    $count_positions->board_member = ($count_positions->board_member) + 1;
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

                if($candidate->signed_by_lec == $status)
                    $status_page = $status;

                if($candidate->candidate_for == 'Governor' ||
                    $candidate->candidate_for == 'Vice Governor' ||
                    $candidate->candidate_for == 'Board Member' ||
                    $candidate->candidate_for == 'HUC Congressman')
                {
                    $lec_id_province = DB::table('province')
                        ->where('province_code',$candidate->province_id)
                        ->first();

                    if(strpos($lec_id_province->lec, ",") !== false) {
                        $lec_id_prov = explode(",", $lec_id_province->lec);
                        if(is_numeric($lec_id_prov[0])) {
                            $lec_id = DB::table('lec')
                                ->where('id',$lec_id_prov[0])
                                ->first();
                            $candidate->lec = $lec_id->name;
                        } else {
                            $candidate->lec = $lec_id_prov[0];
                        }
                    } else {
                        if(is_numeric($lec_id_province->lec)) {
                            $lec_id = DB::table('lec')
                                ->where('id',$lec_id_province->lec)
                                ->first();
                            $candidate->lec = $lec_id->name;
                        } else {
                            $candidate->lec = $lec_id_province->lec;
                        }
                    }
                } elseif($candidate->candidate_for == 'City Mayor' ||
                    $candidate->candidate_for == 'City Vice Mayor' ||
                    $candidate->candidate_for == 'City Councilor')
                {   
                    if(strpos($candidate->province_id, "-") !== false) {
                        $lec_id_province = DB::table('huc')
                            ->where('province_code',$candidate->province_id)
                            ->first();
                    } else {
                        $lec_id_province = DB::table('province')
                            ->where('province_code',$candidate->province_id)
                            ->first();
                    }

                    if(strpos($lec_id_province->lec, ",") !== false) {
                        $lec_id_prov = explode(",", $lec_id_province->lec);
                        if(is_numeric($lec_id_prov[0])) {
                            $lec_id = DB::table('lec')
                                ->where('id',$lec_id_prov[0])
                                ->first();
                            $candidate->lec = $lec_id->name;
                        } else {
                            $candidate->lec = $lec_id_prov[0];
                        }
                    } else {
                        if(is_numeric($lec_id_province->lec)) {
                            $lec_id = DB::table('lec')
                                ->where('id',$lec_id_province->lec)
                                ->first();
                            $candidate->lec = $lec_id->name;
                        } else {
                            $candidate->lec = $lec_id_province->lec;
                        }
                    }
                } elseif($candidate->candidate_for == 'Municipal Mayor' ||
                    $candidate->candidate_for == 'Municipal Vice Mayor' ||
                    $candidate->candidate_for == 'Municipal Councilor' ||
                    $candidate->candidate_for == 'Congressman')
                {
                    $lec_id_province = DB::table('municipality')
                        ->where('province_code',$candidate->province_id)
                        ->where('district',$candidate->district_id)
                        ->first();

                    if(is_numeric($lec_id_province->lec)) {
                        $lec_id = DB::table('lec')
                            ->where('id',$lec_id_province->lec)
                            ->first();
                        $candidate->lec = $lec_id->name;
                    } else {
                        $candidate->lec = $lec_id_province->lec;
                    }
                }

                if($candidate->candidate_for == 'Senator') {
                    $candidate->location = "Philippines";
                } else {
                    $candidate_provinceLGU = DB::table('province')
                        ->where('province_code',$candidate->province_id)
                        ->first();
                    if($candidate->city_id) {
                        if($candidate->district_id) {
                            $candidate->location = ucwords(strtolower($candidate_provinceLGU->lgu)).', '
                                .ucwords(strtolower($candidate->city_id)).', '
                                .$candidate->district_id;
                        } else {
                            $candidate->location = ucwords(strtolower($candidate_provinceLGU->lgu)).', '
                                .ucwords(strtolower($candidate->city_id));
                        }
                    } else {
                        $candidate->location = ucwords(strtolower($candidate_provinceLGU->lgu));
                    }
                }
            }

            if($status === '0') {
                return view('lec.status.pending', compact(
                    'candidates',
                    'governor',
                    'vice_governor',
                    'board_member',
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
                return view('lec.status.approved', compact(
                    'candidates',
                    'governor',
                    'vice_governor',
                    'board_member',
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
                return view('lec.status.rejected', compact(
                    'candidates',
                    'governor',
                    'vice_governor',
                    'board_member',
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
            if ($lecId == '2018000') {
                $province_table = DB::table('province')
                                    ->where('province_code',$province)
                                    ->first();
            } else {
                $province_table = DB::table('province')
                                    ->where('province_code',$province)
                                    ->where('lec', 'like', '%'.$lecId.'%')
                                    ->first();
            }
            $location = ucwords(strtolower($province_table->lgu));
            $location_type = $province_table->type;
            $candidates = DB::table('candidates')
                            ->where('province_id','like',$province.'%')
                            ->where('signed_by_lec',$status)
                            ->get();

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
                    if($candidate->candidate_for === "Congressman") {
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
                    }

                    if($candidate->signed_by_lec == $status)
                    $status_page = $status;

                    if($candidate->candidate_for == 'Governor' ||
                        $candidate->candidate_for == 'Vice Governor' ||
                        $candidate->candidate_for == 'Board Member' ||
                        $candidate->candidate_for == 'HUC Congressman')
                    {
                        $lec_id_province = DB::table('province')
                            ->where('province_code',$candidate->province_id)
                            ->first();

                        if(strpos($lec_id_province->lec, ",") !== false) {
                            $lec_id_prov = explode(",", $lec_id_province->lec);
                            if(is_numeric($lec_id_prov[0])) {
                                $lec_id = DB::table('lec')
                                    ->where('id',$lec_id_prov[0])
                                    ->first();
                                $candidate->lec = $lec_id->name;
                            } else {
                                $candidate->lec = $lec_id_prov[0];
                            }
                        } else {
                            if(is_numeric($lec_id_province->lec)) {
                                $lec_id = DB::table('lec')
                                    ->where('id',$lec_id_province->lec)
                                    ->first();
                                $candidate->lec = $lec_id->name;
                            } else {
                                $candidate->lec = $lec_id_province->lec;
                            }
                        }
                    } elseif($candidate->candidate_for == 'City Mayor' ||
                        $candidate->candidate_for == 'City Vice Mayor' ||
                        $candidate->candidate_for == 'City Councilor')
                    {   
                        if(strpos($candidate->province_id, "-") !== false) {
                            $lec_id_province = DB::table('huc')
                                ->where('province_code',$candidate->province_id)
                                ->first();
                        } else {
                            $lec_id_province = DB::table('province')
                                ->where('province_code',$candidate->province_id)
                                ->first();
                        }

                        if(strpos($lec_id_province->lec, ",") !== false) {
                            $lec_id_prov = explode(",", $lec_id_province->lec);
                            if(is_numeric($lec_id_prov[0])) {
                                $lec_id = DB::table('lec')
                                    ->where('id',$lec_id_prov[0])
                                    ->first();
                                $candidate->lec = $lec_id->name;
                            } else {
                                $candidate->lec = $lec_id_prov[0];
                            }
                        } else {
                            if(is_numeric($lec_id_province->lec)) {
                                $lec_id = DB::table('lec')
                                    ->where('id',$lec_id_province->lec)
                                    ->first();
                                $candidate->lec = $lec_id->name;
                            } else {
                                $candidate->lec = $lec_id_province->lec;
                            }
                        }
                    } elseif($candidate->candidate_for == 'Municipal Mayor' ||
                        $candidate->candidate_for == 'Municipal Vice Mayor' ||
                        $candidate->candidate_for == 'Municipal Councilor' ||
                        $candidate->candidate_for == 'Congressman')
                    {
                        $lec_id_province = DB::table('municipality')
                            ->where('province_code',$candidate->province_id)
                            ->where('district',$candidate->district_id)
                            ->first();

                        if(is_numeric($lec_id_province->lec)) {
                            $lec_id = DB::table('lec')
                                ->where('id',$lec_id_province->lec)
                                ->first();
                            $candidate->lec = $lec_id->name;
                        } else {
                            $candidate->lec = $lec_id_province->lec;
                        }
                    }

                    if($candidate->candidate_for == 'Senator') {
                        $candidate->location = "Philippines";
                    } else {
                        $candidate_provinceLGU = DB::table('province')
                            ->where('province_code',$candidate->province_id)
                            ->first();
                        if($candidate->city_id) {
                            if($candidate->district_id) {
                                $candidate->location = ucwords(strtolower($candidate_provinceLGU->lgu)).', '
                                    .ucwords(strtolower($candidate->city_id)).', '
                                    .$candidate->district_id;
                            } else {
                                $candidate->location = ucwords(strtolower($candidate_provinceLGU->lgu)).', '
                                    .ucwords(strtolower($candidate->city_id));
                            }
                        } else {
                            $candidate->location = ucwords(strtolower($candidate_provinceLGU->lgu));
                        }
                    }
                }

                if($status === '0') {
                    return view('lec.status.pending', compact(
                        'candidates',
                        'congressman',
                        'HUC_congressman',
                        'city_mayor',
                        'city_vice_mayor',
                        'city_councilor',
                        'positions',
                        'count_positions',
                        'location',
                        'status_page'
                    ));
                } elseif($status === '1') {
                    return view('lec.status.approved', compact(
                        'candidates',
                        'congressman',
                        'HUC_congressman',
                        'city_mayor',
                        'city_vice_mayor',
                        'city_councilor',
                        'positions',
                        'count_positions',
                        'location',
                        'status_page'
                    ));
                } else {
                    return view('lec.status.rejected', compact(
                        'candidates',
                        'congressman',
                        'HUC_congressman',
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
                $board_member = 'empty';
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
                    'board_member' => 0,
                    'congressman' => 0,
                    'HUC_congressman' => 0,
                    'city_mayor' => 0,
                    'city_vice_mayor' => 0,
                    'city_councilor' => 0,
                    'municipal_mayor' => 0,
                    'municipal_vice_mayor' => 0,
                    'municipal_councilor' => 0
                );
                $positions = array('governor','vice_governor','board_member','congressman','HUC_congressman','city_mayor','city_vice_mayor','city_councilor','municipal_mayor','municipal_vice_mayor','municipal_councilor');

                foreach($candidates as $candidate){
                    if($candidate->candidate_for === "Governor") {
                        $governors = 'not empty';
                        $count_positions->governor = ($count_positions->governor) + 1;
                    } elseif($candidate->candidate_for === "Vice Governor") {
                        $vice_governors = 'not empty';
                        $count_positions->vice_governor = ($count_positions->vice_governor) + 1;
                    } elseif($candidate->candidate_for === "Board Member") {
                        $board_member = 'not empty';
                        $count_positions->board_member = ($count_positions->board_member) + 1;
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

                    if($candidate->signed_by_lec == $status)
                        $status_page = $status;

                    if($candidate->candidate_for == 'Governor' ||
                        $candidate->candidate_for == 'Vice Governor' ||
                        $candidate->candidate_for == 'Board Member' ||
                        $candidate->candidate_for == 'HUC Congressman')
                    {
                        $lec_id_province = DB::table('province')
                            ->where('province_code',$candidate->province_id)
                            ->first();

                        if(strpos($lec_id_province->lec, ",") !== false) {
                            $lec_id_prov = explode(",", $lec_id_province->lec);
                            if(is_numeric($lec_id_prov[0])) {
                                $lec_id = DB::table('lec')
                                    ->where('id',$lec_id_prov[0])
                                    ->first();
                                $candidate->lec = $lec_id->name;
                            } else {
                                $candidate->lec = $lec_id_prov[0];
                            }
                        } else {
                            if(is_numeric($lec_id_province->lec)) {
                                $lec_id = DB::table('lec')
                                    ->where('id',$lec_id_province->lec)
                                    ->first();
                                $candidate->lec = $lec_id->name;
                            } else {
                                $candidate->lec = $lec_id_province->lec;
                            }
                        }
                    } elseif($candidate->candidate_for == 'City Mayor' ||
                        $candidate->candidate_for == 'City Vice Mayor' ||
                        $candidate->candidate_for == 'City Councilor')
                    {   
                        if(strpos($candidate->province_id, "-") !== false) {
                            $lec_id_province = DB::table('huc')
                                ->where('province_code',$candidate->province_id)
                                ->first();
                        } else {
                            $lec_id_province = DB::table('province')
                                ->where('province_code',$candidate->province_id)
                                ->first();
                        }

                        if(strpos($lec_id_province->lec, ",") !== false) {
                            $lec_id_prov = explode(",", $lec_id_province->lec);
                            if(is_numeric($lec_id_prov[0])) {
                                $lec_id = DB::table('lec')
                                    ->where('id',$lec_id_prov[0])
                                    ->first();
                                $candidate->lec = $lec_id->name;
                            } else {
                                $candidate->lec = $lec_id_prov[0];
                            }
                        } else {
                            if(is_numeric($lec_id_province->lec)) {
                                $lec_id = DB::table('lec')
                                    ->where('id',$lec_id_province->lec)
                                    ->first();
                                $candidate->lec = $lec_id->name;
                            } else {
                                $candidate->lec = $lec_id_province->lec;
                            }
                        }
                    } elseif($candidate->candidate_for == 'Municipal Mayor' ||
                        $candidate->candidate_for == 'Municipal Vice Mayor' ||
                        $candidate->candidate_for == 'Municipal Councilor' ||
                        $candidate->candidate_for == 'Congressman')
                    {
                        $lec_id_province = DB::table('municipality')
                            ->where('province_code',$candidate->province_id)
                            ->where('district',$candidate->district_id)
                            ->first();

                        if(is_numeric($lec_id_province->lec)) {
                            $lec_id = DB::table('lec')
                                ->where('id',$lec_id_province->lec)
                                ->first();
                            $candidate->lec = $lec_id->name;
                        } else {
                            $candidate->lec = $lec_id_province->lec;
                        }
                    }

                    if($candidate->candidate_for == 'Senator') {
                        $candidate->location = "Philippines";
                    } else {
                        $candidate_provinceLGU = DB::table('province')
                            ->where('province_code',$candidate->province_id)
                            ->first();
                        if($candidate->city_id) {
                            if($candidate->district_id) {
                                $candidate->location = ucwords(strtolower($candidate_provinceLGU->lgu)).', '
                                    .ucwords(strtolower($candidate->city_id)).', '
                                    .$candidate->district_id;
                            } else {
                                $candidate->location = ucwords(strtolower($candidate_provinceLGU->lgu)).', '
                                    .ucwords(strtolower($candidate->city_id));
                            }
                        } else {
                            $candidate->location = ucwords(strtolower($candidate_provinceLGU->lgu));
                        }
                    }
                }

                if($status === '0') {
                    return view('lec.status.pending', compact(
                        'candidates',
                        'governor',
                        'vice_governor',
                        'board_member',
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
                    return view('lec.status.approved', compact(
                        'candidates',
                        'governor',
                        'vice_governor',
                        'board_member',
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
                    return view('lec.status.rejected', compact(
                        'candidates',
                        'governor',
                        'vice_governor',
                        'board_member',
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

    public function senator() {
        $userId = Auth::user()->id;
        $lec = DB::table('lec')->where('user', '=', $userId)->orWhere('user_2', '=', $userId)->first();
        $lec_name = $lec->name;
        if($lec_name === 'Francis N. Pangilinan') {
            $senators = DB::table('candidates')
                ->where('candidate_for','Senator')
                ->where('signed_by_lec','!=',2)
                ->get();
            return view('lec.screening.senator')->with('senators',$senators);
        } else {
            return redirect()->action('LECController@lec_dashboard');
        }
    }

    public function redirect() {
        return view('lec.lec');
    }
}