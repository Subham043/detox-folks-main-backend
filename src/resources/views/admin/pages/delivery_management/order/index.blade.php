@extends("admin.layouts.dashboard")

@section("css")
				<link rel="stylesheet" href="{{ asset("admin/css/daterangepicker.css") }}">
@stop

@section("content")

				<div class="page-content">
								<div class="container-fluid">

												<!-- start page title -->
												<x-includes.breadcrumb link="delivery_management.agent.order.get" page="Order" :list='["List"]' />
												<!-- end page title -->

												<div class="row">
																<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
																				<div class="card card-animate no-box-shadow">
																								<div class="card-body">
																												<div class="d-flex align-items-center">
																																<div class="avatar-sm flex-shrink-0">
																																				<span class="avatar-title bg-soft-success text-success rounded-2 fs-2">
																																								<i class="ri-shopping-bag-line text-success"></i>
																																				</span>
																																</div>
																																<div class="flex-grow-1 ms-3">
																																				<div class="d-flex align-items-center">
																																								<h4 class="fs-4 flex-grow-1 mb-0"><span
																																																class="text-uppercase">{{ $order_count }}</span>
																																								</h4>
																																				</div>
																																				<p class="text-muted mb-0">
																																								Total Orders
																																				</p>
																																</div>
																												</div>
																								</div><!-- end card body -->
																				</div>
																</div>
																<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
																				<div class="card card-animate no-box-shadow">
																								<div class="card-body">
																												<div class="d-flex align-items-center">
																																<div class="avatar-sm flex-shrink-0">
																																				<span class="avatar-title bg-soft-success text-success rounded-2 fs-2">
																																								<i class="ri-thumb-up-line text-success"></i>
																																				</span>
																																</div>
																																<div class="flex-grow-1 ms-3">
																																				<div class="d-flex align-items-center">
																																								<h4 class="fs-4 flex-grow-1 mb-0"><span class="text-uppercase">₹
																																																{{ $earning_count }}</span>
																																								</h4>
																																				</div>
																																				<p class="text-muted mb-0">
																																								Total Earning
																																				</p>
																																</div>
																												</div>
																								</div><!-- end card body -->
																				</div>
																</div>
																<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
																				<div class="card card-animate no-box-shadow">
																								<div class="card-body">
																												<div class="d-flex align-items-center">
																																<div class="avatar-sm flex-shrink-0">
																																				<span class="avatar-title bg-soft-success text-success rounded-2 fs-2">
																																								<i class="ri-thumb-down-line text-success"></i>
																																				</span>
																																</div>
																																<div class="flex-grow-1 ms-3">
																																				<div class="d-flex align-items-center">
																																								<h4 class="fs-4 flex-grow-1 mb-0"><span class="text-uppercase">₹
																																																{{ $loss_count }}</span>
																																								</h4>
																																				</div>
																																				<p class="text-muted mb-0">
																																								Total Loss
																																				</p>
																																</div>
																												</div>
																								</div><!-- end card body -->
																				</div>
																</div>
												</div>

												<div class="row">
																<div class="col-lg-12">
																				<div class="card">
																								<form action="{{ route("delivery_management.agent.order.get") }}" method="GET">
																												<div class="card-header d-flex justify-content-between align-items-center">
																																<h4 class="card-title mb-0">Order</h4>
																																<button type="submit" class="btn btn-primary">
																																				Filter
																																</button>
																												</div><!-- end card header -->

																												<div class="card-body border-end-0 border-start-0 border border-dashed">
																																{{-- <form action="{{ route("delivery_management.agent.order.get") }}" method="GET">
                                                                                                                        <!--end row-->
                                                                                                                    </form> --}}
																																<div class="row g-1 align-items-end justify-content-start">
																																				<div class="col-xxl-auto col-lg-auto col-sm-12">
																																								<label class="form-label" for="">Search</label>
																																								<div class="search-box">
																																												<input type="text" class="form-control search" name="filter[search]"
																																																placeholder="Search for anything..." value="{{ $search }}">
																																												<i class="ri-search-line search-icon"></i>
																																								</div>
																																				</div>
																																				<!--end col-->
																																				<div class="col-xxl-2 col-lg-2 col-sm-12">
																																								<label class="form-label" for="">Payment Mode</label>
																																								<div>
																																												<select class="form-control" name="filter[has_payment_mode]"
																																																id="has_payment_mode">
																																																<option value="all" @if (strpos("all", $payment_mode) !== false) selected @endif>all
																																																</option>
																																																@foreach ($payment_modes as $v)
																																																				<option value="{{ $v }}"
																																																								@if (strpos($v, $payment_mode) !== false) selected @endif>
																																																								{{ $v }}</option>
																																																@endforeach
																																												</select>
																																								</div>
																																				</div>
																																				<div class="col-xxl-2 col-lg-2 col-sm-12">
																																								<label class="form-label" for="">Payment Status</label>
																																								<div>
																																												<select class="form-control" name="filter[has_payment_status]"
																																																id="has_payment_status">
																																																<option value="all" @if (strpos("all", $payment_status) !== false) selected @endif>all
																																																</option>
																																																@foreach ($payment_statuses as $v)
																																																				<option value="{{ $v }}"
																																																								@if (strpos($v, $payment_status) !== false) selected @endif>
																																																								{{ $v }}</option>
																																																@endforeach
																																												</select>
																																								</div>
																																				</div>
																																				<!--end col-->
																																				<div class="col-xxl-2 col-lg-2 col-sm-12">
																																								<label class="form-label" for="">Order Status</label>
																																								<div>
																																												<select class="form-control" name="filter[has_status]" id="has_status">
																																																<option value="all" @if (strpos("all", $order_status) !== false) selected @endif>all
																																																</option>
																																																@foreach ($order_statuses as $v)
																																																				<option value="{{ $v }}"
																																																								@if (strpos($v, $order_status) !== false) selected @endif>
																																																								{{ $v }}</option>
																																																@endforeach
																																												</select>
																																								</div>
																																				</div>
																																				<div class="col-xxl-2 col-lg-2 col-sm-12">
																																								<label class="form-label" for="">Sort</label>
																																								<div>
																																												<select class="form-control" name="sort" id="sort">
																																																<option value="-id" @if (request()->has("sort") && (request()->has("sort") && strpos("-id", request()->input("sort")) !== false)) selected @endif>
																																																				latest</option>
																																																<option value="id" @if (request()->has("sort") && (request()->has("sort") && strpos("id", request()->input("sort")) !== false)) selected @endif>
																																																				oldest</option>
																																																<option value="-total_price"
																																																				@if (request()->has("sort") && (request()->has("sort") && strpos("-total_price", request()->input("sort")) !== false)) selected @endif>higher amount</option>
																																																<option value="total_price"
																																																				@if (request()->has("sort") && (request()->has("sort") && strpos("total_price", request()->input("sort")) !== false)) selected @endif>lower amount</option>
                                                                                                                                                                                                <option value="-delivery_slot"
																																																				@if (request()->has("sort") && (request()->has("sort") && strpos("-delivery_slot", request()->input("sort")) !== false)) selected @endif>delivery slot (z-a)</option>
																																																<option value="delivery_slot"
																																																				@if (request()->has("sort") && (request()->has("sort") && strpos("delivery_slot", request()->input("sort")) !== false)) selected @endif>delivery slot (a-z)</option>
																																																<option value="-pin"
																																																				@if (request()->has("sort") && (request()->has("sort") && strpos("-pin", request()->input("sort")) !== false)) selected @endif>higher pincode</option>
																																																<option value="pin"
																																																				@if (request()->has("sort") && (request()->has("sort") && strpos("pin", request()->input("sort")) !== false)) selected @endif>lower pincode</option>
																																												</select>
																																								</div>
																																				</div>
																																				<!--end col-->
																																				<div class="col-xxl-2 col-lg-2 col-sm-12">
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
																																				@if ($order->total() > 0)
																																								<table class="table-nowrap table align-middle" id="customerTable">
																																												<thead class="table-light">
																																																<tr>
																																																				<th class="sort" data-sort="customer_name">ID</th>
																																																				<th class="sort" data-sort="customer_name">Name</th>
																																																				<th class="sort" data-sort="customer_name">Email</th>
																																																				<th class="sort" data-sort="customer_name">Phone</th>
																																																				<th class="sort" data-sort="customer_name">Products</th>
																																																				<th class="sort" data-sort="customer_name">Total Amount</th>
																																																				<th class="sort" data-sort="customer_name">Delivery Slot</th>
																																																				<th class="sort" data-sort="customer_name">Delivery Pincode</th>
																																																				<th class="sort" data-sort="customer_name">Mode Of Payment</th>
																																																				<th class="sort" data-sort="customer_name">Payment Status</th>
																																																				<th class="sort" data-sort="customer_name">Order Status</th>
																																																				<th class="sort" data-sort="date">Status Updated On</th>
																																																				<th class="sort" data-sort="date">Placed On</th>
																																																				<th class="sort" data-sort="action">Action</th>
																																																</tr>
																																												</thead>
																																												<tbody class="list form-check-all">
																																																@foreach ($order->items() as $item)
																																																				<tr>
																																																								<td class="customer_name">{{ $item->id }}</td>
																																																								<td class="customer_name">{{ $item->name }}</td>
																																																								<td class="customer_name">{{ $item->email }}</td>
																																																								<td class="customer_name">{{ $item->phone }}</td>
																																																								<td class="customer_name">
																																																												@foreach ($item->products as $k => $v)
																																																																<span
																																																																				class="badge bg-success">{{ $v->name }}</span><br />
																																																												@endforeach
																																																								</td>
																																																								<td class="customer_name">&#8377;{{ $item->total_price }}</td>
																																																								<td class="customer_name">{{ $item->delivery_slot ?? "N/A" }}</td>
																																																								<td class="customer_name">{{ $item->pin ?? "N/A" }}</td>
																																																								<td class="customer_name">{{ $item->payment->mode ?? "" }}</td>
																																																								<td class="customer_name">{{ $item->payment->status ?? "" }}</td>
																																																								<td class="customer_name">
																																																												{{ $item->current_status ? $item->current_status->status : "" }}
																																																								</td>
																																																								<td class="customer_name">
																																																												{{ $item->current_status ? $item->current_status->created_at->format("d M Y h:i A") : "" }}
																																																								</td>
																																																								<td class="date">{{ $item->created_at->format("d M Y h:i A") }}</td>
																																																								<td>
																																																												<div class="d-flex gap-2">
																																																																<div class="edit">
																																																																				<a href="{{ route("delivery_management.agent.order_detail.get", $item->id) }}"
																																																																								class="btn btn-sm btn-primary edit-item-btn">View</a>
																																																																</div>
																																																												</div>
																																																												@if ($item->map_information)
																																																																<div class="edit">
																																																																				<a href="https://maps.google.com/maps?daddr={{ $item->map_information->geometry->location->lat }},{{ $item->map_information->geometry->location->lng }}&hl=en"
																																																																								class="btn btn-sm btn-dark edit-item-btn"
																																																																								target="_blank">
																																																																								Map</a>
																																																																</div>
																																																												@endif
																																																								</td>
																																																				</tr>
																																																@endforeach

																																												</tbody>
																																								</table>
																																				@else
																																								<x-includes.no-result />
																																				@endif
																																</div>
																																{{ $order->withQueryString()->onEachSide(5)->links("admin.includes.pagination") }}
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
