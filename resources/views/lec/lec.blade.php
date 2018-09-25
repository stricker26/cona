@extends('lec.layouts.master')

@section('title','Home')

@section('styles')
@stop

@section('content')
	<div class="container pb-5">
		<hr>
		<div class="row pr-2 pl-2">
			<div class="col-sm-12">
				<div class="col-sm-12 text-center pb-3">
					<h3>LEC Admin</h3>
				</div>
			</div>
			<div class="col-sm-12 text-center">
				<div>
					<small>(Assigned Places)</small>
				</div>
				<div class="text-center">
					<h5>Lanao Del Sur</h5>
				</div>
			</div>
		</div>
		<hr>
		<div class="mb-3 lec-data">
			<div class="row">
				<div class="col-sm-6 text-right">
					<strong>Name :</strong>
				</div>
				<div class="col-sm-4 text-left col-body">
					<span>{{ $user->name }}</span>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6 text-right">
					<strong>User 1 :</strong>
				</div>
				<div class="col-sm-4 text-left col-body">
					<span>{{ $user->user }}</span>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6 text-right">
					<strong>User 2 :</strong>
				</div>
				<div class="col-sm-4 text-left col-body">
					<span>{{ $user->user }}</span>
				</div>
			</div>
		</div>
		<div class="text-center">
			<form action="/lec/profile" method="POST">
				@csrf
				<button class="btn btn-secondary" type="submit" name="lec_edit_btn" value="{{ md5(Auth::user()->id) }}">Edit</button>
			</form>	
		</div>
	</div>
@stop

@section('scripts')
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="{{asset('js/lec/lec.js')}}"></script>
@stop