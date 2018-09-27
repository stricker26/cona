<?php
    use App\Http\Controllers\GeoLocationController; 
?>

@extends('layouts.app')

@section('content')
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(\Session::has('success'))
             <div class="alert alert-success">
                {{\Session::get('success')}}
            </div>
        @endif
        <form method="POST" class="getInfo" id="register" action="{{ route('candidate.register') }}">
            {{ csrf_field() }}
            <div class="row">
                <div class="col mt-5">
                    <h1 class="text-center">CONA Application</h1>
                </div>
            </div>
            <div class="row">
                <div class="col text-center" id="response"></div>
            </div>
            <div class="row">
                <div class="col-md-6 form-col">
                    <div class="form-group">
                        <h2>Personal Information</h2>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Firstname <span>*</span></label>
                        <input type="text" name="firstname" class="form-control" id="firstname" value="{{ old('firstname') }}">
                    </div>
                    <div class="form-group">
                        <label for="middlename">Middle Name</label>
                        <input type="text" name="middlename" class="form-control" id="middlename" value="{{ old('middlename') }}">
                    </div>
                    <div class="form-group">
                        <label for="lastname">Last Name <span>*</span></label>
                        <input type="text" name="lastname" class="form-control" id="lastname" value="{{ old('lastname') }}">
                    </div>
                    <div class="form-group">
                        <label for="birthdate">Birthdate <span>*</span></label>
                        <div class="row">
                            <div class="col">
                                <select class="form-control" id="birthmonth" name="birthmonth" required="required">
                                    <option value="">MONTH</option>
                                    <option value="1" {{ (old("birthmonth") == 1 ? "selected":"") }}>January</option>
                                    <option value="2" {{ (old("birthmonth") == 2 ? "selected":"") }}>February</option>
                                    <option value="3" {{ (old("birthmonth") == 3 ? "selected":"") }}>March</option>
                                    <option value="4" {{ (old("birthmonth") == 4 ? "selected":"") }}>April</option>
                                    <option value="5" {{ (old("birthmonth") == 5 ? "selected":"") }}>May</option>
                                    <option value="6" {{ (old("birthmonth") == 6 ? "selected":"") }}>June</option>
                                    <option value="7" {{ (old("birthmonth") == 7 ? "selected":"") }}>July</option>
                                    <option value="8" {{ (old("birthmonth") == 8 ? "selected":"") }}>August</option>
                                    <option value="9" {{ (old("birthmonth") == 9 ? "selected":"") }}>September</option>
                                    <option value="10" {{ (old("birthmonth") == 10 ? "selected":"") }}>October</option>
                                    <option value="11" {{ (old("birthmonth") == 11 ? "selected":"") }}>November</option>
                                    <option value="12" {{ (old("birthmonth") == 12 ? "selected":"") }}>December</option>
                                </select>
                            </div>
                            <div class="col">
                                <input type="number" class="form-control" id="birthday" name="birthday" placeholder="DAY" min="1" max="31" required="required" value="{{ old('birthday') }}">
                            </div>
                            <div class="col">
                                <select class="form-control" id="birthyear" name="birthyear" required="required">
                                    <option value="">YEAR</option>
                                   
                                        @for($year = 1911; $year <= 2000; $year++)
                                            <option value="{{ $year }}" {{ (old("birthyear") == $year ? "selected":"") }}>{{ $year }}</option>
                                        @endfor

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address">Address <span>*</span></label>
                        <input type="text" name="address" class="form-control" id="address" value="{{ old('address') }}">
                    </div>
                    <div class="form-group">
                        <label for="email">Email <span>*</span></label>
                        <input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}">
                    </div>
                    <div class="form-group">
                        <label for="landline">Landline</label>
                        <input type="text" name="landline" class="form-control" id="landline" value="{{ old('landline') }}">
                    </div>
                    <div class="form-group">
                        <label for="mobile">Mobile <span>*</span></label>
                        <input type="text" name="mobile" class="form-control" id="mobile" value="{{ old('mobile') }}">
                    </div>
                    <div class="form-group a">
                        <h2>Public Social Media Accounts</h2>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="facebook">Facebook</span>
                            </div>
                            <input type="text" name="facebook" class="form-control" placeholder="Facebook Account" aria-label="Facebook" aria-describedby="social-media-accounts" value="{{ old('facebook') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="facebook">Twitter</span>
                            </div>
                            <input type="text" name="twitter" class="form-control" placeholder="Twitter Account" aria-label="Twitter" aria-describedby="social-media-accounts" value="{{ old('twitter') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="facebook">Instagram</span>
                            </div>
                            <input type="text" name="instagram" class="form-control" placeholder="Instagram Account" aria-label="Instagram" aria-describedby="social-media-accounts" value="{{ old('instagram') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="facebook">Website</span>
                            </div>
                            <input type="text" name="website" class="form-control" placeholder="Website Account" aria-label="Website" aria-describedby="social-media-accounts" value="{{ old('website') }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-6 form-col">
                    <div class="form-group">
                        <h2>Candidacy Details</h2>
                    </div>
                    <div class="form-group">
                        <label>Position aspired for <span>*</span></label>
                        <select class="form-control" id="position" name="position" required="required">
                            <option value="">Position</option>
                            <option data-group="PROV" value="Senator" {{ (old("position") == "Senator" ? "selected":"") }}>Senator</option>
                            <option data-group="PROV" value="Governor" {{ (old("position") == "Governor" ? "selected":"") }}>Governor</option>
                            <option data-group="PROV" value="Vice-Governor" {{ (old("position") == "Vice-Governor" ? "selected":"") }}>Vice Governor</option>
                            <option data-group="PROV" value="Board Member" {{ (old("position") == "Board Member" ? "selected":"") }}>Board Member</option>
                            <option data-group="PROV" value="Congressman" {{ (old("position") == "Congressman" ? "selected":"") }}>Congressman</option>
                            <option data-group="HUC" value="HUC Congressman" {{ (old("position") == "HUC Congressman" ? "selected":"") }}>HUC Congressman</option>
                            <option data-group="HUC" value="City Mayor" {{ (old("position") == "City Mayor" ? "selected":"") }}>City Mayor</option>
                            <option data-group="HUC" value="City Vice Mayor" {{ (old("position") == "City Vice Mayor" ? "selected":"") }}>City Vice Mayor</option>
                            <option data-group="HUC" value="City Councilor" {{ (old("position") == "City Councilor" ? "selected":"") }}>City Councilor</option>
                            <option data-group="PROV" value="Municipal Mayor" {{ (old("position") == "Municipal Mayor" ? "selected":"") }}>Municipal Mayor</option>
                            <option data-group="PROV" value="Municipal Vice Mayor" {{ (old("position") == "Municipal Vice-Mayor" ? "selected":"") }}>Municipal Vice-Mayor</option>
                            <option data-group="PROV" value="Municipal Councilor" {{ (old("position") == "Municipal Councilor" ? "selected":"") }}>Municipal Councilor</option>
                        </select>
                    </div>
                    <div class="form-group region-wrapper">
                        <label>Region <span>*</span></label>
                        <select name="region" id="region" class="form-control">
                            <option value="">Select Region <span>*</span></option>
                            <?php echo GeoLocationController::getRegion(); ?>
                        </select>
                    </div>
                    <div class="form-group province-wrapper">
                        <label>Province / HUC / ICC <span>*</span></label>
                        <select name="province" id="province" class="form-control">
                            <option value="">Select Province</option>
                        </select>
                    </div>
                    <div class="form-group huc-city-wrapper">
                        <label>City <span>*</span></label>
                        <select name="huc_city" id="huc-city" class="form-control">
                        </select>
                    </div>
                    <div class="form-group district-wrapper">
                        <label>District <span>*</span></label>
                        <select name="district" id="district" class="form-control">
                            <option value="">Select District</option>
                        </select>
                    </div>
                    <div class="form-group city-wrapper">
                        <label>Municipality <span>*</span></label>
                        <select name="city" id="city" class="form-control">
                            <option value="">Select Municipality</option>
                        </select>
                    </div>
                    <div class="form-group a">
                        <h2>Secondary Contact Person</h2>
                    </div>
                    <div class="form-group">
                        <label for="cos_name">Name of Secondary Contact Person</label>
                        <input type="text" name="cos_name" class="form-control" id="cos_name" value="{{ old('cos_name') }}">
                    </div>
                    <div class="form-group">
                        <label for="relation">Relation</label>
                        <input type="text" name="relation" class="form-control" id="relation" value="{{ old('relation') }}">
                    </div>
                    <div class="form-group">
                        <label for="cos_position">Position</label>
                        <input type="text" name="cos_position" class="form-control" id="cos_position" value="{{ old('cos_position') }}">
                    </div>
                    <div class="form-group">
                        <label for="cos_address">Address</label>
                        <input type="text" name="cos_address" class="form-control" id="cos_address" value="{{ old('cos_address') }}">
                    </div>
                    <div class="form-group">
                        <label for="cos_contact">Contact Numbers</label>
                        <input type="text" name="cos_contact" class="form-control" id="cos_contact" value="{{ old('cos_contact') }}">
                    </div>
                    <div class="form-group">
                        <label for="cos_email">Email Address</label>
                        <input type="text" name="cos_email" class="form-control" id="cos_email" value="{{ old('cos_email') }}">
                    </div>
                </div>
            </div>
            <div class="row submit-button">
                <div class="col text-center">
                    <button class="btn btn-primary pr-5 pl-5" type="submit">Register</button>
                </div>
            </div>
        </form>
    </div>
@endsection
