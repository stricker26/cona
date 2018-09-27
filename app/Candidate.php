<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    protected $fillable = [
        'firstname',  'middlename', 'lastname', 'birthdate', 'address', 'email', 'landline', 'mobile', 'candidate_for', 'sma', 'province_id', 'district_id', 'city_id', 'signed_by_lec', 'signed_by_lp', 'cos_id'
    ];
}
