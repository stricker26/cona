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
			<h5>LEC User Activity</h5>
		</div>
		<div class="card-body">
         <div class="table-responsive">
   			<table id="lec-table" class="table table-striped table-bordered">
               <thead>
                  <tr>
                     <th>#</th>
                     <th>Candidate</th>
                     <th>Position</th>
                     <th>Location</th>
                     <th>Action</th>
                     <th>Approved/Rejected By</th>
                     <th>Assign LEC</th>
                     <th>IP Address</th>
                     <th>Date</th>
                  </tr>
               </thead>
               <tbody>
                  <?php echo dashboardPageController::lec_activity(); ?>
               </tbody>
            </table>
         </div>
		</div>
   </div>
   <div class="card mt-5">
      <div class="card-header">
         <h5>HQ Update</h5>
      </div>
      <div class="card-body">
         <div class="table-responsive">
            <table id="hq-table" class="table table-striped table-bordered">
               <thead>
                  <tr>
                     <th>#</th>
                     <th>Candidate</th>
                     <th>Position</th>
                     <th>Location</th>
                     <th>Action</th>
                     <th>Approved/Rejected By</th>
                     <th>Assign LEC</th>
                     <th>IP Address</th>
                     <th>Date</th>
                  </tr>
               </thead>
               <tbody>
                  <?php echo dashboardPageController::hq_activity(); ?>
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
      $('#lec-table').DataTable();
      $('#hq-table').DataTable();
   });
</script>
@stop