@extends('lec.layouts.master')

@section('title','Candidates')

@section('styles')
@stop

@section('content')
<div class="card rounded">
    <div class="card-header text-center">
        <span><strong>Nominees</strong></span>
    </div>
    <div class="card-body">
        @if(!empty($candidates_db))
        <table class="table table-bordered">
        	<thead>
        		<tr class="thead-dark text-center">
        			<th>NAME</th>
        			<th>BIRTHDATE</th>
        			<th>ADDRESS</th>
        			<th>EMAIL</th>
        			<th>LANDLINE</th>
        			<th>MOBILE</th>
        			<th>POSITION</th>
	        	</tr>
	        </thead>
	        <tbody>
        	@foreach($candidates_db as $candidates)
        		<tr class="text-center">
        			<td>
        				{{ucwords(strtolower($candidates->lastname))}},&nbsp;{{ucwords(strtolower($candidates->firstname))}}&nbsp;{{ucwords(strtolower($candidates->middlename))}}
        			</td>
        			<td>{{$candidates->birthdate}}</td>
        			<td>{{$candidates->address}}</td>
        			<td>{{$candidates->email}}</td>
        			<td>{{$candidates->landline}}</td>
        			<td>{{$candidates->mobile}}</td>
        			<td>{{$candidates->candidate_for}}</td>
        		</tr>
        	@endforeach
	        </tbody>
        </table>
        @endif
    </div>
</div>
@stop

@section('scripts')
@stop