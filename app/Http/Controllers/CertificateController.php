<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \stdClass;
use PDF;

class CertificateController extends Controller
{
    public static function create(){
    	$candidate = [];

    	$c = new stdClass();
    		// create object list of candidates to generate certificate
    	$c->name = 'Eric B. Reforma';
    		// full name of the candidate with middle initial, FirstName M. Lastname

    	$c->position = 'MAYOR';
    		// string value of desired position of the candidate
    		// ONLY VALUES ARE
    			// GOVERNOR, VICE GOVERNOR, BOARD MEMBER
    			// REPRESENTATIVE (equals to CONGRESSMAN)
    			// MAYOR, VICE MAYOR, COUNCILOR

    	$c->address= "San Jose del Monte, Bulacan";
    		// Geographical Address of the Candidate
    		// Only inlcludes the city and the province

    	$c->administrative_address = 'City of San Jose del Monte';
    		// Formal State of geographical location of the candidate to run
    		
    		// if Governor / Vice Governor / Board Member, 
    			// -> PROVINCE eg. Bulacan

    		// if Congressman
    			// -> DISTRICT eg. 6TH DISTRICT OF QUEZON CITY

	    	// if Mayor / Vice Mayor / Coucilor
    			// -> CITY eg. City of Manila

    	array_push($candidate, $c);
    		// Repeat for multiple certificates   

        $pdf = PDF::loadView('certificate.main',compact('candidate'));
        $pdf->setPaper('legal', 'portrait');



        return $pdf->stream();
    	// return view('certificate.main', compact('candidate'));

    }
}
