@extends('lec.layouts.master')

@section('title','Profile')

@section('styles')
@stop

@section('content')
	<!-- APPROVE AND REJECT MODALS -->
	<div class="sticky-top">
		<div class="container">
			<div class="bcrumbs row">
				<a href="../screening?e={{$province->region}}&name=REGION%20{{$province->region}}&type=REGION">REGION {{$province->region}}</a>
				<p>/</p>
				<a href="../screening?e={{$province->province_code}}&name={{$province->lgu}}&type={{$province->type}}&region={{$province->region}}">{{$province->lgu}}</a>
			</div>
		</div>
	</div>
	<div class="modal fade" id="modalApprove" tabindex="-1" role="dialog" aria-labelledby="Approve Candidate" aria-hidden="true">
	  	<div class="modal-dialog modal-dialog-centered" role="document">
	    	<div class="modal-content">
		      	<div class="modal-body">
		        	Are you sure you want to approve this candidate?
		      	</div>
		      	<div class="modal-footer">
		        	<button type="button" class="btn btn-success" id="lec_approve_btn">Approve</button>
		        	<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
		      	</div>
	    	</div>
	  	</div>
	</div>
	<div class="modal fade" id="modalReject" tabindex="-1" role="dialog" aria-labelledby="Reject Candidate" aria-hidden="true">
	  	<div class="modal-dialog modal-dialog-centered" role="document">
	    	<div class="modal-content">
		      	<div class="modal-body">
		        	Are you sure you want to reject this candidate?
		      	</div>
		      	<div class="modal-footer">
		        	<button type="button" class="btn btn-danger" id="reject_btn">Reject</button>
		        	<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
		      	</div>
	    	</div>
	  	</div>
	</div>
	<!-- END OF APPROVE AND REJECT MODALS -->
	<div class="container pb-5">
		<div id="alert-handler" style="display: none;">
			<div class="content mt-3 pl-3 pr-3 success-alert" style="display: none;">
	            <div class="col-sm-12">
	                <div class="alert alert-success alert-dismissible fade show" role="alert">
	                  <span class="badge badge-pill badge-success message-alert">Success</span> Data saved
	                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	                        <span aria-hidden="true">&times;</span>
	                    </button>
	                </div>
	            </div>
	        </div> 

	        <div class="content pl-3 pr-3 failed-alert" style="display: none;">
	            <div class="col-sm-12">
	                <div class="alert alert-danger alert-dismissible fade show" role="alert">
	                  <span class="badge badge-pill badge-danger message-alert">Failed</span> Data not saved
	                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	                        <span aria-hidden="true">&times;</span>
	                    </button>
	                </div>
	            </div>
	        </div>
	    </div>
		<div class="mt-5 pb-4">
			<div class="text-center">
				<h3 class="text-center">Profiling</h3>
			</div>
		</div>
		<div class="row picture-candidate pb-5">
			<div class="col-sm-5"></div>
			<div class="col-sm-2 text-center">
				<img class="rounded-circle" src="{{ asset('img/dashboard/admin.png') }}" alt="User Avatar">
			</div>
			<div class="col-sm-5"></div>
		</div>
		<div id="candidateSummary" class="row pr-2 pl-2 prof-summary-data">
			<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-12 text-center pb-3">
						<h3>{{ucwords(strtolower($candidate->lastname))}},&nbsp;{{ucwords(strtolower($candidate->firstname))}}&nbsp;{{ucwords(strtolower($candidate->middlename))}}</h3>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12 text-center">
						<div class="pb-1">
							<span>(Position Aspired for)</span>
						</div>
						<div class="text-center">
							<h3>{{$candidate->candidate_for}}</h3>
						</div>
						<div class='text-center'>
							<?php
								if($province->type == 'HUC') {
									if($district) {
										$location = $province->lgu . ', ' . $district;
									} else {
										$location = $province->lgu;
									}
								} elseif($province->type == 'Nation') {
									$location = $province->loc;
								} else {
									if($district) {
										$location = $province->lgu . ', ' . $municipality . ', ' . $district;
									} else {
										$location = $province->lgu . ', ' . $municipality;
									}
								}
							?>
							<h5><?php echo $location; ?></h5>
						</div>
						<div>
							@if ($candidate->signed_by_lec == 1)
								<span class="text-success">Approved</span>
							@elseif ($candidate->signed_by_lec == 0)
								<span class="text-warning">Pending</span>
							@elseif ($candidate->signed_by_lec ==2)
								<span class="text-danger">Rejected</span>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row data-candidates">
			<input type="hidden" id="prof_id" value="{{$candidate->id}}">
			<div class="col-sm-6 left-div">
				<div class="row">
					<div class="col-sm-12 pb-3">
						<h4>Personal Data</h4>
						<input type="hidden" id="id_candidate" value="{{ $candidate->id }}">
					</div>
				</div>
				<div class="row row-body">
					<div class="col-sm-6">
						<span class="font-weight-bold">Last Name :</span>
					</div>
					<div class="col-sm-6 row-content">
						<span>{{ucwords(strtolower($candidate->lastname))}}</span>
						<input type="text" class="form-control" id="prof_lastname" style="display:none;" value="{{$candidate->lastname}}">
					</div>
				</div>
				<div class="row row-body">
					<div class="col-sm-6">
						<span class="font-weight-bold">First Name :</span>
					</div>
					<div class="col-sm-6 row-content">
						<span>{{ucwords(strtolower($candidate->firstname))}}</span>
						<input type="text" class="form-control" id="prof_firstname" style="display:none;" value="{{$candidate->firstname}}">
					</div>
				</div>
				<div class="row row-body">
					<div class="col-sm-6">
						<span class="font-weight-bold">Middle Name :</span>
					</div>
					<div class="col-sm-6 row-content">
						<span>{{ucwords(strtolower($candidate->middlename))}}</span>
						<input type="text" class="form-control" id="prof_middlename" style="display:none;" value="{{$candidate->middlename}}">
					</div>
				</div>
				<div class="row row-body">
					<div class="col-sm-6">
						<span class="font-weight-bold">Birthdate :</span>
					</div>
					<div class="col-sm-6 row-content">
						<span>{{$candidate->birthdate}}</span>
						<input type="date" class="form-control" id="prof_birthdate" style="display:none;" value="{{$candidate->birthdate}}">
					</div>
				</div>
				<div class="row row-body">
					<div class="col-sm-6">
						<span class="font-weight-bold">Residential Address :</span>
					</div>
					<div class="col-sm-6 row-content">
						<span>{{$candidate->address}}</span>
						<input type="text" class="form-control" id="prof_address" style="display:none;" value="{{$candidate->address}}">
					</div>
				</div>
				<div class="row row-body">
					<div class="col-sm-6">
						<span class="font-weight-bold">Email :</span>
					</div>
					<div class="col-sm-6 row-content">
						<span class="wrap">{{$candidate->email}}</span>
						<input type="text" class="form-control" id="prof_email" style="display:none;" value="{{$candidate->email}}">
					</div>
				</div>
				<div class="row row-body">
					<div class="col-sm-6">
						<span class="font-weight-bold">Landline :</span>
					</div>
					<div class="col-sm-6 row-content">
						<span>{{$candidate->landline}}</span>
						<input type="text" class="form-control" id="prof_landline" style="display:none;" value="{{$candidate->landline}}">
					</div>
				</div>
				<div class="row row-body">
					<div class="col-sm-6">
						<span class="font-weight-bold">Mobile :</span>
					</div>
					<div class="col-sm-6 row-content">
						<span>{{$candidate->mobile}}</span>
						<input type="text" class="form-control" id="prof_mobile" style="display:none;" value="{{$candidate->mobile}}">
					</div>
				</div>
				<div class="row row-body">
					<div class="col-sm-5">
						<span class="font-weight-bold">Social Media Accounts :</span>
					</div>
					<div class="col-sm-1">
						<div>
							<i class="fab fa-facebook-square pr-2" style="color:#4267b2;"></i>
						</div>
					</div>
					@php
						$json = $candidate->sma;
						$json = json_decode($json, true);
					@endphp
					<div class="col-sm-6 row-content">
						<div class="facebook">
							@if($json['facebook'])
								<a style="color:#212529;" href="https://{{ $json['facebook'] }}"><i><span class="wrap">{{ $json['facebook'] }}</span></i></a><input type="text" class="form-control" id="prof_fb" style="display:none;" value="{{ $json['facebook'] }}">
							@else
								<a style="color:#212529;" href="#facebook"><i><span class="wrap"><i>--None--</i></span></i></a><input type="text" class="form-control" id="prof_fb" style="display:none;" value="">
							@endif
						</div>
					</div>
				</div>
				<div class="row row-body">
					<div class="col-sm-5"></div>
					<div class="col-sm-1">
						<div>
							<i class="fab fa-twitter-square pr-2" style="color:#1da1f2;"></i>
						</div>
					</div>
					<div class="col-sm-6 row-content">
						<div class="twitter">
							@if($json['twitter'])
								<a style="color:#212529;" href="https://{{ $json['twitter'] }}"><i><span class="wrap">{{ $json['twitter'] }}</span></i></a><input type="text" class="form-control" id="prof_twitter" style="display:none;" value="{{ $json['twitter'] }}">
							@else
								<a style="color:#212529;" href="#twitter"><i><span class="wrap"><i>--None--</i></span></i></a><input type="text" class="form-control" id="prof_twitter" style="display:none;" value="">
							@endif
						</div>
					</div>
				</div>
				<div class="row row-body">
					<div class="col-sm-5"></div>
					<div class="col-sm-1">
						<div>
							<i class="fab fa-instagram pr-2" style="color:#e4405f;"></i>
						</div>
					</div>
					<div class="col-sm-6 row-content">
						<div class="instagram">
							@if($json['instagram'])
								<a style="color:#212529;" href="https://{{ $json['instagram'] }}"><i><span class="wrap">{{ $json['instagram'] }}</span></i></a><input type="text" class="form-control" id="prof_ig" style="display:none;" value="{{ $json['instagram'] }}">
							@else
								<a style="color:#212529;" href="#instagram"><i><span class="wrap"><i>--None--</i></span></i></a><input type="text" class="form-control" id="prof_ig" style="display:none;" value="">
							@endif
						</div>
					</div>
				</div>
				<div class="row row-body">
					<div class="col-sm-5"></div>
					<div class="col-sm-1">
						<div>
							<i class="fab fa-chrome pr-2" style="color:#00AFF0;"></i>
						</div>
					</div>
					<div class="col-sm-6 row-content">
						<div class="website">
							@if($json['website'])
								<a style="color:#212529;" href="https://{{ $json['website'] }}"><i><span class="wrap">{{ $json['website'] }}</span></i></a><input type="text" class="form-control" id="prof_website" style="display:none;" value="{{ $json['website'] }}">
							@else
								<a style="color:#212529;" href="#website"><i><span class="wrap"><i>--None--</i></span></i></a><input type="text" class="form-control" id="prof_website" style="display:none;" value="">
							@endif
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-6 right-div">
				<div class="row">
					<div class="col-sm-12 pb-3">
						<h4>Location</h4>
					</div>
				</div>
				<div class="row row-body">
					<div class="col-sm-6">
						<span class="font-weight-bold">Province :</span>
					</div>
					<div class="col-sm-6 row-content">
						@if($province)
							<span>{{ucwords(strtolower($province->lgu))}}</span>
							<input type="text" class="form-control" id="prof_loc_province" style="display:none;" value="{{ucwords(strtolower($province->lgu))}}">
						@else
							<span><i>--None--</i></span>
							<input type="text" class="form-control" id="prof_loc_province" style="display:none;" value="">
						@endif
					</div>
				</div>
				<div class="row row-body">
					<div class="col-sm-6">
						<span class="font-weight-bold">City :</span>
					</div>
					<div class="col-sm-6 row-content">
						@if($city)
							<span>{{ucwords(strtolower($city))}}</span>
							<input type="text" class="form-control" id="prof_loc_city" style="display:none;" value="{{ucwords(strtolower($city))}}">
						@else
							<span><i>--None--</i></span>
							<input type="text" class="form-control" id="prof_loc_city" style="display:none;" value="">
						@endif
					</div>
				</div>
				<div class="row row-body">
					<div class="col-sm-6">
						<span class="font-weight-bold">District :</span>
					</div>
					<div class="col-sm-6 row-content">
						@if($district)
							<span>{{ucwords(strtolower($district))}}</span>
							<input type="text" class="form-control" id="prof_loc_district" style="display:none;" value="{{ucwords(strtolower($district))}}">
						@else
							<span><i>--None--</i></span>
							<input type="text" class="form-control" id="prof_loc_district" style="display:none;" value="">
						@endif
					</div>
				</div>
				<div class="row row-body">
					<div class="col-sm-6">
						<span class="font-weight-bold">Municipality :</span>
					</div>
					<div class="col-sm-6 row-content">
						@if($municipality)
							<span>{{ucwords(strtolower($municipality))}}</span>
							<input type="text" class="form-control" id="prof_loc_municipality" style="display:none;" value="{{ucwords(strtolower($municipality))}}">
						@else
							<span><i>--None--</i></span>
							<input type="text" class="form-control" id="prof_loc_municipality" style="display:none;" value="">
						@endif
					</div>
				</div>
				<div class="row mt-5">
					<div class="col-sm-12 pb-3">
						<h4>Chief of Staff</h4>
					</div>
				</div>
				@if($cos)
					<div class="row row-body">
						<div class="col-sm-6">
							<span class="font-weight-bold">Name :</span>
						</div>
						<div class="col-sm-6 row-content">
							<span>{{ucwords(strtolower($cos->name))}}</span>
							<input type="text" class="form-control" id="prof_cos_name" style="display:none;" value="{{ucwords(strtolower($cos->name))}}">
						</div>
					</div>
					<div class="row row-body">
						<div class="col-sm-6">
							<span class="font-weight-bold">Relationship/Position :</span>
						</div>
						<div class="col-sm-6 row-content">
							<span>{{$cos->relationship}}</span>
							<input type="text" class="form-control" id="prof_cos_relationship" style="display:none;" value="{{ucwords(strtolower($cos->relationship))}}">
						</div>
					</div>
					<div class="row row-body">
						<div class="col-sm-6">
							<span class="font-weight-bold">Address :</span>
						</div>
						<div class="col-sm-6 row-content">
							<span>{{$cos->address}}</span>
							<input type="text" class="form-control" id="prof_cos_address" style="display:none;" value="{{$cos->address}}">
						</div>
					</div>
					<div class="row row-body">
						<div class="col-sm-6">
							<span class="font-weight-bold">Contact :</span>
						</div>
						<div class="col-sm-6 row-content">
							<span>{{$cos->contact}}</span>
							<input type="text" class="form-control" id="prof_cos_contact" style="display:none;" value="{{$cos->contact}}">
						</div>
					</div>
					<div class="row row-body">
						<div class="col-sm-6">
							<span class="font-weight-bold">Email :</span>
						</div>
						<div class="col-sm-6 row-content">
							<span class="wrap">{{$cos->email}}</span>
							<input type="text" class="form-control" id="prof_cos_email" style="display:none;" value="{{$cos->email}}">
						</div>
					</div>
				@else
					<div class="row">
						<div class="col-sm-12 text-center">
							<span><i>------None------</i></span>
						</div>
					</div>
				@endif
			</div>
		</div>
		<div class="row comment-part">
			<div class="col-sm-12">
				<textarea class="form-control d-inline" id="prof_comment" rows="4" placeholder="Comments.."></textarea>
			</div>
		</div>
		<div class="row checkbox-part">
			<div class="col-sm-12">
				<div class="col-sm-12 checkbox text-center">
					<label>
						<input type="checkbox" id="prof_cb_lpmember">
						<span class="cr"><i class="cr-icon fa fa-check"></i></span>
						LP member
					</label>
					<label>
						<input type="checkbox" id="prof_cb_paid">
						<span class="cr"><i class="cr-icon fa fa-check"></i></span>
						Paid Membership Dues
					</label>
					<label>
						<input type="checkbox" id="prof_cb_yearmember">
						<span class="cr"><i class="cr-icon fa fa-check"></i></span>
						Member more than a year
					</label>
					<label>
						<input type="checkbox" id="prof_cb_chapmember">
						<span class="cr"><i class="cr-icon fa fa-check"></i></span>
						Chapter Member
					</label>
					<label>
						<input type="checkbox" id="prof_cb_lpsignmanifesto">
						<span class="cr"><i class="cr-icon fa fa-check"></i></span>
						Signed LP Manifesto
					</label>
				</div>
			</div>
		</div>
		<div class="text-center">
			<div class="d-inline pr-2">
				<button type="button" class="btn btn-secondary" id="close_btn" style="display:none;">Close</button>
			</div>
			<div class="d-inline">
				<form id="saveBtnAjax" class="d-inline">
					<button type="button" class="btn btn-success" id="save_btn" style="display:none;">Save</button>
				</form>
			</div>
			<div class="d-inline pr-2">
				<button type="button" class="btn btn-secondary" id="edit_btn">Edit</button>
			</div>
			@if ($candidate->signed_by_lec == 0)
				<div class="d-inline pr-2">
					<button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalApprove" id="approve_btn_1">Approve</button>
				</div>
				<div class="d-inline pr-2">
					<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalReject" id="reject_btn_1">Reject</button>
				</div>
			@endif
		</div>
	</div>
@stop

@section('scripts')
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="{{asset('js/screening/profileData.js')}}"></script>
@stop