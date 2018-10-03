@extends('dashboard.layouts.master')

@section('title','Approved Candidates')

@section('styles')
@stop

@section('content')
<hr>
<div class="row pb-3 pt-3">
	<div class="col-sm-12 text-center">
		<h5>Approved Candidates&nbsp;&nbsp;<i class="fas fa-check"></i></h5>
		<span class="pt-1">({{ $location }})</span>
	</div>
</div>
<hr class="mb-4">
<div class="container pb-3">
    @if(count($candidates) !== 0 && $status_page === '1')
		<form action="{{asset('/hq/screening/profile')}}" method="post">
			@csrf
	      	@foreach($positions as $position)
		      	<div class="card rounded mb-2">
				  	<div class="card-header card-header-click text-center">
		  	 			<h5 class="d-inline">{{ ucwords(str_replace("_", " ", $position)) }}&nbsp;({{ $count_positions->$position }})</h5>
		  	 			<div class="float-right d-inline">
		  	 				<i class="fas fa-caret-down pt-1"></i>
		  	 			</div>
				  	</div>
				  	<div class="card-body" style="display: none;">
			      	 	@if($count_positions->$position !== 0)
				      	 	<table class="table table-bordered">
				      	 		<thead>
				      	 			<tr>
				      	 				<th>NAME</th>
				      	 				<th>POSITION</th>
				      	 				<th>LOCATION</th>
				      	 				<th>LEC</th>
				      	 				<th></th>
				      	 			</tr>
				      	 		</thead>
				      	 		<tbody>
				      	 			@foreach($candidates as $candidate)
				      	 				@if($candidate->candidate_for === ucwords(str_replace("_", " ", $position)))
					      	 				<tr>
					      	 					<td class="align-middle">
					      	 						{{ $candidate->lastname }},&nbsp;{{ $candidate->firstname }}&nbsp;{{ $candidate->middlename }}
					      	 					</td>
					      	 					<td class="align-middle">
					      	 						{{ $candidate->candidate_for }}
					      	 					</td>
					      	 					<td class="align-middle">
					      	 						{{ $candidate->location }}
					      	 					</td>
					      	 					<td class="align-middle">
					      	 						{{ $candidate->lec }}
					      	 					</td>
					      	 					<td>
					      	 						<button type="submit" class="btn btn-success" name="screening_btn" value="{{ $candidate->id }}">View Profile</button>
					      	 					</td>
					      	 				</tr>
					      	 				@php($getposition = $candidate->candidate_for)
					      	 				@php($getprovinceID = $candidate->province_id)
				      	 				@endif
				      	 			@endforeach
				      	 			@php($candidate = str_replace(" ", "-", $getposition))
					      	 		@php($region = explode(" ", $location))
					      	 		@if(ucwords($region[0]) == 'Region')
										<a href="{{ url()->current() . '/export/' . $candidate . '/' . $getprovinceID . '/' . $region[1] }}" class="btn btn-primary mb-3" target="_blank">Download CONA</a>
									@elseif(ucwords($region[0]) == 'All')
										<a href="{{ url()->current() . '/export/' . $candidate . '/0/national' }}" class="btn btn-primary mb-3" target="_blank">Download CONA</a>
									@else
					      	 			<a href="{{ url()->current() . '/export/' . $candidate . '/' . $getprovinceID . '/province' }}" class="btn btn-primary mb-3" target="_blank">Download CONA</a>
					      	 		@endif
				      	 		</tbody>
				      	 	</table>
				      	@else
					      	<div class="card-text">
					      		<span>No Approved Candidates</span>
					      	</div>
				      	@endif
			      	</div>
		    	</div>
		    @endforeach
		</form>
    @else
  	<div class="row">
  		<div class="col-sm-12 text-center">
  			<span>No Approved Candidates</span>
  		</div>
  	</div>
    @endif
</div>
@stop

@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="{{ asset('js/status.js') }}" ></script>
@stop