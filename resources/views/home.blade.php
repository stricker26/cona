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
                        <input type="text" name="firstname" class="form-control" id="firstname" maxlength="150" required="required">
                    </div>
                    <div class="form-group">
                        <label for="middlename">Middle Name</label>
                        <input type="text" name="middlename" class="form-control" id="middlename" maxlength="150">
                    </div>
                    <div class="form-group">
                        <label for="lastname">Last Name <span>*</span></label>
                        <input type="text" name="lastname" class="form-control" id="lastname" maxlength="150" required="required">
                    </div>
                    <div class="form-group">
                        <label for="birthdate">Birthdate <span>*</span></label>
                        <div class="row">
                            <div class="col">
                                <select class="form-control" id="birthmonth" name="birthmonth" required="required">
                                    <option value="">MONTH</option>
                                    <option value="1">January</option>
                                    <option value="2">February</option>
                                    <option value="3">March</option>
                                    <option value="4">April</option>
                                    <option value="5">May</option>
                                    <option value="6">June</option>
                                    <option value="7">July</option>
                                    <option value="8">August</option>
                                    <option value="9">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                            </div>
                            <div class="col">
                                <input type="number" class="form-control" id="birthday" name="birthday" placeholder="DAY" min="1" max="31" required="required">
                            </div>
                            <div class="col">
                                <select class="form-control" id="birthyear" name="birthyear" required="required">
                                    <option value="">YEAR</option>
                                   
                                        @for($year = 1911; $year <= 2000; $year++)
                                            <option value="{{ $year }}">{{ $year }}</option>
                                        @endfor

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address">Address <span>*</span></label>
                        <input type="text" name="address" class="form-control" id="address" maxlength="200" required="required">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" id="email" maxlength="190">
                    </div>
                    <div class="form-group">
                        <label for="landline">Landline</label>
                        <input type="text" name="landline" class="form-control" id="landline" maxlength="15">
                    </div>
                    <div class="form-group">
                        <label for="mobile">Mobile <span>*</span></label>
                        <input type="text" name="mobile" class="form-control" id="mobile" maxlength="15" required="required">
                    </div>
                    <div class="form-group a">
                        <h2>Public Social Media Accounts</h2>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="facebook">Facebook</span>
                            </div>
                            <input type="text" name="facebook" class="form-control" placeholder="Facebook Account" aria-label="Facebook" aria-describedby="social-media-accounts">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="facebook">Twitter</span>
                            </div>
                            <input type="text" name="twitter" class="form-control" placeholder="Twitter Account" aria-label="Twitter" aria-describedby="social-media-accounts">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="facebook">Instagram</span>
                            </div>
                            <input type="text" name="instagram" class="form-control" placeholder="Instagram Account" aria-label="Instagram" aria-describedby="social-media-accounts">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="facebook">Website</span>
                            </div>
                            <input type="text" name="website" class="form-control" placeholder="Website Account" aria-label="Website" aria-describedby="social-media-accounts">
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
                            <option data-group="PROV" value="Senator">Senator</option>
                            <option data-group="PROV" value="Governor">Governor</option>
                            <option data-group="PROV" value="Vice Governor">Vice Governor</option>
                            <option data-group="PROV" value="Board Member">Board Member</option>
                            <option data-group="PROV" value="Congressman">Congressman</option>
                            <option data-group="HUC" value="HUC Congressman">HUC Congressman</option>
                            <option data-group="HUC" value="City Mayor">City Mayor</option>
                            <option data-group="HUC" value="City Vice Mayor">City Vice Mayor</option>
                            <option data-group="HUC" value="City Councilor">City Councilor</option>
                            <option data-group="PROV" value="Municipal Mayor">Municipal Mayor</option>
                            <option data-group="PROV" value="Municipal Vice Mayor">Municipal Vice Mayor</option>
                            <option data-group="PROV" value="Municipal Councilor">Municipal Councilor</option>
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
                        <input type="text" name="cos_name" class="form-control" id="cos_name" maxlength="200">
                    </div>
                    <div class="form-group">
                        <label for="relation">Relation</label>
                        <input type="text" name="relation" class="form-control" id="relation" maxlength="150">
                    </div>
                    <div class="form-group">
                        <label for="cos_position">Position</label>
                        <input type="text" name="cos_position" class="form-control" id="cos_position" maxlength="150">
                    </div>
                    <div class="form-group">
                        <label for="cos_address">Address</label>
                        <input type="text" name="cos_address" class="form-control" id="cos_address" maxlength="200">
                    </div>
                    <div class="form-group">
                        <label for="cos_contact">Contact Numbers</label>
                        <input type="text" name="cos_contact" class="form-control" id="cos_contact" maxlength="15">
                    </div>
                    <div class="form-group">
                        <label for="cos_email">Email Address</label>
                        <input type="text" name="cos_email" class="form-control" id="cos_email">
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
