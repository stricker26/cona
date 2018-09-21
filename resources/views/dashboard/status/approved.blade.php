@extends('dashboard.layouts.master')

@section('title','Approved Candidates')

@section('styles')
@stop

@section('content')
<div class="container">
   @if($candidates === 'empty')
      {{-- <span class="text-center"><h3>No approved Candidates</h3></span> --}}
      <div class="card rounded">
      	 <div class="card-header">
      	 	<div class="card-title">
      	 		<span>APPROVED CANDIDATES</span>
      	 	</div>
      	 </div>
      	 <div class="card-body">
      	 	@if(!empty($candidates_status))
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
	      	 			@foreach($candidates_status as $ind_candidate)
	      	 				<tr>
	      	 					<td>
	      	 						{{ $ind_candidate->lastname }},&nbsp;{{ $ind_candidate->firstname }}&nbsp;{{ $ind_candidate->middlename }}
	      	 					</td>
	      	 					<td>
	      	 						{{ $ind_candidate->candidate_for }}
	      	 					</td>
	      	 					<td>
	      	 						{{ $ind_candidate->candidate_for }}
	      	 					</td>
	      	 					<td>
	      	 						{{ $ind_candidate->candidate_for }}
	      	 					</td>
	      	 				</tr>
	      	 			@endforeach
	      	 		</tbody>
	      	 	</table>
	      	@endif
      	 </div>
      </div>
   @else
      @foreach($candidates as $candidate)
      	<span>
      		Development stage
      	</span>
      @endforeach
   @endif
</div>
@stop

@section('scripts')
@stop