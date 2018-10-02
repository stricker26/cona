<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LECController;
use DB;

class ScreeningController extends Controller
{
    public function screening() {
        return view('dashboard.screening.screening');
    }

    public function huc($code) {
        $data = DB::table('huc')
            ->join('province as p', 'huc.province_code', '=', 'p.province_code')
            ->select('huc.*', DB::raw('(SELECT count(signed_by_lp) FROM candidates WHERE district_id = huc.district AND signed_by_lp = 0 AND province_id = huc.province_code) AS pending, (SELECT count(signed_by_lp) FROM candidates WHERE district_id = huc.district AND signed_by_lp = 1 AND province_id = huc.province_code) AS approved, (SELECT count(signed_by_lp) FROM candidates WHERE district_id = huc.district AND signed_by_lp = 2 AND province_id = huc.province_code) AS rejected, (SELECT name FROM lec WHERE id = p.lec AND p.province_code = huc.province_code) AS assigned_lec'))
            ->where('huc.province_code', '=', $code)
            ->orWhere('huc.parent_province_code', '=', $code)
            ->distinct('huc.id')
            ->get();
         return $data;

    }

    public function hucs($code) {
        $data = DB::table('huc')
            ->join('province as p', 'huc.province_code', '=', 'p.province_code')
            ->select('huc.*', DB::raw('(SELECT count(signed_by_lp) FROM candidates WHERE city_id = huc.city AND signed_by_lp = 0 AND province_id = huc.parent_province_code) AS pending, (SELECT count(signed_by_lp) FROM candidates WHERE city_id = huc.city AND signed_by_lp = 1 AND province_id = huc.parent_province_code) AS approved, (SELECT count(signed_by_lp) FROM candidates WHERE city_id = huc.city AND signed_by_lp = 2 AND province_id = huc.parent_province_code) AS rejected, (SELECT name FROM lec WHERE id = p.lec AND p.province_code = huc.province_code) AS assigned_lec'))
            ->where('huc.parent_province_code', '=', $code)
            ->distinct('huc.id')
            ->get();
        //$data = DB::table('huc')->where('province_code', '=', $code)->orWhere('parent_province_code', '=', $code)->get();
        return $data;
    }

    public function municipality($code) {
        $data = DB::table('municipality as m')
            ->select('m.*', DB::raw('(SELECT count(signed_by_lp) FROM candidates WHERE city_id = m.municipality AND signed_by_lp = 0 AND province_id = '. $code .') AS pending, (SELECT count(signed_by_lp) FROM candidates WHERE city_id = m.municipality AND signed_by_lp = 1 AND province_id = '. $code .') AS approved, (SELECT count(signed_by_lp) FROM candidates WHERE city_id = m.municipality AND signed_by_lp = 2 AND province_id = '. $code .') AS rejected, (SELECT name FROM lec WHERE id = m.lec) AS assigned_lec'))
            ->where('m.province_code', '=', $code)
            ->get();
        return $data;
    }

    public function district($code) {
        $data = DB::table('municipality as m')
            ->select('m.*', DB::raw('(SELECT count(signed_by_lp) FROM candidates WHERE district_id = m.district AND signed_by_lp = 0 AND province_id = '. $code .') AS pending, (SELECT count(signed_by_lp) FROM candidates WHERE district_id = m.district AND signed_by_lp = 1 AND province_id = '. $code .') AS approved, (SELECT count(signed_by_lp) FROM candidates WHERE district_id = m.district AND signed_by_lp = 2 AND province_id = '. $code .') AS rejected, (SELECT name FROM lec WHERE id = m.lec) AS assigned_lec'))
            ->where('m.province_code', '=', $code)
            ->get();
        return $data;
    }

    public function city($code) {
        $data = DB::table('city')
            ->select('city.*', DB::raw('(SELECT count(signed_by_lp) FROM candidates WHERE city_id = city.city AND signed_by_lp = 0 AND province_id = '. $code .') AS pending, (SELECT count(signed_by_lp) FROM candidates WHERE city_id = city.city AND signed_by_lp = 1 AND province_id = '. $code .') AS approved, (SELECT count(signed_by_lp) FROM candidates WHERE city_id = city.city AND signed_by_lp = 2 AND province_id = '. $code .') AS rejected, (SELECT name FROM lec WHERE id = city.lec) AS assigned_lec'))
            ->where('city.province_code', '=', $code)
            ->get();

        return $data;
    }

