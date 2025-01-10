@extends("admin.layouts.dashboard")

@section("css")
				<link rel="stylesheet" href="{{ asset("admin/css/daterangepicker.css") }}">
@stop

@section("content")

				<div class="page-content">
								<div class="container-fluid">

												<!-- start page title -->
												<x-includes.breadcrumb link="promoter.agent.installer.get" :id="$user_id" page="App"
																:list='["Installer"]' />
												<!-- end page title -->

												<div class="row">
																<div class="col-lg-12">
																				<div class="card">
																								<form action="{{ route("promoter.agent.installer.get", $user_id) }}" method="GET">
																												<div class="card-header d-flex justify-content-between align-items-center">
																																<h4 class="card-title mb-0">App Promoted By {{$agent->name}}</h4>
																																<div class="d-flex align-items-center col-auto gap-2">
																																				<a href="{{ route("promoter.agent.installer.export", $user_id) }}?{{ request()->getQueryString() }}" download type="button"
																																												class="btn btn-info add-btn" id="create-btn"><i
																																																class="ri-file-excel-fill me-1 align-bottom"></i> Excel Download</a>
																																				<button type="submit" class="btn btn-primary">
																																								Filter
																																				</button>
																																</div>
																												</div><!-- end card header -->

																												<div class="card-body border-end-0 border-start-0 border border-dashed">
																																{{-- <form action="{{ route("promoter.agent.installer.get", $user_id) }}" method="GET">
                                                                                                                        <!--end row-->
                                                                                                                    </form> --}}
																																<div class="row g-1 align-items-end justify-content-start">
																																				<div class="col-xxl-6 col-lg-6 col-sm-12">
																																								<label class="form-label" for="">Search</label>
																																								<div class="search-box">
																																												<input type="text" class="form-control search" name="filter[search]"
																																																placeholder="Search for anything..." value="{{ $search }}">
																																												<i class="ri-search-line search-icon"></i>
																																								</div>
																																				</div>
                                                                                                                                                <div class="col-xxl-2 col-lg-2 col-sm-12">
																																								<label class="form-label" for="">Role</label>
																																								<div>
																																												<select class="form-control" name="filter[has_role]"
																																																id="has_role">
																																																<option value="all" @if (strpos("all", $role) !== false) selected @endif>all
																																																</option>
																																																@foreach ($roles as $v)
																																																				<option value="{{ $v }}"
																																																								@if (strpos($v, $role) !== false) selected @endif>
																																																								{{ $v }}</option>
																																																@endforeach
																																												</select>
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
																																																				<th class="sort" data-sort="customer_name">Role</th>
																																																				<th class="sort" data-sort="customer_name">Is Approved</th>
																																																				<th class="sort" data-sort="customer_name">Has Placed Order</th>
																																																				<th class="sort" data-sort="customer_name">No. Of Orders</th>
																																																				<th class="sort" data-sort="customer_name">Installed On</th>
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
																																																								<td class="customer_name">{{ $item->current_role }}</td>
                                                                                                                                                                                                                                @if (count($item->app_promoter)>0 && $item->app_promoter[0]->pivot->is_approved)
                                                                                                                                                                                                                                    <td class="status"><span
                                                                                                                                                                                                                                                                    class="badge badge-soft-success text-uppercase">Yes</span>
                                                                                                                                                                                                                                    </td>
                                                                                                                                                                                                                                @else
                                                                                                                                                                                                                                    <td class="status"><span
                                                                                                                                                                                                                                                                    class="badge badge-soft-danger text-uppercase">No</span>
                                                                                                                                                                                                                                    </td>
                                                                                                                                                                                                                                @endif
                                                                                                                                                                                                                                @if ($item->orders_count>0)
                                                                                                                                                                                                                                    <td class="status"><span
                                                                                                                                                                                                                                                                    class="badge badge-soft-success text-uppercase">Yes</span>
                                                                                                                                                                                                                                    </td>
                                                                                                                                                                                                                                @else
                                                                                                                                                                                                                                    <td class="status"><span
                                                                                                                                                                                                                                                                    class="badge badge-soft-danger text-uppercase">No</span>
                                                                                                                                                                                                                                    </td>
                                                                                                                                                                                                                                @endif
                                                                                                                                                                                                                                <td class="customer_name">{{ $item->orders_count }}</td>
																																																								<td class="date">{{ $item->created_at->format("d M Y h:i A") }}</td>
																																																								<td>
																																																												<div class="d-flex gap-2">
                                                                                                                                                                                                                                                            <div class="remove">
                                                                                                                                                                                                                                                                <button class="btn btn-sm btn-warning remove-item-btn"
                                                                                                                                                                                                                                                                                data-link="{{ route("promoter.agent.installer.toggle", [$user_id, $item->id]) }}">
                                                                                                                                                                                                                                                                            @if (count($item->app_promoter)>0 && $item->app_promoter[0]->pivot->is_approved)
                                                                                                                                                                                                                                                                            Disapprove
                                                                                                                                                                                                                                                                            @else
                                                                                                                                                                                                                                                                            Approve
                                                                                                                                                                                                                                                                            @endif
                                                                                                                                                                                                                                                                </button>
                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                            @if(auth()->user()->current_role=='Super-Admin')
                                                                                                                                                                                                                                                                <div class="remove">
                                                                                                                                                                                                                                                                    <button class="btn btn-sm btn-danger remove-item-btn"
                                                                                                                                                                                                                                                                                    data-link="{{ route("promoter.agent.installer.delete", [$user_id, $item->id]) }}">Delete</button>
                                                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                                            @endif
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
@stop
