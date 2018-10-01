<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \stdClass;
use PDF;
use DB;

class CertificateController extends Controller
{
    public static function create($ids){

        if(is_array($ids)) {
             $can = DB::table('candidates')->whereIn('id',$ids)->get();
        } else {
             $can = DB::table('candidates')->where('id',$ids)->get();
        }

    	$candidate = [];

        foreach($can as $cand){
            $prov = DB::table('province')->where('province_code','=',$cand->province_id)->get();

            $province = $prov[0]->lgu;
            $lec_id = $prov[0]->lec;
            $region = $prov[0]->region;

            $lec = DB::table('lec')->where('id','=',$lec_id)->get();
            $c = new stdClass();


            $c->lec_name = strtoupper($lec[0]->name);
            $c->lec_position = $lec[0]->designation_gov;

            // $c->lec_name = 'KIKO PANGILINAN';
            // $c->lec_position = 'PRESIDENT';

        		// create object list of candidates to generate certificate
        	$c->name = $cand->firstname . ' ' . substr($cand->middlename,0,1) . '. ' . $cand->lastname;
            $cand->city_id = $cand->city_id == '' ? $province : $cand->city_id;
            
        		// full name of the candidate with middle initial, FirstName M. Lastname
            $c->position = $cand->candidate_for;
            $provinces = ($province == 'MANILA' ? 'METRO MANILA' : $province);
            $c->province = $provinces;
            $filename = 'REGION_'. $region . '_' . $provinces . '_';
            // ADDRESS
                if($cand->candidate_for == 'City Mayor' || 
                    $cand->candidate_for == 'City Vice Mayor' || 
                    $cand->candidate_for == 'City Councilor'){

                    $c->administrative_address = 'CITY OF ' . substr($cand->city_id, 0, -4);
                    $filename .= substr($cand->city_id, 0, -4) . '_';
                    $c->address = $cand->city_id . ', '  . $provinces;
                }

                if($cand->candidate_for == 'Municipal Mayor' || 
                    $cand->candidate_for == 'Municipal Vice Mayor' || 
                    $cand->candidate_for == 'Municipal Councilor'){

                    $c->administrative_address = 'MUNICIPALITY OF ' . $cand->city_id;
                    $c->address = $cand->city_id . ', '  . $provinces;
                    $filename .= $cand->city_id . '_';
                }

                if($cand->candidate_for == 'Congressman' || 
                    $cand->candidate_for == 'HUC Congressman'){

                    $d = $cand->district_id == 'Lone District' ? 'LONE' : self::getRd(substr( $cand->district_id, -1));

                    $c->administrative_address =  $d . ' DISTRICT OF ' .  ' ' . ($cand->candidate_for == 'Congressman' ?
                                                        $c->province : $cand->city_id);
                    $c->address = strtolower($d) . ' District, ' . ucfirst(strtolower($provinces));
                    $filename .= $d . '_DISTRICT_' . ($cand->candidate_for == 'Congressman' ?
                                                        $c->province : $cand->city_id) . '_';
                }

                if($cand->candidate_for == 'Governor' || 
                    $cand->candidate_for == 'Vice-Governor' || 
                    $cand->candidate_for == 'Board Member'){

                    $c->administrative_address = $provinces;
                    $c->address = ucfirst(strtolower($provinces));
                }

            // POSITIONS
                if($cand->candidate_for == 'City Mayor' || 
                    $cand->candidate_for == 'Municipal Mayor'){

                    $c->position = 'MAYOR';
                }

                if($cand->candidate_for == 'City Vice Mayor' || 
                    $cand->candidate_for == 'Municipal Vice Mayor'){

                	$c->position = 'VICE MAYOR';
                }

                if($cand->candidate_for == 'City Coucilor' || 
                    $cand->candidate_for == 'Municipal Coucilor'){

                    $c->position = 'COUNCILOR';
                }

                if($cand->candidate_for == 'Congressman' || 
                    $cand->candidate_for == 'HUC Congressman'){

                    $c->position = 'REPRESENTATIVE';
                }

               

                $filename .= strtoupper($c->position) . '_';
                $filename .= $cand->firstname . '_' . $cand->middlename . '_' . $cand->lastname . '.pdf';

        	array_push($candidate, $c);
        		// Repeat for multiple certificates   
        }

        $pdf = PDF::loadView('certificate.main',compact('candidate'));
        $pdf->setPaper('legal', 'portrait');


        
        // return $pdf->download($filename);
        return $pdf->stream();
    	// return view('certificate.main', compact('candidate'));

    }

    public static function getRd($num){
        switch ($num) {
            case '1':
                return '1ST';
                break;
            case '2':
                return '2ND';
                break;
            case '3':
                return '3RD';
                break;
            case '4':
            case '5':
            case '6':
            case '7':
            case '8':
            case '9':
                return  $num . 'TH';
                break;
            default:
                # code...
                break;
        }
    }
}
