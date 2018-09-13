@extends('layouts.app')

@section('content')
    <div class="container">
        @if(\Session::has('error'))
            <div class="alert alert-danger">
                {{\Session::get('error')}}
            </div>
        @endif
        <div class="row">
            <div class="col-md-6 pr-5">
                <form>
                    <div class="form-group">
                        <h2>Personal Information</h2>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Firstname</label>
                        <input type="text" name="firstname" class="form-control" id="firstname">
                    </div>
                    <div class="form-group">
                        <label for="middlename">Middle Name</label>
                        <input type="text" name="middlename" class="form-control" id="middlename">
                    </div>
                    <div class="form-group">
                        <label for="lastname">Last Name</label>
                        <input type="text" name="lastname" class="form-control" id="lastname">
                    </div>
                    <div class="form-group">
                        <label for="birthdate">Birthdate</label>
                        <input type="text" name="birthdate" class="form-control" id="birthdate">
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" name="address" class="form-control" id="address">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" id="email">
                    </div>
                    <div class="form-group">
                        <label for="landline">Landline</label>
                        <input type="text" name="landline" class="form-control" id="landline">
                    </div>
                    <div class="form-group">
                        <label for="mobile">Mobile</label>
                        <input type="text" name="mobile" class="form-control" id="mobile">
                    </div>
                </form>
            </div>
            <div class="col-md-6">
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
                    <input type="text" name="position" class="form-control" id="position">
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
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <h2>Candidacy Details</h2>
                </div>
            </div>
        </div>
    </div>
@endsection
