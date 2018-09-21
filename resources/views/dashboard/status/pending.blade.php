@extends('dashboard.layouts.master')

@section('title','Pending Candidates')

@section('subpage','HQ Pending Candidates')

@section('styles')
@stop

@section('content')
<div class="container">
   @if($candidates === 'empty')
      <span class="text-center"><h3>No approved Candidates</h3></span>
   @else
      @foreach($candidates as $candidate)
         <span>Development stage</span>
      @endforeach
   @endif
</div>
@stop

@section('scripts')
@stop