@extends("admin.layouts.dashboard")

@section("css")
				<link rel="stylesheet" href="{{ asset("admin/css/daterangepicker.css") }}">
@stop

@section("content")

				<div class="page-content">
								<div class="container-fluid">

												<!-- start page title -->
												<x-includes.breadcrumb link="promoter.agent.app_installer.get" page="Installer" :list='["List"]' />
												<!-- end page title -->

                                                <div class="row">
																<div class="col-lg-12">
																				<form id="countryForm" method="post" action="{{ route("promoter.agent.app_installer.post") }}"
																								enctype="multipart/form-data">
																								@csrf
																								<div class="card">
																												<div class="card-header align-items-center d-flex">
																																<h4 class="card-title flex-grow-1 mb-0">Promote</h4>
																												</div><!-- end card header -->
																												<div class="card-body">
																																<div class="live-preview">
																																				<div class="row gy-4">
																																								<div class="col-xxl-12 col-md-12">
																																												@include("admin.includes.input", [
																																																"key" => "email",
																																																"label" => "Email",
																																																"value" => old("email"),
																																												])
																																								</div>

																																								<div class="col-xxl-12 col-md-12">
																																												<button type="submit" class="btn btn-primary waves-effect waves-light"
																																																id="submitBtn">Promote</button>
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

												<div class="row">
																<div class="col-lg-12">
																				<div class="card">
																								<form action="{{ route("promoter.agent.app_installer.get") }}" method="GET">
																												<div class="card-header d-flex justify-content-between align-items-center">
																																<h4 class="card-title mb-0">Installer</h4>
                                                                                                                                <div class="col-auto">
                                                                                                                                    <button type="submit" class="btn btn-primary">
                                                                                                                                                    Filter
                                                                                                                                    </button>
                                                                                                                                </div>
																												</div><!-- end card header -->

																												<div class="card-body border-end-0 border-start-0 border border-dashed">
																																{{-- <form action="{{ route("promoter.agent.app_installer.get") }}" method="GET">
                                                                                                                        <!--end row-->
                                                                                                                    </form> --}}
																																<div class="row g-1 align-items-end justify-content-start">
																																				<div class="col-xxl-8 col-lg-8 col-sm-12">
																																								<label class="form-label" for="">Search</label>
																																								<div class="search-box">
																																												<input type="text" class="form-control search" name="filter[search]"
																																																placeholder="Search for anything..." value="{{ $search }}">
																																												<i class="ri-search-line search-icon"></i>
																																								</div>
																																				</div>
																																				<!--end col-->
																																				<div class="col-xxl-4 col-lg-4 col-sm-12">
																																								<label class="form-label" for="">Date Range</label>
																																								<input type="text" class="form-control" name="filter[has_date]"
																																												placeholder="Pick Date" id="date-range" autocomplete="false">
																																				</div>
																																				<!--end col-->
																																</div>
																												</div>
																								</form>

																								<div class="card-body">
																												<div id="customerList">
																																<div class="table-responsive table-card mb-1">
																																				@if ($installer->total() > 0)
																																								<table class="table-nowrap table align-middle" id="customerTable">
																																												<thead class="table-light">
																																																<tr>
																																																				<th class="sort" data-sort="customer_name">ID</th>
																																																				<th class="sort" data-sort="customer_name">Name</th>
																																																				<th class="sort" data-sort="customer_name">Email</th>
																																																				<th class="sort" data-sort="customer_name">Phone</th>
																																																				<th class="sort" data-sort="date">Created On</th>
																																																				<th class="sort" data-sort="action">Action</th>
																																																</tr>
																																												</thead>
																																												<tbody class="list form-check-all">
																																																@foreach ($installer->items() as $item)
																																																				<tr>
																																																								<td class="customer_name">{{ $item->id }}</td>
																																																								<td class="customer_name">{{ $item->name }}</td>
																																																								<td class="customer_name">{{ $item->email }}</td>
																																																								<td class="customer_name">{{ $item->phone }}</td>
																																																								<td class="date">{{ $item->created_at->diffForHumans() }}</td>
																																																								<td>
																																																												<div class="d-flex gap-2">
                                                                                                                                                                                                                                                    <div class="remove">
                                                                                                                                                                                                                                                                    <button class="btn btn-sm btn-danger remove-item-btn"
                                                                                                                                                                                                                                                                                    data-link="{{ route("promoter.agent.app_installer.delete", [$item->id]) }}">Delete</button>
                                                                                                                                                                                                                                                    </div>
																																																												</div>
																																																								</td>
																																																				</tr>
																																																@endforeach

																																												</tbody>
																																								</table>
																																				@else
																																								<x-includes.no-result />
																																				@endif
																																</div>
																																{{ $installer->withQueryString()->onEachSide(5)->links("admin.includes.pagination") }}
																												</div>
																								</div><!-- end card -->
																				</div>
																				<!-- end col -->
																</div>
																<!-- end col -->
												</div>
												<!-- end row -->

								</div>
				</div>

@stop

@section("javascript")
				<script src="{{ asset("admin/js/pages/jQuery.min.js") }}"></script>
				<script src="{{ asset("admin/js/pages/moment.js") }}"></script>
				<script src="{{ asset("admin/js/pages/daterangepicker.js") }}"></script>
				<script type="text/javascript" nonce="{{ csp_nonce() }}">
								$(function() {
												$('#date-range').daterangepicker({
																opens: 'left',
																autoUpdateInput: false,
																alwaysShowCalendars: true,
																maxDate: moment(),
																locale: {
																				format: 'YYYY-MM-DD'
																}
												});
												$('#date-range').on('apply.daterangepicker', function(ev, picker) {
																$(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format(
																				'YYYY-MM-DD'));
												});
								});
				</script>

                <script type="text/javascript" nonce="{{ csp_nonce() }}">
								// initialize the validation library
								const validation = new JustValidate('#countryForm', {
												errorFieldCssClass: 'is-invalid',
								});
								// apply rules to form fields
								validation
												.addField('#email', [{
																				rule: 'required',
																				errorMessage: 'Email is required',
																},
																{
																				rule: 'email',
																				errorMessage: 'Email is invalid!',
																},
												])
												.onSuccess(async (event) => {
																event.target.submit();
												});
				</script>
@stop
