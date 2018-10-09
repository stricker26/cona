<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \stdClass;
use PDF;
use DB;
use Illuminate\Support\Facades\File;
use ZipArchive;

class CertificateController extends Controller
{
    public static function create($ids) {

        if(is_array($ids)) {
            $can = DB::table('candidates')->whereIn('id',$ids)->get();
        } else {
            $can = DB::table('candidates')->where('id',$ids)->get();
        }

        //Remove folder
        $dir = public_path('certificate');
        Self::removeDirectory($dir);

        foreach ($can as $candidates => $candidate) {
            
            $name = $candidate->firstname . ' ' . $candidate->lastname;

            $dir = Self::create_directory($name, $candidate->candidate_for, $candidate->province_id, $candidate->district_id, $candidate->city_id);

            if($dir) {
                Self::create_view($candidate->id, $dir, 'bulk');
            }

        }
        
        ini_set('max_execution_time', 600);
        ini_set('memory_limit','1024M');
        $zipname = strftime(time());
        $savepath = public_path('certificate');

        Self::zipData($savepath, $savepath. "/$zipname.zip");

        $archive_file_name = $savepath. "/$zipname.zip";

        header("Content-type: application/zip"); 
        header("Content-Disposition: attachment; filename=$archive_file_name");
        header("Content-length: " . filesize($archive_file_name));
        header("Pragma: no-cache"); 
        header("Expires: 0"); 
        readfile("$archive_file_name");

    }

    static function create_view($id, $location, $request) {

        $can = DB::table('candidates')->where('id',$id)->get();

        $candidate = [];

        foreach($can as $cand){

            $prov = DB::table('province')->where('province_code','=',$cand->province_id)->get();

            $province = $prov[0]->lgu;
            $lec_id = $prov[0]->lec;
            $region = $prov[0]->region;

            if($cand->candidate_for == 'Governor' || $cand->candidate_for == 'Congressman' || $cand->candidate_for == 'HUC Congressman' || $cand->candidate_for == 'City Mayor') {
                $lec = DB::table('lec')->where('id','=','2018000')->get();
            } else {
                $lec = DB::table('lec')->where('id','=',$lec_id)->get();
            }
            
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

        if($request == 'single') {
            return $pdf->stream();
        } else {

            //Create Directory if bulk request
            $name = $cand->firstname . ' ' . $cand->lastname;
            file_put_contents($location . '/' . $name . '.pdf', $pdf->stream());

        }

    }

    static function create_directory($name, $position, $province, $district, $city) {

        $query = DB::table('province')
            ->select('region', 'lgu', 'type')
            ->where('province_code', '=', $province)
            ->first();

        if($position == 'Governor' || $position == 'Vice Governor') {
            $mkdir = Self::rmkdir($query->region . '/' . $query->lgu . '/' . $position . '/' . $name);
        } elseif($position == 'Board Member' || $position == 'Congressman') {
            $mkdir = Self::rmkdir($query->region . '/' . $query->lgu . '/' . $district . '/' . $position . '/' . $name);
        } elseif($position == 'HUC Congressman' || $position == 'City Councilor') {
            $mkdir = Self::rmkdir($query->region . '/' . $query->lgu . '/' . $district . '/' . $position . '/' . $name);
        } elseif($position == 'City Mayor' || $position == 'City Vice Mayor') {
            $mkdir = Self::rmkdir($query->region . '/' . $query->lgu . '/' . $position . '/' . $name);
        } else {
            $mkdir = Self::rmkdir($query->region . '/' . $query->lgu . '/' . $city . '/' . $position . '/' . $name);
        }

        return $mkdir;

    }

    //Create Folder
    static function rmkdir($path) {

        $savepath = public_path('certificate');
        
        $path = str_replace("\\", "/", $savepath . '/' . $path);
        $path = explode("/", $path);
        $permit = 0777;

        $rebuild = '';
        foreach($path AS $p) {

            if(strstr($p, ":") != false) { 
                //echo "\nExists : in $p\n";
                $rebuild = $p;
                continue;
            }
            $rebuild .= "/$p";
            //echo "Checking: $rebuild\n";
            if(!is_dir($rebuild)) mkdir($rebuild);
            @chmod($rebuild, $permit);
        }
        return $rebuild;
    }

    //Remove folder first before creating new one
    static function removeDirectory($dir) {
        
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir."/".$object) == "dir") 
                        Self::removeDirectory($dir."/".$object); 
                    else unlink   ($dir."/".$object);
                }
            }
            reset($objects);
            @rmdir($dir);
        }
    }

    // Zip function
    static function zipData($source, $destination) {
        if (extension_loaded('zip')) {
            if (file_exists($source)) {
                $zip = new ZipArchive();
                if ($zip->open($destination, ZIPARCHIVE::CREATE)) {
                    $source = realpath($source);
                    if (is_dir($source)) {
                        $iterator = new \RecursiveDirectoryIterator($source);
                        // skip dot files while iterating 
                        $iterator->setFlags(\RecursiveDirectoryIterator::SKIP_DOTS);
                        $files = new \RecursiveIteratorIterator($iterator, \RecursiveIteratorIterator::SELF_FIRST);
                        foreach ($files as $file) {
                            $file = realpath($file);
                            if (is_dir($file)) {
                                $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
                            } else if (is_file($file)) {
                                $zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
                            }
                        }
                    } else if (is_file($source)) {
                        $zip->addFromString(basename($source), file_get_contents($source));
                    }
                }
                return $zip->close();
            }
        }
        return false;
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
