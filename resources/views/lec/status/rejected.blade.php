@extends('lec.layouts.master')

@section('title','Rejected Candidates')

@section('styles')
@stop

@section('content')
<hr>
<div class="row pb-3 pt-3">
	<div class="col-sm-12 text-center">
		<h5>Rejected Candidates&nbsp;&nbsp;<i class="fas fa-times"></i></h5>
		<span class="pt-1">({{ $location }})</span>
	</div>
</div>
<hr class="mb-4">
<div class="container pb-3">
    @if(count($candidates) !== 0 && $status_page === '2')
		<form action="{{asset('/lec/screening/profile')}}" method="post">
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
				      	 				@endif
				      	 			@endforeach
				      	 		</tbody>
				      	 	</table>
				      	@else
				      	<div class="card-text">
				      		<span>No Rejected Candidates</span>
				      	</div>
				      	@endif
			      	</div>
		    	</div>
		    @endforeach
		</form>
    @else
  	<div class="row">
  		<div class="col-sm-12 text-center">
  			<span>No Rejected Candidates</span>
  		</div>
  	</div>
    @endif
</div>
@stop

@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="{{ asset('js/status.js') }}" ></script>
@stop