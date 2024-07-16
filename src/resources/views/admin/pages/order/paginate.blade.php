@extends("admin.layouts.dashboard")

@section("content")

				<div class="page-content">
								<div class="container-fluid">

												<!-- start page title -->
												<x-includes.breadcrumb link="order_admin.paginate.get" page="Order" :list='["List"]' />
												<!-- end page title -->

												<div class="row">
																<div class="col-lg-12">
																				<div class="card">
																								<div class="card-header">
																												<h4 class="card-title mb-0">Order</h4>
																								</div><!-- end card header -->

																								<div class="card-body border-end-0 border-start-0 border border-dashed">
																												<form action="{{ route("order_admin.paginate.get") }}" method="GET">
																																<div class="row g-1 align-items-end justify-content-start">
																																				<div class="col-xxl-4 col-lg-4 col-sm-12">
																																								<label class="form-label" for="">Search</label>
																																								<div class="search-box">
																																												<input type="text" class="form-control search" name="filter[search]"
																																																placeholder="Search for anything..." value="{{ $search }}">
																																												<i class="ri-search-line search-icon"></i>
																																								</div>
																																				</div>
																																				<!--end col-->
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
																																				<div class="col-xxl-2 col-lg-2 col-sm-12 mt-3">
																																								<div>
																																												<button type="submit" class="btn btn-primary w-100">
																																																Filter
																																												</button>
																																								</div>
																																				</div>
																																				<!--end col-->
																																</div>
																																<!--end row-->
																												</form>
																								</div>

																								<div class="card-body">
																												<div id="customerList">
																																<div class="table-responsive table-card mb-1 mt-3">
																																				@if ($data->total() > 0)
																																								<table class="table-nowrap table align-middle" id="customerTable">
																																												<thead class="table-light">
																																																<tr>
																																																				<th class="sort" data-sort="customer_name">ID</th>
																																																				<th class="sort" data-sort="customer_name">Name</th>
																																																				<th class="sort" data-sort="customer_name">Email</th>
																																																				<th class="sort" data-sort="customer_name">Phone</th>
																																																				<th class="sort" data-sort="customer_name">Products</th>
																																																				<th class="sort" data-sort="customer_name">Total Amount</th>
																																																				<th class="sort" data-sort="customer_name">Mode Of Payment</th>
																																																				<th class="sort" data-sort="customer_name">Payment Status</th>
																																																				<th class="sort" data-sort="customer_name">Order Status</th>
																																																				<th class="sort" data-sort="date">Placed On</th>
																																																				<th class="sort" data-sort="action">Action</th>
																																																</tr>
																																												</thead>
																																												<tbody class="list form-check-all">
																																																@foreach ($data->items() as $item)
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
																																																								<td class="customer_name">{{ $item->payment->mode ?? "" }}</td>
																																																								<td class="customer_name">{{ $item->payment->status ?? "" }}</td>
																																																								<td class="customer_name">
																																																												{{ $item->statuses->count() > 0 ? $item->statuses[$item->statuses->count() - 1]->status : "" }}
																																																								</td>
																																																								<td class="date">{{ $item->created_at->diffForHumans() }}</td>
																																																								<td>
																																																												<div class="d-flex gap-2">
																																																																<div class="edit">
																																																																				<a href="{{ route("order_admin.detail.get", $item->id) }}"
																																																																								class="btn btn-sm btn-primary edit-item-btn">View</a>
																																																																</div>
																																																																@if (!in_array(\App\Enums\OrderEnumStatus::CANCELLED, $item->statuses->pluck("status")->toArray()))
																																																																				@if (!in_array(\App\Enums\OrderEnumStatus::DELIVERED, $item->statuses->pluck("status")->toArray()))
																																																																								<div class="remove">
																																																																												<button
																																																																																class="btn btn-sm btn-warning remove-item-btn"
																																																																																data-link="{{ route("order_admin.update_order_status.get", $item->id) }}">Update
																																																																																Status</button>
																																																																								</div>
																																																																				@endif
																																																																				@if (
																																																																								$item->payment &&
																																																																												$item->payment->status != \App\Enums\PaymentStatus::PAID &&
																																																																												$item->payment->mode == \App\Enums\PaymentMode::COD)
																																																																								<div class="remove">
																																																																												<button
																																																																																class="btn btn-sm btn-secondary remove-item-btn"
																																																																																data-link="{{ route("order_admin.cancel.get", $item->id) }}">Payment
																																																																																Collected</button>
																																																																								</div>
																																																																				@endif
																																																																				<div class="remove">
																																																																								<button
																																																																												class="btn btn-sm btn-danger remove-item-btn"
																																																																												data-link="{{ route("order_admin.cancel.get", $item->id) }}">Cancel
																																																																												Order</button>
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
																																{{ $data->withQueryString()->onEachSide(5)->links("admin.includes.pagination") }}
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