    public function region($code) {
        if ($code == 'NCR') {
            $data = DB::table('province as p')
                ->select('p.*', DB::raw('(SELECT count(signed_by_lp) FROM candidates WHERE signed_by_lp = 0 AND province_id = p.province_code) AS pending, (SELECT count(signed_by_lp) FROM candidates WHERE signed_by_lp = 1 AND province_id = p.province_code) AS approved, (SELECT count(signed_by_lp) FROM candidates WHERE signed_by_lp = 2 AND province_id = p.province_code) AS rejected, (SELECT name FROM lec WHERE id = p.lec) AS assigned_lec'))
                ->where('p.region', '=', $code)
                ->get();
            //$data = DB::table('province')->get()->where('region', '=', $code);
        }
        else {
            $data = DB::table('province as p')
                ->select('p.*', DB::raw('(SELECT count(signed_by_lp) FROM candidates WHERE signed_by_lp = 0 AND province_id = p.province_code) AS pending, (SELECT count(signed_by_lp) FROM candidates WHERE signed_by_lp = 1 AND province_id = p.province_code) AS approved, (SELECT count(signed_by_lp) FROM candidates WHERE signed_by_lp = 2 AND province_id = p.province_code) AS rejected, (SELECT name FROM lec WHERE id = p.lec) AS assigned_lec'))
                ->where('p.region', '=', $code)
                ->where('type', '!=', 'HUC')
                ->get();
            //$data = DB::table('province')->get()->where('region', '=', $code)->where('type', '!=', 'HUC');
        }
        return $data;
    }

    public function table($code) {
        $data = DB::table('province')->get()->where('region', '=', $code);
        if (count($data) == 0) {
            $data = DB::table('district')->get()->where('province_code', '=', $code);
            if (count($data) == 0) {
                $data = DB::table('city')->get()->where('province_code', '=', $code);
                if (count($data) == 0) {
                    $data = '';
                }
            }
        }
        return $data;
    }

    public function cc($code) {
        return null;
    }

    //Get City/Municipality Candidate
    public function candidate(Request $request) {

        $lec = new LECController;

        if($request->ajax()) {

            $provinceCode = $request->input('provinceCode');
            $requesType = $request->input('requesType');
            $city = $request->input('name');

            $mayor = array();
            $vmayor = array();
            $councilor = array();

            if($requesType == 'MUNICIPAL') {
                $lec_type = 'municipal';
                $lec_city = $city;
            } elseif($requesType == 'CC') {
                $lec_type = 'component_city';
                $lec_city = $city;
            } else {
                $lec_type = 'huc_district';
                $lec_city = '';
            }

            if($requesType == 'HUC' || $requesType == 'CC' || $requesType == 'MUNICIPAL') {
                $query = DB::table('candidates')
                    ->where('province_id', '=', $provinceCode)
                    ->where('signed_by_lp', '<>', 3)
                    ->get();
                if(count($query) > 0) {
                    foreach ($query as $rows => $row) {
                        if($row->candidate_for == 'City Mayor' || $row->candidate_for == 'Municipal Mayor') {
                            if($row->signed_by_lp != 2) {
                                $mayor[] = array(
                                    'id' => $row->id,
                                    'name' => $row->firstname . ' ' . $row->middlename . ' ' . $row->lastname,
                                    'status' => $row->signed_by_lp == 0 ? 'Pending' : $row->signed_by_lp
                                );
                            }
                            
                        } else if ($row->candidate_for == 'City Vice Mayor' || $row->candidate_for == 'Municipal Vice Mayor') {
                            if($row->signed_by_lp != 2) {
                                $vmayor[] = array(
                                    'id' => $row->id,
                                    'name' => $row->firstname . ' ' . $row->middlename . ' ' . $row->lastname,
                                    'status' => $row->signed_by_lp == 0 ? 'Pending' : $row->signed_by_lp
                                );
                            }
                        } else if($row->candidate_for == 'City Councilor' || $row->candidate_for == 'Municipal Councilor') {
                            if($row->signed_by_lp != 2) {
                                $councilor[] = array(
                                    'id' => $row->id,
                                    'name' => $row->firstname . ' ' . $row->middlename . ' ' . $row->lastname, 
                                    'status' => $row->signed_by_lp == 0 ? 'Pending' : $row->signed_by_lp
                                );
                            }
                        } 
                    }
                    return response()->json(['mayor' => $mayor, 'vmayor' => $vmayor, 'councilor' => $councilor, 'lec' => $lec->lec_candidate($provinceCode, $lec_type, $lec_city)]);
                } else {
                    return response()->json(['mayor' => $mayor, 'vmayor' => $vmayor, 'councilor' => $councilor, 'lec' => $lec->lec_candidate($provinceCode, $lec_type, $lec_city), 'pass' => $requesType]);
                }

            }  

        }  else {

            return response()->json(['warning' => 'Invalid request.']);

        }

    }

