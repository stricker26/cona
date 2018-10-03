@extends('dashboard.layouts.master')

@section('title','Senators')

@section('styles')
@stop

@section('content')
	<div class="container">
		<div class="row text-center mt-5 pb-2">
			<div class="col-sm-12">
				<h3>SENATORIAL POSITION</h3>
			</div>
		</div>
		<hr>
		<div class="row pb-2 pt-2">
			<div class="col-sm-3 pt-1">
				<h5 class="font-weight-bold">SENATORS: </h5>
			</div>
			<div class="col-sm-9">
				@if(count($senators))
					@foreach($senators as $senator)
						<div class="row pb-2">
							<div class="col-sm-7 pt-1">					
								<h5 class="font-weight-normal">{{ $senator->lastname }},&nbsp;{{ $senator->firstname }}&nbsp;{{ strtoupper($senator->middlename[0]) }}</h5>
							</div>
							@if($senator->signed_by_lp == '0')
								<div class="col-sm-3 pt-1">
									<span class="badge badge-pill badge-warning p-2">Pending</span>
								</div>
							@elseif($senator->signed_by_lp == '1')
								<div class="col-sm-3 pt-1">
									<span class="badge badge-pill badge-success p-2">Approved</span>
								</div>
							@elseif($senator->signed_by_lp == '2')
								<div class="col-sm-3 pt-1">
									<span class="badge badge-pill badge-alert p-2">Reject</span>
								</div>
							@endif
							<div class="col-sm-2">
								<form method="POST" action="/hq/screening/profile">
									@csrf
									<input type="hidden" name="screening_btn" value="{{ $senator->id }}">
									<button type="submit" class="btn btn-success">View Profile</button>
								</form>
							</div>
						</div>
					@endforeach
				@else
					<div class="row pb-2">
						<div class="col-sm-12">
							<h5 class="font-weight-normal">No candidates</h5>
						</div>
					</div>
				@endif
			</div>
		</div>
	</div>
@stop

@section('scripts')
@stop