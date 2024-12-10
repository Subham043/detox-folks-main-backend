@extends("admin.layouts.dashboard")

@section("css")
				<link rel="stylesheet" href="{{ asset("admin/css/daterangepicker.css") }}">
@stop

@section("content")

				<div class="page-content">
								<div class="container-fluid">

												<!-- start page title -->
												<x-includes.breadcrumb link="delivery_management.agent.assigned_order.get" :id="$user_id" page="Assigned"
																:list='["Order"]' />
												<!-- end page title -->

												<div class="row">
																<x-includes.back-button link="delivery_management.agent.paginate.get" />
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
																																								Total Pending
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
																								<form action="{{ route("delivery_management.agent.assign_order.get", $user_id) }}" method="GET">
																												<div class="card-header d-flex justify-content-between align-items-center">
																																<h4 class="card-title mb-0">Assigned Order</h4>
																																<div class="d-flex align-items-center col-auto gap-2">
																																				<button id="unassign_order" type="button"
																																								class="btn btn-warning d-none">Remove</button>
																																				<button type="submit" class="btn btn-primary">
																																								Filter
																																				</button>
																																</div>
																												</div><!-- end card header -->

																												<div class="card-body border-end-0 border-start-0 border border-dashed">
																																{{-- <form action="{{ route("delivery_management.agent.assign_order.get", $user_id) }}" method="GET">
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
																																																				<th class="sort" data-sort="customer_name">
																																																								<input type="checkbox" class="form-check-input" id="checkAll"
																																																												data-bs-toggle="tooltip" data-bs-original-title="Select All">
																																																				</th>
																																																				<th class="sort" data-sort="customer_name">ID</th>
																																																				<th class="sort" data-sort="customer_name">Name</th>
																																																				<th class="sort" data-sort="customer_name">Email</th>
																																																				<th class="sort" data-sort="customer_name">Phone</th>
																																																				<th class="sort" data-sort="customer_name">Products</th>
																																																				<th class="sort" data-sort="customer_name">Total Amount</th>
																																																				<th class="sort" data-sort="customer_name">Delivery Slot</th>
																																																				<th class="sort" data-sort="customer_name">Mode Of Payment</th>
																																																				<th class="sort" data-sort="customer_name">Payment Status</th>
																																																				<th class="sort" data-sort="customer_name">Order Status</th>
																																																				<th class="sort" data-sort="customer_name">Status Updated On</th>
																																																				<th class="sort" data-sort="date">Placed On</th>
																																																				<th class="sort" data-sort="action">Action</th>
																																																</tr>
																																												</thead>
																																												<tbody class="list form-check-all">
																																																@foreach ($order->items() as $item)
																																																				<tr>
																																																								<td class="customer_name">
																																																												<input type="checkbox" class="form-check-input order-checkbox"
																																																																value="{{ $item->id }}" data-bs-toggle="tooltip"
																																																																data-bs-original-title="Select Order#{{ $item->id }}">
																																																								</td>
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
																																																								<td class="customer_name">{{ $item->payment->mode ?? "" }}</td>
																																																								<td class="customer_name">{{ $item->payment->status ?? "" }}</td>
																																																								<td class="customer_name">
																																																												{{ $item->current_status ? $item->current_status->status : "" }}
																																																								</td>
																																																								<td class="customer_name">
																																																												{{ $item->current_status ? $item->current_status->created_at->diffForHumans() : "" }}
																																																								</td>
																																																								<td class="date">{{ $item->created_at->diffForHumans() }}</td>
																																																								<td>
																																																												<div class="d-flex gap-2">
																																																																<div class="edit">
																																																																				<a href="{{ route("order_admin.detail.get", $item->id) }}"
																																																																								target="_blank"
																																																																								class="btn btn-sm btn-primary edit-item-btn">View</a>
																																																																</div>
																																																																<div class="edit">
																																																																				<a href="{{ route("order_admin.pdf.get", $item->id) }}"
																																																																								class="btn btn-sm btn-secondary edit-item-btn"
																																																																								download>
																																																																								Invoice</a>
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
				<script type="text/javascript" nonce="{{ csp_nonce() }}">
								let unassign_arr = []
								const checkAll = document.getElementById('checkAll');
								checkAll.addEventListener('input', function() {
												const order_checkbox = document.querySelectorAll('.order-checkbox');
												if (checkAll.checked) {
																for (let index = 0; index < order_checkbox.length; index++) {
																				if (order_checkbox[index].value.length > 0) {
																								order_checkbox[index].checked = true
																								if (!unassign_arr.includes(order_checkbox[index].value)) {
																												unassign_arr.push(order_checkbox[index].value);
																								}
																				}
																}
												} else {
																for (let index = 0; index < order_checkbox.length; index++) {
																				if (order_checkbox[index].value.length > 0) {
																								order_checkbox[index].checked = false
																								unassign_arr = [];
																				}
																}
												}
												toggleAssignBtn()
								})


								document.querySelectorAll('.order-checkbox').forEach(el => {
												el.addEventListener('input', function(event) {
																toggleSingleAssignBtn(event)
												})
								});

								const toggleAssignBtn = () => {
												document.querySelectorAll('.order-checkbox').forEach(el => {
																if (el.checked && unassign_arr.length > 0) {
																				document.getElementById('unassign_order').classList.add('d-inline-block')
																				document.getElementById('unassign_order').classList.remove('d-none')
																} else {
																				document.getElementById('unassign_order').classList.add('d-none')
																				document.getElementById('unassign_order').classList.remove('d-inline-block')
																}
												})
								}

								const toggleSingleAssignBtn = (event) => {
												if (!event.target.checked) {
																unassign_arr = unassign_arr.filter(function(item) {
																				return item !== event.target.value
																})
												} else {
																if (!unassign_arr.includes(event.target.value)) {
																				unassign_arr.push(event.target.value)
																}
												}
												if (!event.target.checked && unassign_arr.length < 1) {
																document.getElementById('unassign_order').classList.add('d-none')
																document.getElementById('unassign_order').classList.remove('d-inline-block')
												} else {
																document.getElementById('unassign_order').classList.add('d-inline-block')
																document.getElementById('unassign_order').classList.remove('d-none')
												}
								}


								document.getElementById('unassign_order').addEventListener('click', function() {
												unassign_order_handler()
								})

								const unassign_order_handler = () => {
												iziToast.question({
																timeout: 20000,
																close: false,
																overlay: true,
																displayMode: 'once',
																id: 'question',
																zindex: 999,
																title: 'Hey',
																message: 'Are you sure about that?',
																position: 'center',
																buttons: [
																				['<button><b>YES</b></button>', async function(instance, toast) {

																								instance.hide({
																												transitionOut: 'fadeOut'
																								}, toast, 'button');
																								var submitBtn = document.getElementById('unassign_order');
																								submitBtn.innerHTML = spinner
																								submitBtn.disabled = true;
																								try {

																												const response = await axios.post(
																																'{{ route("delivery_management.agent.unassign_order.post", $user_id) }}', {
																																				orders: unassign_arr
																																})
																												successToast(response.data.message)
																												setInterval(window.location.replace(
																																				"{{ route("delivery_management.agent.assigned_order.get", $user_id) }}"
																																),
																																1500);
																								} catch (error) {
																												if (error?.response?.data?.message) {
																																errorToast(error?.response?.data?.message)
																												}
																								} finally {
																												submitBtn.innerHTML = `
                            Assign
                            `
																												submitBtn.disabled = false;
																								}

																				}, true],
																				['<button>NO</button>', function(instance, toast) {

																								instance.hide({
																												transitionOut: 'fadeOut'
																								}, toast, 'button');

																				}],
																],
																onClosing: function(instance, toast, closedBy) {
																				console.info('Closing | closedBy: ' + closedBy);
																},
																onClosed: function(instance, toast, closedBy) {
																				console.info('Closed | closedBy: ' + closedBy);
																}
												});
								}
				</script>
@stop
