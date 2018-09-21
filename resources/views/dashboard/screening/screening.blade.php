@extends('dashboard.layouts.master')

@section('title','Screening')

@section('styles')
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="{{ asset('css/table-screening.css') }}">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@stop

@section('content')
	<div class="sticky-top">
		<div class="container">
			<div class="bcrumbs row"></div>
		</div>
	</div>
	<div class="modal fade" id="rejectsModal" tabindex="-1" role="dialog" aria-labelledby="rejectsModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="modal-title" id="locationModal">Location</h2>
				</div>
				<div class="modal-body">
					<form action="/screening/profile" method="POST">
						@csrf
						<div class="gov-governor" style="display: none;">
							<div class="row pb-2 pt-2">
								<div class="col-sm-3">
									<h5 class="font-weight-bold">LEC:</h5>
								</div>
								<div class="col-sm-9">
									<h5 class="font-weight-normal">Lorem ipsum dolor sit amet.</h5>
								</div>
							</div>
							<hr>
							<div class="row pb-2 pt-2">
								<div class="col-sm-3">
									<h5 class="font-weight-bold">Governor:</h5>
								</div>
								<div class="col-sm-9">
									<div class="row">
										<div class="col-sm-9">
											<h5 class="font-weight-normal">Lorem ipsum dolor sit amet.</h5>
										</div>
										<div class="col-sm-3">
											<button type="submit" class="btn btn-success" name="screening_btn" value="g">View Profile</button>
										</div>
									</div>
								</div>
							</div>
							<hr>
							<div class="row pb-2 pt-2">
								<div class="col-sm-3">
									<h5 class="font-weight-bold">Vice Governor:</h5>
								</div>
								<div class="col-sm-9">
									<div class="row">
										<div class="col-sm-9">
											<h5 class="font-weight-normal">Lorem ipsum dolor sit amet.</h5>
										</div>
										<div class="col-sm-3">
											<button type="submit" class="btn btn-success" name="screening_btn" value="vg">View Profile</button>
										</div>
									</div>
								</div>
							</div>
							<hr>
							<div class="row pb-2 pt-2">
								<div class="col-sm-3">
									<h5 class="font-weight-bold">Board Members:</h5>
								</div>
								<div class="col-sm-9">
									<div class="row pb-3">
										<div class="col-sm-9">
											<h5 class="font-weight-normal">Lorem ipsum dolor sit amet.</h5>
										</div>
										<div class="col-sm-3">
											<button type="submit" class="btn btn-success" name="screening_btn" value="bm1">View Profile</button>
										</div>
									</div>
									<div class="row pb-3">
										<div class="col-sm-9">
											<h5 class="font-weight-normal">Lorem ipsum dolor sit amet.</h5>
										</div>
										<div class="col-sm-3">
											<button type="submit" class="btn btn-success" name="screening_btn" value="bm1">View Profile</button>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="gov-mayor" style="display: none;">
							<div class="row pb-2 pt-2">
								<div class="col-sm-3">
									<h5 class="font-weight-bold">LEC:</h5>
								</div>
								<div class="col-sm-9">
									<h5 class="font-weight-normal">Lorem ipsum dolor sit amet.</h5>
								</div>
							</div>
							<hr>
							<div class="row pb-2 pt-2">
								<div class="col-sm-3">
									<h5 class="font-weight-bold">Mayor:</h5>
								</div>
								<div class="col-sm-9">
									<div class="row">
										<div class="col-sm-9">
											<h5 class="font-weight-normal">Lorem ipsum dolor sit amet.</h5>
										</div>
										<div class="col-sm-3">
											<button type="submit" class="btn btn-success" name="screening_btn" value="g">View Profile</button>
										</div>
									</div>
								</div>
							</div>
							<hr>
							<div class="row pb-2 pt-2">
								<div class="col-sm-3">
									<h5 class="font-weight-bold">Vice Mayor:</h5>
								</div>
								<div class="col-sm-9">
									<div class="row">
										<div class="col-sm-9">
											<h5 class="font-weight-normal">Lorem ipsum dolor sit amet.</h5>
										</div>
										<div class="col-sm-3">
											<button type="submit" class="btn btn-success" name="screening_btn" value="vg">View Profile</button>
										</div>
									</div>
								</div>
							</div>
							<hr>
							<div class="row pb-2 pt-2">
								<div class="col-sm-3">
									<h5 class="font-weight-bold">Councilors:</h5>
								</div>
								<div class="col-sm-9">
									<div class="row pb-3">
										<div class="col-sm-9">
											<h5 class="font-weight-normal">Lorem ipsum dolor sit amet.</h5>
										</div>
										<div class="col-sm-3">
											<button type="submit" class="btn btn-success" name="screening_btn" value="bm1">View Profile</button>
										</div>
									</div>
									<div class="row pb-3">
										<div class="col-sm-9">
											<h5 class="font-weight-normal">Lorem ipsum dolor sit amet.</h5>
										</div>
										<div class="col-sm-3">
											<button type="submit" class="btn btn-success" name="screening_btn" value="bm1">View Profile</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<div class="container body list-candidates" style="display: none;">
		<div class="form-group mt-5">
			<div class="row text-center pb-2">
				<div class="col-sm-12">
					<h3 class="screenLocation">LOCATION</h3>
				</div>
			</div>
			<hr>
			<form action="/screening/profile" method="post">
				@csrf
				<div class="gov-governor" style="display: none;">
					<div class="row pb-2 pt-2">
						<div class="col-sm-3">
							<h5 class="font-weight-bold">LEC:</h5>
						</div>
						<div class="col-sm-9">
							<h5 class="font-weight-normal">Lorem ipsum dolor sit amet.</h5>
						</div>
					</div>
					<hr>
					<div class="row pb-2 pt-2">
						<div class="col-sm-3">
							<h5 class="font-weight-bold">Governor:</h5>
						</div>
						<div class="col-sm-9">
							<div class="row">
								<div class="col-sm-7">
									<h5 class="font-weight-normal">Lorem ipsum dolor sit amet.</h5>
								</div>
								<div class="col-sm-3">
									<span class="badge badge-pill badge-success p-2">Approved</span>
									<span class="badge badge-pill badge-warning p-2">Pending</span>
								</div>
								<div class="col-sm-2">
									<button type="submit" class="btn btn-success" name="screening_btn" value="g">View Profile</button>
								</div>
							</div>
						</div>
					</div>
					<hr>
					<div class="row pb-2 pt-2">
						<div class="col-sm-3">
							<h5 class="font-weight-bold">Vice Governor:</h5>
						</div>
						<div class="col-sm-9">
							<div class="row">
								<div class="col-sm-7">
									<h5 class="font-weight-normal">Lorem ipsum dolor sit amet.</h5>
								</div>
								<div class="col-sm-3">
									<span class="badge badge-pill badge-success p-2">Approved</span>
									<span class="badge badge-pill badge-warning p-2">Pending</span>
								</div>
								<div class="col-sm-2">
									<button type="submit" class="btn btn-success" name="screening_btn" value="vg">View Profile</button>
								</div>
							</div>
						</div>
					</div>
					<hr>
					<div class="row pb-2 pt-2">
						<div class="col-sm-3">
							<h5 class="font-weight-bold">Board Members:</h5>
						</div>
						<div class="col-sm-9">
							<div class="row pb-3">
								<div class="col-sm-7">
									<h5 class="font-weight-normal">Lorem ipsum dolor sit amet.</h5>
								</div>
								<div class="col-sm-3">
									<span class="badge badge-pill badge-success p-2">Approved</span>
									<span class="badge badge-pill badge-warning p-2">Pending</span>
								</div>
								<div class="col-sm-2">
									<button type="submit" class="btn btn-success" name="screening_btn" value="bm1">View Profile</button>
								</div>
							</div>
							<div class="row pb-3">
								<div class="col-sm-7">
									<h5 class="font-weight-normal">Lorem ipsum dolor sit amet.</h5>
								</div>
								<div class="col-sm-3">
									<span class="badge badge-pill badge-success p-2">Approved</span>
									<span class="badge badge-pill badge-warning p-2">Pending</span>
								</div>
								<div class="col-sm-2">
									<button type="submit" class="btn btn-success" name="screening_btn" value="bm1">View Profile</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="gov-mayor" style="display: none;">
					<div class="row pb-2 pt-2">
						<div class="col-sm-3">
							<h5 class="font-weight-bold">LEC:</h5>
						</div>
						<div class="col-sm-9">
							<h5 class="font-weight-normal">Lorem ipsum dolor sit amet.</h5>
						</div>
					</div>
					<hr>
					<div class="row pb-2 pt-2">
						<div class="col-sm-3">
							<h5 class="font-weight-bold">Mayor:</h5>
						</div>
						<div class="col-sm-9">
							<div class="row">
								<div class="col-sm-7">
									<h5 class="font-weight-normal" id="huc-mayor">Lorem ipsum dolor sit amet.</h5>
								</div>
								<div class="col-sm-3">
									<span class="badge badge-pill badge-success p-2">Approved</span>
									<span class="badge badge-pill badge-warning p-2">Pending</span>
								</div>
								<div class="col-sm-2">
									<button type="submit" class="btn btn-success" name="screening_btn" value="g">View Profile</button>
								</div>
							</div>
						</div>
					</div>
					<hr>
					<div class="row pb-2 pt-2">
						<div class="col-sm-3">
							<h5 class="font-weight-bold">Vice Mayor:</h5>
						</div>
						<div class="col-sm-9">
							<div class="row">
								<div class="col-sm-7">
									<h5 class="font-weight-normal" id="huc-vmayor">Lorem ipsum dolor sit amet.</h5>
								</div>
								<div class="col-sm-3">
									<span class="badge badge-pill badge-success p-2">Approved</span>
									<span class="badge badge-pill badge-warning p-2">Pending</span>
								</div>
								<div class="col-sm-2">
									<button type="submit" class="btn btn-success" name="screening_btn" value="vg">View Profile</button>
								</div>
							</div>
						</div>
					</div>
					<hr>
					<div class="row pb-2 pt-2">
						<div class="col-sm-3">
							<h5 class="font-weight-bold">Councilors:</h5>
						</div>
						<div class="col-sm-9">
							<div class="row pb-3">
								<div class="col-sm-7">
									<h5 class="font-weight-normal">Lorem ipsum dolor sit amet.</h5>
								</div>
								<div class="col-sm-3">
									<span class="badge badge-pill badge-success p-2">Approved</span>
									<span class="badge badge-pill badge-warning p-2">Pending</span>
								</div>
								<div class="col-sm-2">
									<button type="submit" class="btn btn-success" name="screening_btn" value="bm1">View Profile</button>
								</div>
							</div>
							<div class="row pb-3">
								<div class="col-sm-7">
									<h5 class="font-weight-normal">Lorem ipsum dolor sit amet.</h5>
								</div>
								<div class="col-sm-3">
									<span class="badge badge-pill badge-success p-2">Approved</span>
									<span class="badge badge-pill badge-warning p-2">Pending</span>
								</div>
								<div class="col-sm-2">
									<button type="submit" class="btn btn-success" name="screening_btn" value="bm1">View Profile</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
		<div class="text-center pb-4">
			<button type="button" class="w-100 btn btn-danger" data-toggle="modal" data-target="#rejectsModal">Rejects</button>
		</div>
		<input type="text" id="searchBar" class="form-control pull-right" onkeyup="searchData()" placeholder="SEARCH">
		<table id="tableGeo" class="table table-bordered">
			<thead>
				<tr>
					<th class="colNum" onclick="w3.sortHTML('#tableGeo', '.item', '.code')" style="cursor:pointer">#<i class="sort fa fa-sort-amount-asc pull-right"></i></th>
					<th class="colTitle" onclick="w3.sortHTML('#tableGeo', '.item', '.description')" style="cursor:pointer">Name<i class="sort fa fa-sort-amount-asc pull-right"></i></th>
					<th class="colPending" onclick="w3.sortHTML('#tableGeo', '.item', 'td:nth-child(3)')" style="cursor:pointer">Pending<i class="sort fa fa-sort-amount-asc pull-right"></i></th>
					<th class="colApproved" onclick="w3.sortHTML('#tableGeo', '.item', 'td:nth-child(4)')" style="cursor:pointer">Approved<i class="sort fa fa-sort-amount-asc pull-right"></i></th>
					<th class="colRejected" onclick="w3.sortHTML('#tableGeo', '.item', 'td:nth-child(5)')" style="cursor:pointer">Rejected<i class="sort fa fa-sort-amount-asc pull-right"></i></th>
					<th class="colLEC" onclick="w3.sortHTML('#tableGeo', '.item', 'td:nth-child(6)')" style="cursor:pointer">LEC<i class="sort fa fa-sort-amount-asc pull-right"></i></th>
					<th>TYPE</th>
				</tr>
			</thead>
			<tbody>
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