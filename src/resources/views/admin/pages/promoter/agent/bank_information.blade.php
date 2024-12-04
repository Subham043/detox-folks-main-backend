@extends("admin.layouts.dashboard")

@section("content")

				<div class="page-content">
								<div class="container-fluid">

												<!-- start page title -->
												<x-includes.breadcrumb link="promoter.agent.paginate.get" page="Bank Information" :list='["Update"]' />
												<!-- end page title -->

												<div class="row">
																<x-includes.back-button link="promoter.agent.paginate.get" />
																<div class="col-lg-12">
																				<form id="countryForm" method="post" action="{{ route("promoter.agent.installer_bank.get", $user_id) }}"
																								enctype="multipart/form-data">
																								@csrf
																								<div class="card">
																												<div class="card-header align-items-center d-flex">
																																<h4 class="card-title flex-grow-1 mb-0">Bank Information</h4>
																												</div><!-- end card header -->
																												<div class="card-body">
																																<div class="live-preview">
																																				<div class="row gy-4">
																																								<div class="col-xxl-6 col-md-6">
																																												@include("admin.includes.input", [
																																																"key" => "bank_name",
																																																"label" => "Bank Name",
																																																"value" => old("bank_name") ? old("bank_name") : ($bank->bank_name ?? ''),
																																												])
																																								</div>
																																								<div class="col-xxl-6 col-md-6">
																																												@include("admin.includes.input", [
																																																"key" => "branch_name",
																																																"label" => "Branch Name",
																																																"value" => old("branch_name") ? old("branch_name") : ($bank->branch_name ?? ''),
																																												])
																																								</div>
																																								<div class="col-xxl-6 col-md-6">
																																												@include("admin.includes.input", [
																																																"key" => "account_no",
																																																"label" => "Account Number",
																																																"value" => old("account_no") ? old("account_no") : ($bank->account_no ?? ''),
																																												])
																																								</div>
																																								<div class="col-xxl-6 col-md-6">
																																												@include("admin.includes.input", [
																																																"key" => "account_type",
																																																"label" => "Account Type",
																																																"value" => old("account_type") ? old("account_type") : ($bank->account_type ?? ''),
																																												])
																																								</div>
																																								<div class="col-xxl-6 col-md-6">
																																												@include("admin.includes.input", [
																																																"key" => "ifsc_code",
																																																"label" => "IFSC Code",
																																																"value" => old("ifsc_code") ? old("ifsc_code") : ($bank->ifsc_code ?? ''),
																																												])
																																								</div>
																																								<div class="col-xxl-6 col-md-6">
																																												@include("admin.includes.input", [
																																																"key" => "upi_id",
																																																"label" => "UPI ID",
																																																"value" => old("upi_id") ? old("upi_id") : ($bank->upi_id ?? ''),
																																												])
																																								</div>

																																								<div class="col-xxl-12 col-md-12">
																																												<button type="submit" class="btn btn-primary waves-effect waves-light"
																																																id="submitBtn">Update</button>
																																								</div>

																																				</div>
																																				<!--end row-->
																																</div>

																												</div>
																								</div>
																				</form>
																</div>
																<!--end col-->
												</div>
												<!--end row-->

								</div> <!-- container-fluid -->
				</div><!-- End Page-content -->

@stop
