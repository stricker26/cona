@extends('dashboard.layouts.master')

@section('title','Screening')

<meta name="csrf-token" content="{{ csrf_token() }}">

@section('styles')
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="{{ asset('css/table-screening.css') }}">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@stop

@section('sub-page','HQ Screening')

@section('content')
	<div class="container">
		<div class="bcrumbs row">
			<a href="" id="regionNum">PH</a>
		</div>
		<input type="text" id="searchBar" class="form-control pull-right" onkeyup="searchData()" placeholder="SEARCH">
		<table id="tableGeo" class="table table-striped table-bordered">
			<thead>
				<tr>
					<th class="colNum" onclick="w3.sortHTML('#tableGeo', '.item', '.code')" style="cursor:pointer">#<i class="sort fa fa-sort-amount-asc pull-right"></i></th>
					<th class="colTitle" onclick="w3.sortHTML('#tableGeo', '.item', '.description')" style="cursor:pointer">Name<i class="sort fa fa-sort-amount-asc pull-right"></i></th>
					<th class="colPending" onclick="w3.sortHTML('#tableGeo', '.item', 'td:nth-child(3)')" style="cursor:pointer">Pending<i class="sort fa fa-sort-amount-asc pull-right"></i></th>
					<th class="colApproved" onclick="w3.sortHTML('#tableGeo', '.item', 'td:nth-child(4)')" style="cursor:pointer">Approved<i class="sort fa fa-sort-amount-asc pull-right"></i></th>
					<th class="colRejected" onclick="w3.sortHTML('#tableGeo', '.item', 'td:nth-child(5)')" style="cursor:pointer">Rejected<i class="sort fa fa-sort-amount-asc pull-right"></i></th>
					<th class="colLEC" onclick="w3.sortHTML('#tableGeo', '.item', 'td:nth-child(6)')" style="cursor:pointer">LEC<i class="sort fa fa-sort-amount-asc pull-right"></i></th>
				</tr>
			</thead>
			<tbody>
				<tr class="item">
					<td class="code">13</td>
					<td class="description">NCR</td>
					<td>0</td>
					<td>0</td>
					<td>0</td>
					<td>Lorem Ipsum</td>
				</tr>
				<tr class="item">
					<td class="code">01</td>
					<td class="description">ILOCOS REGION</td>
					<td>0</td>
					<td>0</td>
					<td>0</td>
					<td>Lorem Ipsum</td>
				</tr>
				<tr class="item">
					<td class="code">02</td>
					<td class="description">CAGAYAN VALLEY</td>
					<td>0</td>
					<td>0</td>
					<td>0</td>
					<td>Lorem Ipsum</td>
				</tr>
				<tr class="item">
					<td class="code">03</td>
					<td class="description">CENTRAL LUZON</td>
					<td>0</td>
					<td>0</td>
					<td>0</td>
					<td>Lorem Ipsum</td>
				</tr>
				<tr class="item">
					<td class="code">04</td>
					<td class="description">CALABARZON</td>
					<td>0</td>
					<td>0</td>
					<td>0</td>
					<td>Lorem Ipsum</td>
				</tr>
				<tr class="item">
					<td class="code">17</td>
					<td class="description">SOUTHERN TAGALOG REGION</td>
					<td>0</td>
					<td>0</td>
					<td>0</td>
					<td>Lorem Ipsum</td>
				</tr>
				<tr class="item">
					<td class="code">05</td>
					<td class="description">BICOL REGION</td>
					<td>0</td>
					<td>0</td>
					<td>0</td>
					<td>Lorem Ipsum</td>
				</tr>
				<tr class="item">
					<td class="code">06</td>
					<td class="description">WESTERN VISAYAS</td>
					<td>0</td>
					<td>0</td>
					<td>0</td>
					<td>Lorem Ipsum</td>
				</tr>
				<tr class="item">
					<td class="code">07</td>
					<td class="description">CENTRAL VISAYAS</td>
					<td>0</td>
					<td>0</td>
					<td>0</td>
					<td>Lorem Ipsum</td>
				</tr>
				<tr class="item">
					<td class="code">08</td>
					<td class="description">EASTERN VISAYAS</td>
					<td>0</td>
					<td>0</td>
					<td>0</td>
					<td>Lorem Ipsum</td>
				</tr>
				<tr class="item">
					<td class="code">09</td>
					<td class="description">ZAMBOANGA PENINSULA</td>
					<td>0</td>
					<td>0</td>
					<td>0</td>
					<td>Lorem Ipsum</td>
				</tr>
				<tr class="item">
					<td class="code">10</td>
					<td class="description">NORTHERN MINDANAO</td>
					<td>0</td>
					<td>0</td>
					<td>0</td>
					<td>Lorem Ipsum</td>
				</tr>
				<tr class="item">
					<td class="code">11</td>
					<td class="description">DAVAO REGION</td>
					<td>0</td>
					<td>0</td>
					<td>0</td>
					<td>Lorem Ipsum</td>
				</tr>
				<tr class="item">
					<td class="code">12</td>
					<td class="description">SOCCSKSARGEN</td>
					<td>0</td>
					<td>0</td>
					<td>0</td>
					<td>Lorem Ipsum</td>
				</tr>
				<tr class="item">
					<td class="code">16</td>
					<td class="description">CARAGA REGION</td>
					<td>0</td>
					<td>0</td>
					<td>0</td>
					<td>Lorem Ipsum</td>
				</tr>
				<tr class="item">
					<td class="code">15</td>
					<td class="description">ARMM</td>
					<td>0</td>
					<td>0</td>
					<td>0</td>
					<td>Lorem Ipsum</td>
				</tr>
			</tbody>
		</table>
		<div id="nav"></div>
	</div>
@stop

@section('scripts')
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script src="https://www.w3schools.com/lib/w3.js"></script>
	<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
	<script src="{{asset('js/screening/tableScreening.js')}}" ></script>
@stop