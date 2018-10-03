<?php
   use App\Http\Controllers\dashboardPageController;
?>

@extends('dashboard.layouts.master')

@section('title','Dashboard')

@section('subpage','HQ Screening')

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@stop

@section('content')
<div class="container">
   <div class="card">
		<div class="card-header">
			<h5>Candidates</h5>
		</div>
		<div class="card-body">
         <div class="table-responsive">
   			<table id="candidates" class="table table-striped table-bordered">
               <thead>
                  <tr>
                     <th>#</th>
                     <th>Candidate</th>
                     <th>Position</th>
                     <th>Location</th>
                     <th>Status</th>
                     <th>Assign LEC</th>
                     <th>Date Registered</th>
                  </tr>
               </thead>
               <tbody>
                  <?php echo dashboardPageController::candidate_list(); ?>
               </tbody>
            </table>
         </div>
		</div>
   </div>
</div>
@stop

@section('scripts')
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
<script>
   $(document).ready(function() {
      $('#candidates').DataTable();
   });
</script>
@stop