    public function districtCandidate(Request $request) {

        $lec = new LECController;

        if($request->ajax()) {
            
            $provinceCode = $request->input('provinceCode');
            $district = $request->input('district');
            $type = $request->input('type');

            $query = DB:: table('candidates')
                ->where('province_id', '=', $provinceCode)
                ->where('district_id', '=', $district)
                ->where('signed_by_lp', '<>', '3')
                ->get();

            $congressman = array();
            $councilor = array();
            $bmember = array();
            $prvcongressman = array();


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
                    if($row->candidate_for == 'HUC Congressman') {
                        if($row->signed_by_lp != 2) {
                            $congressman[] = array(
                                'id' => $row->id,
                                'name' => $row->firstname . ' ' . $row->middlename . ' ' . $row->lastname,
                                'status' => $row->signed_by_lp == 0 ? 'Pending' : $row->signed_by_lp
                            );
                        }
                    } else if($row->candidate_for == 'City Councilor') {
                        if($row->signed_by_lp != 2) {
                            $councilor[] = array(
                                'id' => $row->id,
                                'name' => $row->firstname . ' ' . $row->middlename . ' ' . $row->lastname, 
                                'status' => $row->signed_by_lp == 0 ? 'Pending' : $row->signed_by_lp
                            );
                        }
                    } else if ($row->candidate_for == 'Board Member') {
                        if($row->signed_by_lp != 2) {
                            $bmember[] = array(
                                'id' => $row->id,
                                'name' => $row->firstname . ' ' . $row->middlename . ' ' . $row->lastname,
                                'status' => $row->signed_by_lp == 0 ? 'Pending' : $row->signed_by_lp
                            );
                        }
                    } else if ($row->candidate_for == 'Congressman') {
                        if($row->signed_by_lp != 2) {
                            $prvcongressman[] = array(
                                'id' => $row->id,
                                'name' => $row->firstname . ' ' . $row->middlename . ' ' . $row->lastname,
                                'status' => $row->signed_by_lp == 0 ? 'Pending' : $row->signed_by_lp
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

        $lec = new LECController;

        if($request->ajax()) {

            $provinceCode = $request->input('provinceCode');
            $requesType = $request->input('requesType');

            if($requesType == 'PROVINCE') {

                $query = DB::table('candidates')
                    ->where('province_id', '=', $provinceCode)
                    ->where('signed_by_lp', '<>', '3')
                    ->get();

                $governor = array();
                $vgovernor = array();

                if(count($query) > 0) {
                    foreach ($query as $rows => $row) {
                        if($row->candidate_for == 'Governor') {
                            if($row->signed_by_lp != 2) {
                                $governor[] = array(
                                    'id' => $row->id,
                                    'name' => $row->firstname . ' ' . $row->middlename . ' ' . $row->lastname,
                                    'status' => $row->signed_by_lp == 0 ? 'Pending' : $row->signed_by_lp
                                );
                            }
                            
                        } else if ($row->candidate_for == 'Vice Governor') {
                            if($row->signed_by_lp != 2) {
                                $vgovernor[] = array(
                                    'id' => $row->id,
                                    'name' => $row->firstname . ' ' . $row->middlename . ' ' . $row->lastname,
                                    'status' => $row->signed_by_lp == 0 ? 'Pending' : $row->signed_by_lp
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


}
