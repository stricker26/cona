@extends('lec.layouts.master')

@section('title','Pending Candidates')

@section('styles')
@stop

@section('content')
<hr>
<div class="row pb-3 pt-3">
	<div class="col-sm-12 text-center">
		<h5>Pending Candidates&nbsp;&nbsp;<i class="far fa-clock"></i></h5>
		<span class="pt-1">({{ $location }})</span>
	</div>
</div>
<hr class="mb-4">
<div class="container pb-3">
    @if(count($candidates) !== 0)
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
			      	 			</tr>
			      	 		</thead>
			      	 		<tbody>
			      	 			@foreach($candidates as $candidate)
			      	 				@if($candidate->candidate_for === ucwords(str_replace("_", " ", $position)))
			      	 				<tr>
			      	 					<td>
			      	 						{{ $candidate->lastname }},&nbsp;{{ $candidate->firstname }}&nbsp;{{ $candidate->middlename }}
			      	 					</td>
			      	 					<td>
			      	 						{{ $candidate->candidate_for }}
			      	 					</td>
			      	 					<td>
			      	 						{{ $candidate->province_id }}
			      	 					</td>
			      	 					<td>
			      	 						Lorem ipsum dolor.
			      	 					</td>
			      	 				</tr>
			      	 				@endif
			      	 			@endforeach
			      	 		</tbody>
			      	 	</table>
			      	@else
			      	<div class="card-text">
			      		<span>No data..</span>
			      	</div>
			      	@endif
		      	</div>
	    	</div>
	    @endforeach
    @else
  	<div class="row">
  		<div class="col-sm-12 text-center">
  			<span>No Pending Candidates</span>
  		</div>
  	</div>
    @endif
</div>
@stop

@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="{{ asset('js/status.js') }}" ></script>
@stop