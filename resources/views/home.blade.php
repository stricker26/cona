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
<<<<<<< HEAD
        <form method="POST" action="{{ route('register') }}">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-6 pr-5">
=======
        <div class="row getInfo">
            <div class="col-md-6 form-col">
                <form>
>>>>>>> bc85da66b50c51db3d552f6e21e06b429605d594
                    <div class="form-group">
                        <h2>Personal Information</h2>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Firstname <span>*</span></label>
                        <input type="text" name="firstname" class="form-control" id="firstname">
                    </div>
                    <div class="form-group">
                        <label for="middlename">Middle Name</label>
                        <input type="text" name="middlename" class="form-control" id="middlename">
                    </div>
                    <div class="form-group">
                        <label for="lastname">Last Name <span>*</span></label>
                        <input type="text" name="lastname" class="form-control" id="lastname">
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
                                    <?php
                                        for($year = 1911; $year <= 2000; $year++) { 
                                            echo '<option value="'. $year .'">'. $year .'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address">Address <span>*</span></label>
                        <input type="text" name="address" class="form-control" id="address">
                    </div>
                    <div class="form-group">
                        <label for="email">Email <span>*</span></label>
                        <input type="email" name="email" class="form-control" id="email">
                    </div>
                    <div class="form-group">
                        <label for="landline">Landline</label>
                        <input type="text" name="landline" class="form-control" id="landline">
                    </div>
                    <div class="form-group">
                        <label for="mobile">Mobile <span>*</span></label>
                        <input type="text" name="mobile" class="form-control" id="mobile">
                    </div>
                    <div class="form-group a">
                        <h2>Social Media Accounts</h2>
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
                            <input type="text" name="website" class="form-control" placeholder="Website URL" aria-label="Website" aria-describedby="social-media-accounts">
                        </div>
                    </div>
<<<<<<< HEAD
=======
                </form>
            </div>
            <div class="col-md-6 form-col">
                <div class="form-group">
                    <h2>Candidacy Details</h2>
                </div>
                <div class="form-group">
                    <label>Running a candidate for <span>*</span></label>
                    <input type="text" name="position" class="form-control" id="position">
                </div>
                <div class="form-group">
                    <label>Province <span>*</span></label>
                    <select name="province" class="form-control">
                        <option value="">Select Province</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>District <span>*</span></label>
                    <select name="district" class="form-control">
                        <option value="">Select District</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>City <span>*</span></label>
                    <select name="city" class="form-control">
                        <option value="">Select City</option>
                    </select>
                </div>
                <div class="form-group a">
                    <h2>Chief of Staff Details</h2>
                </div>
                <div class="form-group">
                    <label for="cos_name">Name of Chief of Staff</label>
                    <input type="text" name="cos_name" class="form-control" id="cos_name">
>>>>>>> bc85da66b50c51db3d552f6e21e06b429605d594
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <h2>Candidacy Details</h2>
                    </div>
                    <div class="form-group">
                        <label>Running a candidate for <span>*</span></label>
                        <input type="text" name="position" class="form-control" id="position">
                    </div>
                    <div class="form-group">
                        <label>Province <span>*</span></label>
                        <select name="province" id="province" class="form-control">
                            <option value="">Select Province</option>
                            <?php echo GeoLocationController::getProvince() ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>District <span>*</span></label>
                        <select name="district" id="district" class="form-control">
                            <option value="">Select District</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>City <span>*</span></label>
                        <select name="city" id="city" class="form-control">
                            <option value="">Select City</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <h2>Chief of Staff Details</h2>
                    </div>
                    <div class="form-group">
                        <label for="cos_name">Name of Chief of Staff</label>
                        <input type="text" name="cos_name" class="form-control" id="cos_name">
                    </div>
                    <div class="form-group">
                        <label for="relation">Relation</label>
                        <input type="text" name="relation" class="form-control" id="relation">
                    </div>
                    <div class="form-group">
                        <label for="position">Position</label>
                        <input type="text" name="cos_position" class="form-control" id="position">
                    </div>
                    <div class="form-group">
                        <label for="cos_address">Address</label>
                        <input type="text" name="cos_address" class="form-control" id="cos_address">
                    </div>
                    <div class="form-group">
                        <label for="cos_contact">Contact Numbers</label>
                        <input type="text" name="cos_contact" class="form-control" id="cos_contact">
                    </div>
                    <div class="form-group">
                        <label for="cos_email">Email Address</label>
                        <input type="text" name="cos_email" class="form-control" id="cos_email">
                    </div>
                </div>
            </div>
<<<<<<< HEAD
            <div class="row">
                <div class="col text-center">
=======
            <div class="row col-sm-12 btn-submit">
                <div class="col  text-center">
>>>>>>> bc85da66b50c51db3d552f6e21e06b429605d594
                    <button class="btn btn-primary pr-5 pl-5" type="submit">Register</button>
                </div>
            </div>
        </form>
    </div>
@endsection
