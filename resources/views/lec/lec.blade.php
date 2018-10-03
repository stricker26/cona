@extends('lec.layouts.master')

@section('title','Home')

@section('styles')
@stop

@section('content')
	<div class="container pb-5">
		<div class="row pt-2 pb-2">
			<div class="col-sm-5"></div>
			<div class="col-sm-2 text-center">
				<img class="user-avatar rounded-circle" src="{{ asset('img/dashboard/admin.png') }}" alt="User Avatar">
			</div>
		</div>
		<hr>
		<h3>Profile Data</h3>
		<hr>
		<div class="row mb-3">
			<div class="col-sm-3">
				<strong>Name : </strong>
			</div>
			<div class="col-sm-9">
				<span>{{ $lec_name }}</span>
			</div>
		</div>
		<div class="row mb-3">
			<div class="col-sm-3">
				<strong>User 1 : </strong>
			</div>
			<div class="col-sm-9">
				@if($lec_user1)
					<span>{{ $lec_user1->email }}</span>
				@else
					<span><i>{{ __('-- No Assigned Email --') }}</i></span>
				@endif
			</div>
		</div>
		<div class="row mb-3">
			<div class="col-sm-3">
				<strong>User 2 : </strong>
			</div>
			<div class="col-sm-9">
				@if($lec_user2)
					<span>{{ $lec_user2->email }}</span>
				@else
					<span><i>{{ __('-- No Assigned Email --') }}</i></span>
				@endif
			</div>
		</div>
		<div class="row mb-3">
			<div class="col-sm-3">
				<strong>Designation Gov. : </strong>
			</div>
			<div class="col-sm-9">
				@if($lec_des)
					<span>{{ $lec_des }}</span>
				@else
					<span><i>{{ __('-- No Designated Position --') }}</i></span>
				@endif
			</div>
		</div>
		{{-- <div class="pt-2">
			<hr>
			<h3>Location Assigned</h3>
		</div>
		<hr>
		<div class="row">
			<div class="col-sm-12">

			</div>
		</div> --}}
	</div>
@stop

@section('scripts')
@stop